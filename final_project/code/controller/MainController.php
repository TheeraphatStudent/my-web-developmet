<?php

namespace FinalProject\Controller;

require_once(__DIR__ . '/RequestController.php');
require_once( __DIR__ . '/../utils/useEvent.php');

// print_r( __DIR__ . '/../utils/useEvent.php');
// echo '<br>';
// print_r( __DIR__);

// require_once(__DIR__ . 'utils/useEvent.php');
use FinalProject\Controller\RequestController;
use FinalProject\Utils\Event;

class MainController
{
    // private const ACCEPT_EVENT = ['checked-in', 'attendee', 'create'];

    // private $mapModel;

    public function __construct()
    {
        // $this->mapModel = new Map();
    }

    public function index()
    {
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
                $auth->logout();
                break;
        }
    }

    public function event($action)
    {
        $target = explode('event.', $action);
        $event = end($target);

        if (in_array($event, EVENT::ACCEPT_EVENT)) {
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
                // print_r($res);
                break;

            case 'event':
                $res = $request->eventHandler($formContent, $data);
                // print_r($res);
                break;

            case 'map':
                $res = $request->mapHandler($formContent, $data);

        }

        return $res;
    }

    public function profile()
    {
        require_once("./view/profile/View.php");
    }

    public function notFound()
    {
        header("HTTP/1.0 404 Not Found");
        require_once("./view/NotFoundView.php");
    }
}
