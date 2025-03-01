<?php

namespace FinalProject\Controller;

require_once(__DIR__ . '/RequestController.php');
require_once(__DIR__ . '/../utils/useEvent.php');

require_once(__DIR__ . '/../model/EventModel.php');

use FinalProject\Model\Init;
use FinalProject\Controller\RequestController;
use FinalProject\Model\Event;
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
        $allEvents = $event->getAllEvents();

        require_once("./view/LandingView.php");
    }

    public function auth($type = 'login')
    {

        switch ($type) {
            case 'login':
                require_once("./view/auth/LoginView.php");
                break;

            case 'register':
                require_once("./view/auth/RegisterView.php");
                break;

            case 'logout':
                // $auth->logout();
                break;
        }
    }

    public function event($action)
    {
        $target = explode('event.', $action);
        $event = end($target);

        $eventModel = new Event($this->connection);
        $allEvents = $eventModel->getAllEvents();

        if (in_array($event, EventUtils::ACCEPT_EVENT)) {
            switch ($event) {
                case 'checked-in':
                    require_once("./view/event/CheckedInView.php");
                    break;
                case 'attendee':
                    require_once("./view/event/AttendeeView.php");
                    break;
                case 'create':
                    require_once("./view/event/CreateView.php");
                    break;
                case 'manage':
                    require_once("./view/event/ManageView.php");
                    break;
                case 'create-test':
                    require_once("./view/event/test.CreateView.php");
                    break;
                case 'edit':
                    $eventId = $_GET['id'];
                    $eventObj = $eventModel->getEventById($eventId);

                    require_once("./view/event/edit.php");
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
                $res = $request->authHandler($formContent, $data);
                break;

            case 'event':
                $res = $request->eventHandler($formContent, $data);
                break;

            case 'map':
                $res = $request->mapHandler($formContent, $data);
                break;
        }

        // print_r($res);
        return $res;
    }

    public function profile()
    {
        require_once("./view/profile/View.php");
    }

    public function notFound()
    {
        header("HTTP/1.0 404 Not Found");
        require_once("./view/NotfoundView.php");
    }
}
