<?php

namespace FinalProject\Controller;

require_once(__DIR__ . '/../model/InitModel.php');
require_once(__DIR__ . '/../model/UserModel.php');
require_once(__DIR__ . '/../model/EventModel.php');
require_once(__DIR__ . '/../model/RegistrationModel.php');
require_once(__DIR__ . '/../model/AttendanceModel.php');
require_once(__DIR__ . '/../model/AuthorModel.php');

require_once(__DIR__ . '/../model/mapModel.php');

require_once(__DIR__ . '/../utils/useResponse.php');

use FinalProject\Model\Attendance;
use FinalProject\Model\Author;
use FinalProject\Model\Init;
use FinalProject\Model\User;
use FinalProject\Model\Event;
use FinalProject\Model\Registration;
use FinalProject\Model\Map;

class RequestController
{
    private $user;
    private $event;
    private $reg;
    private $author;
    private $att;

    private $map;

    public function __construct()
    {
        $inti = new Init();
        $this->user = new User($inti->getConnected());
        $this->event = new Event($inti->getConnected());
        $this->reg = new Registration($inti->getConnected());
        $this->author = new Author($inti->getConnected());
        $this->att = new Attendance($inti->getConnected());

        $this->map = new Map();
    }

    public function userHandler($form, array $data)
    {
        switch ($form) {
            case 'register':
                $username = trim($data["username"]);
                $password = $data["password"];
                $email = $data['email'];

                if ($this->user->getUserByEmail($email)) {
                    return response(status: 301, message: "อีเมลนี้ถูกใช้งานแล้ว!", redirect: '../?action=register', type: 'json');
                }

                $result = $this->user->register($username, $password, $email);

                if ($result['status'] === 201) {
                    return response(status: $result['status'], message: "ยินดีต้อนรับสมาชิกใหม่, สามารถเข้าสู่ระบบได้แล้ว", data: $result, redirect: '../?action=login', type: 'json');
                } else {
                    return response(status: $result['status'], message: "เกิดข้อผิดพลาดในการลงทะเบียน, โปรดลองใหม่อีกครั้ง", redirect: '../?action=login', type: 'json');
                }

            case "login":
                $username = trim($data["username"]);
                $password = $data["password"];

                $result = $this->user->login($username, $password);

                if ($result != null) {
                    $_SESSION['user'] = [
                        "userId" => $result,
                        "username" => $username
                    ];

                    return response(status: 200, message: "เข้าสู่ระบบสำเร็จ!", redirect: '/', type: 'json');
                } else {
                    return response(status: 401, message: "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง!", redirect: '../?action=login', type: 'json');
                }

            case "verify":
                $response = $this->user->getUserByUserId($data["userId"]);
                return response(status: $response['status'], data: ["isFound" => $response['isFound']]);

            case 'profileVerify':
                $isVerify = $this->user->isUserProfileVerify($data['userId']);
                return response(status: $isVerify['status'], message: $isVerify['message'], data: ["isVerify" => $isVerify['isVerify']], type: 'json');

            case 'update':
                $response = $this->user->updateUserById($data);
                return response(status: $response['status'], message: $response['message'], redirect: "../?action=profile");

            case 'reset':
                $response = $this->user->resetPassword(username: $data['username'], email: $data['email'], newPassword: $data['password']);
                return response(status: $response['status'], message: $response['message'], redirect: "../?action=login", type: 'json');
        }
    }

    public function eventHandler($form, array $data)
    {
        $result = null;

        switch ($form) {
            case 'create':
                $result = $this->event->createEvent($data);
                return response(status: $result['status'], message: $result['message'], data: $result, type: 'json', redirect: "../?action=event.manage");

            case 'update':
                $result = $this->event->updateEventById($data);
                return response(status: $result['status'], message: $result['message'], data: $data, type: 'json', redirect: "../?action=event.manage");

            case 'search':
                $result = $this->event->searchEvents(title: $data['looking'], dateStart: $data['dateStarted'], dateEnd: $data['dateEnded']);
                return response(status: 200, message: "Search Work", data: $result, type: 'search');

            case 'search_categories':
                $result = $this->event->searchEvents(dateType: $data['date'] ?? null, eventType: $data['type'] ?? null);
                return response(status: 200, message: "Search Work", data: $result, type: 'search');

            case 'register':
                $verifyAccount = $this->user->isUserProfileVerify($data['userId']);

                if ($verifyAccount['status'] !== 200) {
                    return response(status: $verifyAccount['status'], message: $verifyAccount['message'], redirect: '../?action=event.attendee&id=' . $data['eventId'] . '&joined=' . $data['joined']);
                }

                $eventObj = $this->event->getEventById($data['eventId']);

                if ($eventObj['organizeId'] === $data['userId']) {
                    return response(status: 409, message: "Organizer can't join their own event", redirect: '../?action=event.attendee&id=' . $data['eventId'] . '&joined=' . $data['joined']);
                }

                // เช็คคนเต็ม

                $result = $this->reg->registerEvent(userId: $data['userId'], eventId: $data['eventId']);
                return response(status: $result['status'], message: "Registration successful", data: $result['data'], redirect: '../?action=event.attendee&id=' . $data['eventId'] . '&joined=' . $data['joined']);

            case 'delete':
                $result = $this->event->deleteEventById(userId: $data['userId'], eventId: $data['eventId']);
                return response(status: $result['status'], message: $result['message'], type: 'json');

            default:
                return response(status: 404, message: "Something went wrong!");
        }
    }

    public function registerHandler($form, array $data)
    {
        switch ($form) {
            case 'accept':
                $authorId = $this->author->getAuthorId(userId: $data['authorId'], eventId: $data['eventId']);

                if ($authorId['status'] !== 200) {
                    return response(
                        status: $authorId['status'],
                        message: $authorId['message'],
                        data: [null],
                        redirect: '../?action=event.manage-attend&id=' . $data['eventId']
                    );
                }

                $result = $this->reg->acceptUserRegById(
                    userId: $data['userId'],
                    eventId: $data['eventId'],
                    authorId: $authorId['authorId'],
                    regId: $data['regId']
                );

                // print_r($result);

                return response(
                    status: $result['status'],
                    message: $result['message'],
                    data: $result,
                    redirect: '../?action=event.manage-attend&id=' . $data['eventId']
                );

            case 'reject':
                $response = $this->reg->rejectRegistrationById(
                    regId: $data['regId'],
                    message: $data['message'] ?? null
                );

                // print_r("reject work!");

                return response(
                    status: $response['status'],
                    message: $response['message'],
                    redirect: '../?action=event.manage-attend&id=' . $data['eventId']
                );

            default:
                return response(
                    status: 404,
                    message: "Something went wrong!",
                    redirect: '../?action=event.manage'
                );
        }
    }

    public function attendanceHandler($form, array $data)
    {
        switch ($form) {

            // update status ใน att เป็น reject พร้อมข้อความ
            case 'reject':


                break;

            // update status เป็น accept
            case 'accept':
                $authorId = $this->author->getAuthorId(userId: $data['authorId'], eventId: $data['eventId']);

                if ($authorId['status'] !== 200) {
                    return response(
                        status: $authorId['status'],
                        message: $authorId['message'],
                        data: [null],
                        redirect: '../?action=event.manage-attend&id=' . $data['eventId']
                    );
                }

                $result = $this->att->acceptUserById(userId: $data['userId'], verifyBy: $authorId['authorId'], regId: $data['regId']);

                return response(
                    status: $result['status'],
                    message: $result['message'],
                    redirect: '../?action=event.manage-attend&id=' . $data['eventId']
                );

            default:
                return response(
                    status: 404,
                    message: "Something went wrong!",
                    redirect: '../?action=event.manage-attend&id=' . $data['eventId']
                );
        }
    }

    public function mapHandler($form, array $data)
    {
        switch ($form) {
            case 'get_location';
                $result = $this->map->getLocationByLatLon($data['lat'], $data['lon']);
                return response(status: 200, message: "Get location work", data: $result, type: 'json');
        }
    }
}
