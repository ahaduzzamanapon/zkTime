<?php

include "zklibrary.php";

// Define an array of devices with their IP addresses and ports
$devices = array(
    array("ip" => "192.168.30.14", "port" => 4370),
    array("ip" => "192.168.30.20", "port" => 4370)
    // Add more devices as needed
);

// Function to connect to a device, retrieve attendance data within a time range, and display it
function retrieveAttendance($ip, $port, $startTime, $endTime)
{
    $zk = new ZKLibrary($ip, $port);
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

// Define the start and end times for the time range (in Unix timestamp format)
$startTime = strtotime('2024-03-12 00:00:00');
$endTime = strtotime('2024-03-12 23:59:59');

?>

<?php foreach ($devices as $index => $device): ?>
    <h2>Device <?php echo $index + 1; ?></h2>
    <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
        <thead>
            <tr>
                <td width="25">No</td>
                <td>UID</td>
                <td>ID</td>
                <td>State</td>
                <td>Date/Time</td>
            </tr>
        </thead>

        <tbody>
            <?php
            $attendance = retrieveAttendance($device["ip"], $device["port"], $startTime, $endTime);
            $no = 0;
            foreach ($attendance as $at) {
                $no++;
            ?>
                <tr>
                    <td align="right"><?php echo $no; ?></td>
                    <td><?php echo $at[0]; ?></td>
                    <td><?php echo $at[1]; ?></td>
                    <td><?php echo $at[2]; ?></td>
                    <td><?php echo $at[3]; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php endforeach; ?>
