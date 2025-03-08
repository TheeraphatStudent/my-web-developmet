<?php
// Get Request

namespace FinalProject\Controller;

require_once(__DIR__ . '/../model/InitModel.php');
require_once(__DIR__ . '/../model/UserModel.php');
require_once(__DIR__ . '/../model/EventModel.php');
require_once(__DIR__ . '/../model/RegistrationModel.php');
require_once(__DIR__ . '/../model/mapModel.php');

require_once(__DIR__ . '/../utils/useResponse.php');

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
    private $map;

    public function __construct()
    {
        $inti = new Init();
        $this->user = new User($inti->getConnected());
        $this->event = new Event($inti->getConnected());
        $this->reg = new Registration($inti->getConnected());

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
                    return response(status: 301, message: "Email นี้ถูกใช้งานแล้ว!", redirect: '../?action=register');
                }

                $result = $this->user->register($username, $password, $email);

                if ($result) {
                    return response(status: 200, message: "ลงทะเบียนสำเร็จ", data: $result, redirect: '../?action=login');
                } else {
                    return response(status: 401, message: "เกิดข้อผิดพลาดในการลงทะเบียน", redirect: '../?action=login');
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

                    return response(status: 200, message: "เข้าสู่ระบบสำเร็จ!", redirect: '/');
                } else {
                    return response(status: 401, message: "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง!", redirect: '../?action=login');
                }

            case "verify":
                $response = $this->user->getUserByUserId($data["userId"]);
                return response(status: $response['status'], data: ["isFound" => $response['isFound']]);

            case 'profileVerify':
                $isVerify = $this->user->isUserProfileVerify($data['userId']);
                return response(status: $isVerify['status'], message: $isVerify['message'], data: ["isVerify" => $isVerify['isVerify']], type: 'json');

            case 'update':
                $response = $this->user->updateUserById($data);
                // print_r($data);
                // echo "<br>";
                // print_r($response);

                return response(status: $response['status'], message: $response['message'], redirect: "../?action=profile");
        }
    }

    public function eventHandler($form, array $data)
    {
        $result = null;

        switch ($form) {
            case 'create':
                $result = $this->event->createEvent($data);
                return response(status: 200, message: "Create event complete", data: $result, type: 'json', redirect: "../");
            case 'update':
                $result = $this->event->updateEventById($data);
                return response(status: 200, message: "Edit event complete", data: $result);

            case 'search':
                $result = $this->event->searchEvent(title: $data['looking'], dateStart: $data['dateStarted'], dateEnd: $data['dateEnded']);
                return response(status: 200, message: "Search Work", data: $result, type: 'search');

            case 'search_categories':
                $result = $this->event->searchEventByCategories(dateType: $data['date'] ?? null, eventType: $data['type'] ?? null);
                return response(status: 200, message: "Search Work", data: $result, type: 'search');

            case 'register':
                $verifyAccount = $this->user->isUserProfileVerify($data['userId']);

                if ($verifyAccount['status'] !== 200) {
                    return response(status: $verifyAccount['status'], message: $verifyAccount['message'], redirect: '../?action=event.attendee&id=' . $data['eventId']);
                }

                $eventObj = $this->event->getEventById($data['eventId']);
                if ($eventObj['organizeId'] === $data['userId']) {
                    return response(status: 409, message: "Organizer can't join their own event", redirect: '../?action=event.attendee&id=' . $data['eventId']);
                } else {
                    $result = $this->reg->registerEvent(userId: $data['userId'], eventId: $data['eventId']);
                    return response(status: $result['status'], message: "Registration successful", data: $result['data'], redirect: '../?action=event.attendee&id=' . $data['eventId']);
                }

            default:
                return response(status: 404, message: "Something went wrong!");
        }
    }

    public function registerHandler($form, array $data)
    {
        switch ($form) {
            case 'accept':
                $result = $this->reg->acceptUserRegById(
                    userId: $data['userId'],
                    eventId: $data['eventId'],
                    authorId: $data['authorId'],
                    regId: $data['regId']
                );

                // print_r($result);

                return response(
                    status: 200,
                    message: "Accept user completed",
                    data: $result,
                    redirect: '../?action=event.statistic&id=' . $data['eventId']
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
                    redirect: '../?action=event.statistic&id=' . $data['eventId']
                );

            default:
                return response(
                    status: 404,
                    message: "Something went wrong!",
                    redirect: '../?action=event.manage'
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
