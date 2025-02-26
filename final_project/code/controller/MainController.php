<?php

namespace FinalProject\Controller;

require_once(__DIR__ . '/AuthController.php');

use FinalProject\Controller\AuthController;
use FinalProject\Model\MapModel;
use FinalProject\Model\UserModel;

class MainController
{
    private const ACCEPT_EVENT = ['checked-in', 'attendee', 'create'];

    private $mapModel;
    private $userModel;

    public function __construct()
    {
        $this->mapModel = new MapModel();
        // $this->userModel = new UserModel();
    }

    public function index()
    {
        require_once("./view/LandingView.php");
    }

    public function auth($type = 'login')
    {

        $auth = new AuthController();

        switch ($type) {
            case 'login':
                $auth->login();
                break;

            case 'register':
                $auth->register();
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

        if (in_array($event, self::ACCEPT_EVENT)) {
            $mapApiKey = $this->mapModel->getMapApiKey();

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

    public function request(array $target, array $data)
    {
        print_r($target);
        echo "<br>";
        print_r($data);
        $on = $target['on'];

        $request = new RequestController();

        $res = NULL ;
        switch ($on) {
            case 'user':
                $res = $request->auth($target['form'], $data);
                print_r($res);
                break;
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
