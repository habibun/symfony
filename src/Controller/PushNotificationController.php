<?php

namespace App\Controller;

use App\Service\PushNotification;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PushNotificationController extends AbstractController
{
    /**
     * @Route("/push/notification", name="push_notification")
     */
    public function index(PushNotification $pushNotification): Response
    {
        $response = $pushNotification->sendMessage();
        $return['allresponses'] = $response;
        $return = json_encode($return);

        $data = json_decode($response, true);
        print_r($data);
        $id = $data['id'];
        print_r($id);

        echo "\n\nJSON received:\n";
        echo $return;
        echo "\n";

        exit('exit');
    }

    /**
     * @Route("/push/notification/add", name="push_notification_add")
     */
    public function add(PushNotification $pushNotification): Response
    {
        $response = $pushNotification->addDevice();
        $return['allresponses'] = $response;
        $return = json_encode($return);

        echo "\n\nJSON received:\n";
        echo $return;
        echo "\n";

        exit('exit');
    }
}
