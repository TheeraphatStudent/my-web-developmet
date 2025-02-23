<?php
// Get Request

namespace FinalProject\Controller;

require_once(__DIR__ . '/../model/InitModel.php');
use Init;

require_once(__DIR__ . '/../model/UserModel.php');
use FinalProject\Model\User;

class RequestController
{
    private $user;

    public function __construct()
    {
        $inti = new Init();
        $this->user = new User($inti->getConnected());
    }

    public function auth($form, array $data)
    {
        switch ($form) {
            case 'register':
                $username = trim($data["username"]);
                $password = $data["password"];

                if ($this->user->getUserByUsername($username)) {
                    return ["status" => 301, "message" => "Username นี้ถูกใช้งานแล้ว!"];
                }

                $result = $this->user->register($username, $password);

                if ($result) {
                    return ["status" => 200, "message" => "ลงทะเบียนสำเร็จ!"];
                } else {
                    return ["status" => 401, "message" => "เกิดข้อผิดพลาดในการลงทะเบียน"];
                }

                break;


            default:
                return ["status" => 404, "message" => "Invalid form type"];
        }
    }
}
