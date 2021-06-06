<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class PushNotification
{
    private $params;
    private $appId;
    private $restApiKey;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
        $this->appId = $this->params->get('onesignal_app_id');
        $this->restApiKey = $this->params->get('onesignal_rest_api_key');
    }

    public function sendMessage()
    {
        $content = [
            'en' => 'English Message',
        ];
        $hashes_array = [];
        array_push($hashes_array, [
            'id' => 'like-button',
            'text' => 'Like',
            'icon' => 'http://i.imgur.com/N8SN8ZS.png',
            'url' => 'http://symfony.local',
        ]);
        array_push($hashes_array, [
            'id' => 'like-button-2',
            'text' => 'Like2',
            'icon' => 'http://i.imgur.com/N8SN8ZS.png',
            'url' => 'http://symfony.local',
        ]);
        $fields = [
            'app_id' => $this->appId,
            'included_segments' => [
                'Subscribed Users',
            ],
            'data' => [
                'foo' => 'bar',
            ],
            'contents' => $content,
            'web_buttons' => $hashes_array,
        ];

        $fields = json_encode($fields);
        echo "\nJSON sent:\n";
        echo $fields;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://onesignal.com/api/v1/notifications');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json; charset=utf-8',
            'Authorization: Basic '.$this->restApiKey,
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    public function addDevice()
    {
        $fields = [
            'app_id' => $this->appId,
            'identifier' => $this->restApiKey,
            'language' => 'en',
//            'timezone' => '-28800',
//            'game_version' => '1.0',
//            'device_os' => '9.1.3',
            'device_type' => '5',
//            'device_model' => 'iPhone 8,2',
//            'tags' => ['foo' => 'bar'],
        ];

        $fields = json_encode($fields);
        echo "\nJSON sent:\n";
        echo $fields;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://onesignal.com/api/v1/players');
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }
}
