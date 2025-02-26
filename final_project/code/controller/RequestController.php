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
                    echo '<script>window.location.href="../?action=register"</script>';
                    return ["status" => 301, "message" => "Username นี้ถูกใช้งานแล้ว!"];
                }
                $result = $this->user->register( $username, $password);

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
                    echo '<script>window.location.href="../?action=login"</script>';
                    return ["status" => 401, "message" => "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง"];
                }
                break;
            case "verify":
                $user = $this->user->getUserByUserId($data["userId"]);

                return $user;
                break;
            default:
                return ["status" => 404, "message" => "Invalid form type"];
        }
    }
}
