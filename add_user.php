<?php
include "zklibrary.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // print_r($_POST);
    // exit;
    // Array ( [name] => Ahaduzzaman Apon [role] => 0 [password] => 0 )
    $devices = array(
        array("ip" => "192.168.30.14", "port" => 4370),
        array("ip" => "192.168.30.20", "port" => 4370)
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
    $device= $devices[0];
    $all_users = getUser($device["ip"], $device["port"]);
    $all_uid= array_column($all_users, 0);
    
    $last_uid = max($all_uid);
    $last_uid = $last_uid + 1;

    $name= $_POST['name'];
    $role= $_POST['role'];
    $password= $_POST['password'];


    foreach ($devices as $d) {
        $zk = new zklibrary($d["ip"], $d["port"]);
        $zk->connect();
        $users = $zk->setUser($last_uid, $last_uid, $name, $password, $role);
        $zk->disconnect();
    }

    header('Content-Type: application/json');
    echo '{"success": true}';
}


