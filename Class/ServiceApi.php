<?php

class ServiceApi
{
    protected $url = 'http://localhost:8888/Proyecto1/api/tasks/callSP.php';

    public function __construct()
    {
    }

    public function sendData($data)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,  $this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error en la solicitud cURL: ' . curl_error($ch);
        }
        curl_close($ch);
        return $response;
    }
}
?>