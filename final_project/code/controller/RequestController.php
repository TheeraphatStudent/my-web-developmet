<?php
// Get Request

namespace FinalProject\Controller;

require_once(__DIR__ . '/../model/InitModel.php');
require_once(__DIR__ . '/../model/UserModel.php');
require_once(__DIR__ . '/../model/EventModel.php');
require_once(__DIR__ . '/../model/MapModel.php');

require_once(__DIR__ . '/../utils/useResponse.php');

use FinalProject\Model\Init;
use FinalProject\Model\User;
use FinalProject\Model\Event;
use FinalProject\Model\Map;

class RequestController
{
    private $user;
    private $event;
    private $map;

    public function __construct()
    {
        $inti = new Init();
        $this->user = new User($inti->getConnected());
        $this->event = new Event($inti->getConnected());
        $this->map = new Map();
    }

    public function authHandler($form, array $data)
    {
        switch ($form) {
            case 'register':
                $username = trim($data["username"]);
                $password = $data["password"];

                if ($this->user->getUserByUsername($username)) {
                    echo '<script>window.location.href="../?action=register"</script>';
                    return ["status" => 301, "message" => "Username นี้ถูกใช้งานแล้ว!"];
                }
                $result = $this->user->register($username, $password);
                // echo '<br>';
                // print_r($result);
                // echo '<br>';
                if ($result) {
                    echo '<script>window.location.href="../"</script>';
                    return ["status" => 200, "message" => "ลงทะเบียนสำเร็จ!"];
                } else {
                    return ["status" => 401, "message" => "เกิดข้อผิดพลาดในการลงทะเบียน"];
                }

                break;
            case "login":
                $username = trim($data["username"]);
                $password = $data["password"];

                $result = $this->user->login($username, $password);
                if ($result) {
                    echo '<script>window.location.href="../"</script>';
                    return ["status" => 200, "message" => "เข้าสู่ระบบสำเร็จ!", "data" => $result];
                } else {
                    return ["status" => 401, "message" => "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง"];
                }
                break;
            default:
                return ["status" => 404, "message" => "Invalid form type"];
        }
    }

    public function eventHandler($form, array $data)
    {
        switch ($form) {
            case 'create':
                $result = $this->event->createEvent($data);
                return response(200, "Create event complete", $result);

        }
    }

    public function mapHandler($form, array $data) {
        switch ($form) {
            case 'get_location';
                $result = $this->map->getLocationByLatLon($data['lat'], $data['lon']);
                return response(200, "Get location work", $result);

        }

    }
}
