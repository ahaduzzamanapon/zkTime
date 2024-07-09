<?php
include "zklibrary.php";


    $devices = array(
        array("ip" => "192.168.30.14", "port" => 4370),
        //array("ip" => "192.168.30.20", "port" => 4370)
        // Add more devices as needed
    );

    $user_data = array();

    // Function to connect to a device and retrieve user data
    function getUser($ip, $port)
    {
        $zk = new zklibrary($ip, $port);
        $zk->connect();
        $users = $zk->getUser();
        $zk->disconnect();
        return $users;
    }

    foreach ($devices as $device) {
        $device_user_data = getUser($device["ip"], $device["port"]);
        $user_data = array_merge($user_data, $device_user_data);
        
    }

    header('Content-Type: application/json');
    echo json_encode($user_data);



