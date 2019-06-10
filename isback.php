<?php
$week = intval($_REQUEST["week"]);
include 'conn.php';

if($week > 0) {
    $sql = "SELECT * FROM schedule WHERE week='" . $week . "'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row['front'] == 1) {
                $return = 'front';
                echo $return;
            } else {
                $return = 'back';
                echo $return;
            }
        }
    }
}