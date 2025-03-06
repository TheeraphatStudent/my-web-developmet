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

    public function authHandler($form, array $data)
    {
        switch ($form) {
            case 'register':
                $username = trim($data["username"]);
                $password = $data["password"];
                $email = $data['email'];

                // if ($this->user->getUserByUsername($username)) {
                //     // echo '<script>window.location.href="../?action=register"</script>';
                //     // return ["status" => 301, "message" => "Username นี้ถูกใช้งานแล้ว!"];
                //     return response(status: 301, message: "Username นี้ถูกใช้งานแล้ว!", redirect: '../?action=register');
                // }
                if ($this->user->getUserByEmail($email)) {
                    // echo '<script>window.location.href="../?action=register"</script>';
                    // return ["status" => 301, "message" => "Username นี้ถูกใช้งานแล้ว!"];
                    return response(status: 301, message: "Email นี้ถูกใช้งานแล้ว!", redirect: '../?action=register');
                }

                $result = $this->user->register($username, $password, $email);

                if ($result) {
                    // echo '<script>window.location.href="../"</script>';
                    // return ["status" => 200, "message" => "ลงทะเบียนสำเร็จ!"];
                    return response(status: 200, message: "ลงทะเบียนสำเร็จ", data: $result, redirect: '../?action=login');
                } else {
                    // return ["status" => 401, "message" => "เกิดข้อผิดพลาดในการลงทะเบียน"];
                    return response(status: 401, message: "เกิดข้อผิดพลาดในการลงทะเบียน", redirect: '../?action=login');
                }

            case "login":
                $username = trim($data["username"]);
                $password = $data["password"];

                $result = $this->user->login($username, $password);
                if ($result) {
                    // echo '<script>window.location.href="../"</script>';
                    // return ["status" => 200, "message" => "เข้าสู่ระบบสำเร็จ!", "data" => $result];

                    $_SESSION['user'] = [
                        "userId" => $result,
                        "username" => $username
                    ];


                    return response(status: 200, message: "เข้าสู่ระบบสำเร็จ!", redirect: '/');
                } else {
                    // return ["status" => 401, "message" => "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง"];
                    return response(status: 401, message: "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง!", redirect: '../?action=login');
                }

            case "verify":
                $isFound = $this->user->getUserByUserId($data["userId"])['isFound'];
                return response(status: 200, data: ["isFound" => $isFound]);
        }
    }

    public function eventHandler($form, array $data)
    {
        switch ($form) {
            case 'create':
                $result = $this->event->createEvent($data);
                return response(status: 200, message: "Create event complete", data: $result);
            case 'update':
                $result = $this->event->updateEventById($data);
                return response(status: 200, message: "Edit event complete", data: $result);
            case 'search':
                // location, title, date (start)
                $result = $this->event->searchEvent(title: $data['looking'], dateStart: $data['dateStarted'], dateEnd: $data['dateEnded']);
                return response(status: 200, message: "Search Work", data: $result, type: 'search');
            case 'register':
                $eventObj = $this->event->getEventById($data['eventId']);

                if ($eventObj['organizeId'] == $data['userId']) {
                    return response(status: 409, message: "Organize can't join an self event", redirect: '../?action=event.attendee&id=' . $data['eventId']);
                } else {
                    $result = $this->reg->registerEvent(userId: $data['userId'], eventId: $data['eventId']);
                    return response(status: $result['status'], message: "Register Work", data: $result['data'], redirect: '../?action=event.attendee&id=' . $data['eventId']);
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
                    regId: $data['regId']
                );
                return response(status: 200, message: "Edit event complete", data: $result, redirect: '../?action=event.statistic&id=' . $data['eventId']);

            case 'reject':
                $response = $this->reg->rejectRegistrationById(
                    userId: $data['userId'],
                    eventId: $data['eventId'],
                    regId: $data['regId']
                );

                print_r("reject work!");

                return response();

            default:
                return response(status: 404, message: "Something went wrong!");
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
