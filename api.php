<?php
include "zklibrary.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $date = $_POST['date'];
    $date = date('Y-m-d', strtotime($date));
    $startTime = strtotime($date . ' 00:00:00');
    $endTime = strtotime($date . ' 23:59:59');

    $devices = array(
        array("ip" => "192.168.30.14", "port" => 4370),
        array("ip" => "192.168.30.20", "port" => 4370)
        // Add more devices as needed
    );

    // Function to connect to a device, retrieve attendance data within a time range, and display it
    function retrieveAttendance($ip, $port, $startTime, $endTime)
    {
        $zk = new zklibrary($ip, $port);
        $zk->connect();
        $zk->disableDevice();
        $attendance = $zk->getAttendance();
        $zk->enableDevice();
        $zk->disconnect();

        // Filter attendance data based on the time range
        $filteredAttendance = array();
        foreach ($attendance as $at) {
            $dateTime = strtotime($at[3]);
            if ($dateTime >= $startTime && $dateTime <= $endTime) {
                $filteredAttendance[] = $at;
            }
        }

        return $filteredAttendance;
    }

    $today_data = array();
    foreach ($devices as $index => $device) {
        $attendance = retrieveAttendance($device["ip"], $device["port"], $startTime, $endTime);
        foreach ($attendance as $at) {
            $today_data[] = array(
                'uid' => $at[0],
                'id' => $at[1],
                'state' => $index,
                'time' => $at[3]
            );
        }
    }
}

header('Content-Type: application/json');
echo json_encode($today_data);
?>
