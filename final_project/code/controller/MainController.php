<?php

namespace FinalProject\Controller;

require_once(__DIR__ . '/RequestController.php');
require_once(__DIR__ . '/../utils/useEvent.php');

require_once(__DIR__ . '/../model/EventModel.php');
require_once(__DIR__ . '/../model/RegistrationModel.php');
require_once(__DIR__ . '/../model/AttendanceModel.php');

use FinalProject\Controller\RequestController;
use FinalProject\Model\Attendance;
use FinalProject\Model\Init;
use FinalProject\Model\Event;
use FinalProject\Model\Registration;
use FinalProject\Model\User;

use FinalProject\Utils\Event as EventUtils;

class MainController
{

    private $connection;

    public function __construct()
    {
        $inti = new Init();
        $this->connection = $inti->getConnected();
    }

    public function index()
    {
        $event = new Event($this->connection);

        if (!isset($_SESSION['search']['value'])) {
            $allEvents =  $event->getAllEvents();
        } else {
            $allEvents = $_SESSION['search']['value'];
            unset($_SESSION['search']);
        }

        require_once("./view/LandingView.php");
    }

    public function auth($type = 'login')
    {

        switch ($type) {
            case 'login':
                echo "<script>
                        function togglePasswordVisibility() {
                            const password = document.getElementById('password');
                            if (password.type === 'password') {
                                password.type = 'text';
                            } else {
                                password.type = 'password';
                            }
                        }
                    </script>";

                require_once("./view/auth/LoginView.php");
                break;

            case 'register':
                echo "<script>
                        function togglePasswordVisibility() {
                            const password = document.getElementById('password');
                            if (password.type === 'password') {
                                password.type = 'text';
                            } else {
                                password.type = 'password';
                            }
                        }
                    </script>";

                require_once("./view/auth/RegisterView.php");
                break;

            case 'logout':
                unset($_SESSION['user']);
                header("Location: ../?action=logged-out");
                exit;
        }
    }

    public function event($action)
    {
        $target = explode('event.', $action);
        $event = end($target);

        $eventModel = new Event($this->connection);
        $regModel = new Registration($this->connection);
        $attModel = new Attendance($this->connection);

        $eventId = isset($_GET['id']) ? $_GET['id'] : null;
        $userId = isset($_SESSION['user']) ? $_SESSION['user']['userId'] : null;

        if (in_array($event, EventUtils::ACCEPT_EVENT)) {
            switch ($event) {
                case 'checked-in':
                    $allUserAttendOnEvent = $attModel->getUserWasAcceptRegOnEventById(userId: $userId, eventId: $eventId);

                    require_once("./view/event/CheckedInView.php");
                    break;

                case 'attendee':
                    $regObj = $regModel->getRegisterById(userId: $userId, eventId: $eventId);

                    // print_r($regObj);
                    require_once("./view/event/AttendeeView.php");
                    break;

                case 'create':
                    require_once("./view/event/CreateView.php");
                    break;

                case 'manage':
                    $allEvents = $eventModel->getAllEventsById($userId);

                    require_once("./view/event/ManageView.php");
                    break;

                case 'create-test':
                    require_once("./view/event/test.CreateView.php");
                    break;

                case 'edit':
                    $eventObj = $eventModel->getEventById($eventId);

                    require_once("./view/event/edit.php");
                    break;

                case 'statistic':
                    $allUserReg = $regModel->getUserRegisterByEventAndUserId(userId: $userId, eventId: $eventId);

                    // require_once("./view/event/statistic.php");
                    require_once("./view/event/StatisticView.php");
                    break;
            }
        } else {
            $this->notFound();
        }
    }

    public function request(array $target, array $data = [])
    {
        // print_r($target);
        // echo "<br>";
        // print_r($data);

        $onModel = $target['on'];
        $formContent = $target['form'];

        $request = new RequestController();
        $res = null;

        switch ($onModel) {
            case 'user':
                $res = $request->userHandler($formContent, $data);
                break;

            case 'event':
                $res = $request->eventHandler($formContent, $data);
                break;

            case 'reg':
                $res = $request->registerHandler($formContent, $data);
                break;

            case 'attend':
                $res = $request->attendanceHandler($formContent, $data);
                break;

            case 'map':
                $res = $request->mapHandler($formContent, $data);
                break;
        }

        if (isset($res['type']) && (strpos($res['type'], 'search') !== false)) {
            $_SESSION['search'] = [
                "onSearch" => true,
                "value" => $res['data']['data']
            ];
        }

        return $res;
    }

    // public function logout() {
    //     unset($_SESSION['user']);
    //     echo ('<script> window.reload </script>');

    // }

    public function profile()
    {
        $userModel = new User($this->connection);
        $userObj = ($userModel->getUserByUserId($_SESSION['user']['userId']))['user'];

        require_once("./view/profile/View.php");
    }
    public function mail()
    {
        $event = new Event($this->connection);
        $aboutmail = ($event->getmailbyid($_SESSION['user']['userId']));
        $emailTest = ["1", "2", "3"];

        require_once("./view/mail/view.php");
    }

    public function notFound()
    {
        header("HTTP/1.0 404 Not Found");
        require_once("./view/NotfoundView.php");
    }
}
