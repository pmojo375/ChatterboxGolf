<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Add Round</title>
    <script src="addround.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="main.css?rnd=23">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>

<?php
include 'functions.php';
printNav();
?>

<br>

<?php include 'conn.php'; ?>

<?php

// define variables and set to empty values
$golfer1Err = $weekErr = $g1_score1Err = $g1_score2Err = $g1_score3Err = $g1_score4Err = $g1_score5Err = $g1_score6Err = $g1_score7Err = $g1_score8Err = $g1_score9Err = "";
$golfer1 = $week = $g1_score1 = $g1_score2 = $g1_score3 = $g1_score4 = $g1_score5 = $g1_score6 = $g1_score7 = $g1_score8 = $g1_score9 = "";
$g1_tookMax1 = $g1_tookMax2 = $g1_tookMax3 = $g1_tookMax4 = $g1_tookMax5 = $g1_tookMax6 = $g1_tookMax7 = $g1_tookMax8 = $g1_tookMax9 = 0;

$golfer2Err = $g2_score1Err = $g2_score2Err = $g2_score3Err = $g2_score4Err = $g2_score5Err = $g2_score6Err = $g2_score7Err = $g2_score8Err = $g2_score9Err = "";
$golfer2 = $g2_score1 = $g2_score2 = $g2_score3 = $g2_score4 = $g2_score5 = $g2_score6 = $g2_score7 = $g2_score8 = $g2_score9 = "";
$g2_tookMax1 = $g2_tookMax2 = $g2_tookMax3 = $g2_tookMax4 = $g2_tookMax5 = $g2_tookMax6 = $g2_tookMax7 = $g2_tookMax8 = $g2_tookMax9 = 0;

$golfer3Err = $weekErr = $g3_score1Err = $g3_score2Err = $g3_score3Err = $g3_score4Err = $g3_score5Err = $g3_score6Err = $g3_score7Err = $g3_score8Err = $g3_score9Err = "";
$golfer3 = $week = $g3_score1 = $g3_score2 = $g3_score3 = $g3_score4 = $g3_score5 = $g3_score6 = $g3_score7 = $g3_score8 = $g3_score9 = "";
$g3_tookMax1 = $g3_tookMax2 = $g3_tookMax3 = $g3_tookMax4 = $g3_tookMax5 = $g3_tookMax6 = $g3_tookMax7 = $g3_tookMax8 = $g3_tookMax9 = 0;

$golfer4Err = $weekErr = $g4_score1Err = $g4_score2Err = $g4_score3Err = $g4_score4Err = $g4_score5Err = $g4_score6Err = $g4_score7Err = $g4_score8Err = $g4_score9Err = "";
$golfer4 = $week = $g4_score1 = $g4_score2 = $g4_score3 = $g4_score4 = $g4_score5 = $g4_score6 = $g4_score7 = $g4_score8 = $g4_score9 = "";
$g4_tookMax1 = $g4_tookMax2 = $g4_tookMax3 = $g4_tookMax4 = $g4_tookMax5 = $g4_tookMax6 = $g4_tookMax7 = $g4_tookMax8 = $g4_tookMax9 = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errFree = true;
    if (empty($_POST["golfer1"])) {
        $golfer1Err = "Please select a golfer!";
        $errFree = false;
    } else {
        $golfer1 = test_input($_POST["golfer1"]);
    }

    if (empty($_POST["golfer2"])) {
        $golfer2Err = "Please select a golfer!";
        $errFree = false;
    } else {
        $golfer2 = test_input($_POST["golfer2"]);
    }

    if (empty($_POST["golfer3"])) {
        $golfer3Err = "Please select a golfer!";
        $errFree = false;
    } else {
        $golfer3 = test_input($_POST["golfer3"]);
    }

    if (empty($_POST["golfer4"])) {
        $golfer4Err = "Please select a golfer!";
        $errFree = false;
    } else {
        $golfer4 = test_input($_POST["golfer4"]);
    }

    if (empty($_POST["week"])) {
        $weekErr = "Week is required";
        $errFree = false;
    } else {
        $week = test_input($_POST["week"]);
    }

    if (empty($_POST["g1_h1"])) {
        $g1_score1Err = "Please enter a score";
        $errFree = false;
    } else {
        $g1_score1 = test_input($_POST["g1_h1"]);
    }
    if (empty($_POST["g2_h1"])) {
        $g2_score1Err = "Please enter a score";
        $errFree = false;
    } else {
        $g2_score1 = test_input($_POST["g2_h1"]);
    }
    if (empty($_POST["g3_h1"])) {
        $g3_score1Err = "Please enter a score";
        $errFree = false;
    } else {
        $g3_score1 = test_input($_POST["g3_h1"]);
    }
    if (empty($_POST["g4_h1"])) {
        $g4_score1Err = "Please enter a score";
        $errFree = false;
    } else {
        $g4_score1 = test_input($_POST["g4_h1"]);
    }

    if (empty($_POST["g1_h2"])) {
        $g1_score2Err = "Please enter a score";
        $errFree = false;
    } else {
        $g1_score2 = test_input($_POST["g1_h2"]);
    }
    if (empty($_POST["g2_h2"])) {
        $g2_score2Err = "Please enter a score";
        $errFree = false;
    } else {
        $g2_score2 = test_input($_POST["g2_h2"]);
    }
    if (empty($_POST["g3_h2"])) {
        $g3_score2Err = "Please enter a score";
        $errFree = false;
    } else {
        $g3_score2 = test_input($_POST["g3_h2"]);
    }
    if (empty($_POST["g4_h2"])) {
        $g4_score2Err = "Please enter a score";
        $errFree = false;
    } else {
        $g4_score2 = test_input($_POST["g4_h2"]);
    }

    if (empty($_POST["g1_h3"])) {
        $g1_score3Err = "Please enter a score";
        $errFree = false;
    } else {
        $g1_score3 = test_input($_POST["g1_h3"]);
    }
    if (empty($_POST["g2_h3"])) {
        $g2_score3Err = "Please enter a score";
        $errFree = false;
    } else {
        $g2_score3 = test_input($_POST["g2_h3"]);
    }
    if (empty($_POST["g3_h3"])) {
        $g3_score3Err = "Please enter a score";
        $errFree = false;
    } else {
        $g3_score3 = test_input($_POST["g3_h3"]);
    }
    if (empty($_POST["g4_h3"])) {
        $g4_score3Err = "Please enter a score";
        $errFree = false;
    } else {
        $g4_score3 = test_input($_POST["g4_h3"]);
    }

    if (empty($_POST["g1_h4"])) {
        $g1_score4Err = "Please enter a score";
        $errFree = false;
    } else {
        $g1_score4 = test_input($_POST["g1_h4"]);
    }
    if (empty($_POST["g2_h4"])) {
        $g2_score4Err = "Please enter a score";
        $errFree = false;
    } else {
        $g2_score4 = test_input($_POST["g2_h4"]);
    }
    if (empty($_POST["g3_h4"])) {
        $g3_score4Err = "Please enter a score";
        $errFree = false;
    } else {
        $g3_score4 = test_input($_POST["g3_h4"]);
    }
    if (empty($_POST["g4_h4"])) {
        $g4_score4Err = "Please enter a score";
        $errFree = false;
    } else {
        $g4_score4 = test_input($_POST["g4_h4"]);
    }

    if (empty($_POST["g1_h5"])) {
        $g1_score5Err = "Please enter a score";
        $errFree = false;
    } else {
        $g1_score5 = test_input($_POST["g1_h5"]);
    }
    if (empty($_POST["g2_h5"])) {
        $g2_score5Err = "Please enter a score";
        $errFree = false;
    } else {
        $g2_score5 = test_input($_POST["g2_h5"]);
    }
    if (empty($_POST["g3_h5"])) {
        $g3_score5Err = "Please enter a score";
        $errFree = false;
    } else {
        $g3_score5 = test_input($_POST["g3_h5"]);
    }
    if (empty($_POST["g4_h5"])) {
        $g4_score5Err = "Please enter a score";
        $errFree = false;
    } else {
        $g4_score5 = test_input($_POST["g4_h5"]);
    }

    if (empty($_POST["g1_h6"])) {
        $g1_score6Err = "Please enter a score";
        $errFree = false;
    } else {
        $g1_score6 = test_input($_POST["g1_h6"]);
    }
    if (empty($_POST["g2_h6"])) {
        $g2_score6Err = "Please enter a score";
        $errFree = false;
    } else {
        $g2_score6 = test_input($_POST["g2_h6"]);
    }
    if (empty($_POST["g3_h6"])) {
        $g3_score6Err = "Please enter a score";
        $errFree = false;
    } else {
        $g3_score6 = test_input($_POST["g3_h6"]);
    }
    if (empty($_POST["g4_h6"])) {
        $g4_score6Err = "Please enter a score";
        $errFree = false;
    } else {
        $g4_score6 = test_input($_POST["g4_h6"]);
    }

    if (empty($_POST["g1_h7"])) {
        $g1_score7Err = "Please enter a score";
        $errFree = false;
    } else {
        $g1_score7 = test_input($_POST["g1_h7"]);
    }
    if (empty($_POST["g2_h7"])) {
        $g2_score7Err = "Please enter a score";
        $errFree = false;
    } else {
        $g2_score7 = test_input($_POST["g2_h7"]);
    }
    if (empty($_POST["g3_h7"])) {
        $g3_score7Err = "Please enter a score";
        $errFree = false;
    } else {
        $g3_score7 = test_input($_POST["g3_h7"]);
    }
    if (empty($_POST["g4_h7"])) {
        $g4_score7Err = "Please enter a score";
        $errFree = false;
    } else {
        $g4_score7 = test_input($_POST["g4_h7"]);
    }

    if (empty($_POST["g1_h8"])) {
        $g1_score8Err = "Please enter a score";
        $errFree = false;
    } else {
        $g1_score8 = test_input($_POST["g1_h8"]);
    }
    if (empty($_POST["g2_h8"])) {
        $g2_score8Err = "Please enter a score";
        $errFree = false;
    } else {
        $g2_score8 = test_input($_POST["g2_h8"]);
    }
    if (empty($_POST["g3_h8"])) {
        $g3_score8Err = "Please enter a score";
        $errFree = false;
    } else {
        $g3_score8 = test_input($_POST["g3_h8"]);
    }
    if (empty($_POST["g4_h8"])) {
        $g4_score8Err = "Please enter a score";
        $errFree = false;
    } else {
        $g4_score8 = test_input($_POST["g4_h8"]);
    }

    if (empty($_POST["g1_h9"])) {
        $g1_score9Err = "Please enter a score";
        $errFree = false;
    } else {
        $g1_score9 = test_input($_POST["g1_h9"]);
    }
    if (empty($_POST["g2_h9"])) {
        $g2_score9Err = "Please enter a score";
        $errFree = false;
    } else {
        $g2_score9 = test_input($_POST["g2_h9"]);
    }
    if (empty($_POST["g3_h9"])) {
        $g3_score9Err = "Please enter a score";
        $errFree = false;
    } else {
        $g3_score9 = test_input($_POST["g3_h9"]);
    }
    if (empty($_POST["g4_h9"])) {
        $g4_score9Err = "Please enter a score";
        $errFree = false;
    } else {
        $g4_score9 = test_input($_POST["g4_h9"]);
    }


    if (isset($_POST["g1_tookMax1"])) {
        $g1_tookMax1 = 1;
    }
    if (isset($_POST["g1_tookMax2"])) {
        $g1_tookMax2 = 1;
    }
    if (isset($_POST["g1_tookMax3"])) {
        $g1_tookMax3 = 1;
    }
    if (isset($_POST["g1_tookMax4"])) {
        $g1_tookMax4 = 1;
    }
    if (isset($_POST["g1_tookMax5"])) {
        $g1_tookMax5 = 1;
    }
    if (isset($_POST["g1_tookMax6"])) {
        $g1_tookMax6 = 1;
    }
    if (isset($_POST["g1_tookMax7"])) {
        $g1_tookMax7 = 1;
    }
    if (isset($_POST["g1_tookMax8"])) {
        $g1_tookMax8 = 1;
    }
    if (isset($_POST["g1_tookMax9"])) {
        $g1_tookMax9 = 1;
    }

    if (isset($_POST["g2_tookMax1"])) {
        $g2_tookMax1 = 1;
    }
    if (isset($_POST["g2_tookMax2"])) {
        $g2_tookMax2 = 1;
    }
    if (isset($_POST["g2_tookMax3"])) {
        $g2_tookMax3 = 1;
    }
    if (isset($_POST["g2_tookMax4"])) {
        $g2_tookMax4 = 1;
    }
    if (isset($_POST["g2_tookMax5"])) {
        $g2_tookMax5 = 1;
    }
    if (isset($_POST["g2_tookMax6"])) {
        $g2_tookMax6 = 1;
    }
    if (isset($_POST["g2_tookMax7"])) {
        $g2_tookMax7 = 1;
    }
    if (isset($_POST["g2_tookMax8"])) {
        $g2_tookMax8 = 1;
    }
    if (isset($_POST["g2_tookMax9"])) {
        $g2_tookMax9 = 1;
    }

    if (isset($_POST["g3_tookMax1"])) {
        $g3_tookMax1 = 1;
    }
    if (isset($_POST["g3_tookMax2"])) {
        $g3_tookMax2 = 1;
    }
    if (isset($_POST["g3_tookMax3"])) {
        $g3_tookMax3 = 1;
    }
    if (isset($_POST["g3_tookMax4"])) {
        $g3_tookMax4 = 1;
    }
    if (isset($_POST["g3_tookMax5"])) {
        $g3_tookMax5 = 1;
    }
    if (isset($_POST["g3_tookMax6"])) {
        $g3_tookMax6 = 1;
    }
    if (isset($_POST["g3_tookMax7"])) {
        $g3_tookMax7 = 1;
    }
    if (isset($_POST["g3_tookMax8"])) {
        $g3_tookMax8 = 1;
    }
    if (isset($_POST["g3_tookMax9"])) {
        $g3_tookMax9 = 1;
    }

    if (isset($_POST["g4_tookMax1"])) {
        $g4_tookMax1 = 1;
    }
    if (isset($_POST["g4_tookMax2"])) {
        $g4_tookMax2 = 1;
    }
    if (isset($_POST["g4_tookMax3"])) {
        $g4_tookMax3 = 1;
    }
    if (isset($_POST["g4_tookMax4"])) {
        $g4_tookMax4 = 1;
    }
    if (isset($_POST["g4_tookMax5"])) {
        $g4_tookMax5 = 1;
    }
    if (isset($_POST["g4_tookMax6"])) {
        $g4_tookMax6 = 1;
    }
    if (isset($_POST["g4_tookMax7"])) {
        $g4_tookMax7 = 1;
    }
    if (isset($_POST["g4_tookMax8"])) {
        $g4_tookMax8 = 1;
    }
    if (isset($_POST["g4_tookMax9"])) {
        $g4_tookMax9 = 1;
    }

    if ($errFree) {

        $isBack = !isFront($week, $conn);

        $sql = "INSERT INTO scores (golfer, hole, score, tookMax, week) VALUES ('" . $golfer1 . "','" . getHoleNumber(1, $isBack) . "','" . $g1_score1 . "','" . $g1_tookMax1 . "','" . $week . "'), ";
        $sql .= "('" . $golfer1 . "','" . getHoleNumber(2, $isBack) . "','" . $g1_score2 . "','" . $g1_tookMax2 . "','" . $week . "'), ";
        $sql .= "('" . $golfer1 . "','" . getHoleNumber(3, $isBack) . "','" . $g1_score3 . "','" . $g1_tookMax3 . "','" . $week . "'), ";
        $sql .= "('" . $golfer1 . "','" . getHoleNumber(4, $isBack) . "','" . $g1_score4 . "','" . $g1_tookMax4 . "','" . $week . "'), ";
        $sql .= "('" . $golfer1 . "','" . getHoleNumber(5, $isBack) . "','" . $g1_score5 . "','" . $g1_tookMax5 . "','" . $week . "'), ";
        $sql .= "('" . $golfer1 . "','" . getHoleNumber(6, $isBack) . "','" . $g1_score6 . "','" . $g1_tookMax6 . "','" . $week . "'), ";
        $sql .= "('" . $golfer1 . "','" . getHoleNumber(7, $isBack) . "','" . $g1_score7 . "','" . $g1_tookMax7 . "','" . $week . "'), ";
        $sql .= "('" . $golfer1 . "','" . getHoleNumber(8, $isBack) . "','" . $g1_score8 . "','" . $g1_tookMax8 . "','" . $week . "'), ";
        $sql .= "('" . $golfer1 . "','" . getHoleNumber(9, $isBack) . "','" . $g1_score9 . "','" . $g1_tookMax9 . "','" . $week . "')";

        if (mysqli_query($conn, $sql)) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

        $sql = "INSERT INTO scores (golfer, hole, score, tookMax, week) VALUES ('" . $golfer2 . "','" . getHoleNumber(1, $isBack) . "','" . $g2_score1 . "','" . $g2_tookMax1 . "','" . $week . "'), ";
        $sql .= "('" . $golfer2 . "','" . getHoleNumber(2, $isBack) . "','" . $g2_score2 . "','" . $g2_tookMax2 . "','" . $week . "'), ";
        $sql .= "('" . $golfer2 . "','" . getHoleNumber(3, $isBack) . "','" . $g2_score3 . "','" . $g2_tookMax3 . "','" . $week . "'), ";
        $sql .= "('" . $golfer2 . "','" . getHoleNumber(4, $isBack) . "','" . $g2_score4 . "','" . $g2_tookMax4 . "','" . $week . "'), ";
        $sql .= "('" . $golfer2 . "','" . getHoleNumber(5, $isBack) . "','" . $g2_score5 . "','" . $g2_tookMax5 . "','" . $week . "'), ";
        $sql .= "('" . $golfer2 . "','" . getHoleNumber(6, $isBack) . "','" . $g2_score6 . "','" . $g2_tookMax6 . "','" . $week . "'), ";
        $sql .= "('" . $golfer2 . "','" . getHoleNumber(7, $isBack) . "','" . $g2_score7 . "','" . $g2_tookMax7 . "','" . $week . "'), ";
        $sql .= "('" . $golfer2 . "','" . getHoleNumber(8, $isBack) . "','" . $g2_score8 . "','" . $g2_tookMax8 . "','" . $week . "'), ";
        $sql .= "('" . $golfer2 . "','" . getHoleNumber(9, $isBack) . "','" . $g2_score9 . "','" . $g2_tookMax9 . "','" . $week . "')";

        if (mysqli_query($conn, $sql)) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

        $sql = "INSERT INTO scores (golfer, hole, score, tookMax, week) VALUES ('" . $golfer3 . "','" . getHoleNumber(1, $isBack) . "','" . $g3_score1 . "','" . $g3_tookMax1 . "','" . $week . "'), ";
        $sql .= "('" . $golfer3 . "','" . getHoleNumber(2, $isBack) . "','" . $g3_score2 . "','" . $g3_tookMax2 . "','" . $week . "'), ";
        $sql .= "('" . $golfer3 . "','" . getHoleNumber(3, $isBack) . "','" . $g3_score3 . "','" . $g3_tookMax3 . "','" . $week . "'), ";
        $sql .= "('" . $golfer3 . "','" . getHoleNumber(4, $isBack) . "','" . $g3_score4 . "','" . $g3_tookMax4 . "','" . $week . "'), ";
        $sql .= "('" . $golfer3 . "','" . getHoleNumber(5, $isBack) . "','" . $g3_score5 . "','" . $g3_tookMax5 . "','" . $week . "'), ";
        $sql .= "('" . $golfer3 . "','" . getHoleNumber(6, $isBack) . "','" . $g3_score6 . "','" . $g3_tookMax6 . "','" . $week . "'), ";
        $sql .= "('" . $golfer3 . "','" . getHoleNumber(7, $isBack) . "','" . $g3_score7 . "','" . $g3_tookMax7 . "','" . $week . "'), ";
        $sql .= "('" . $golfer3 . "','" . getHoleNumber(8, $isBack) . "','" . $g3_score8 . "','" . $g3_tookMax8 . "','" . $week . "'), ";
        $sql .= "('" . $golfer3 . "','" . getHoleNumber(9, $isBack) . "','" . $g3_score9 . "','" . $g3_tookMax9 . "','" . $week . "')";

        if (mysqli_query($conn, $sql)) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

        $sql = "INSERT INTO scores (golfer, hole, score, tookMax, week) VALUES ('" . $golfer4 . "','" . getHoleNumber(1, $isBack) . "','" . $g4_score1 . "','" . $g4_tookMax1 . "','" . $week . "'), ";
        $sql .= "('" . $golfer4 . "','" . getHoleNumber(2, $isBack) . "','" . $g4_score2 . "','" . $g4_tookMax2 . "','" . $week . "'), ";
        $sql .= "('" . $golfer4 . "','" . getHoleNumber(3, $isBack) . "','" . $g4_score3 . "','" . $g4_tookMax3 . "','" . $week . "'), ";
        $sql .= "('" . $golfer4 . "','" . getHoleNumber(4, $isBack) . "','" . $g4_score4 . "','" . $g4_tookMax4 . "','" . $week . "'), ";
        $sql .= "('" . $golfer4 . "','" . getHoleNumber(5, $isBack) . "','" . $g4_score5 . "','" . $g4_tookMax5 . "','" . $week . "'), ";
        $sql .= "('" . $golfer4 . "','" . getHoleNumber(6, $isBack) . "','" . $g4_score6 . "','" . $g4_tookMax6 . "','" . $week . "'), ";
        $sql .= "('" . $golfer4 . "','" . getHoleNumber(7, $isBack) . "','" . $g4_score7 . "','" . $g4_tookMax7 . "','" . $week . "'), ";
        $sql .= "('" . $golfer4 . "','" . getHoleNumber(8, $isBack) . "','" . $g4_score8 . "','" . $g4_tookMax8 . "','" . $week . "'), ";
        $sql .= "('" . $golfer4 . "','" . getHoleNumber(9, $isBack) . "','" . $g4_score9 . "','" . $g4_tookMax9 . "','" . $week . "')";

        if (mysqli_query($conn, $sql)) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>
<div class="container">
    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post"
          oninput="g1_gross.value=parseInt(g1_h1.value)+parseInt(g1_h2.value)+parseInt(g1_h3.value)+parseInt(g1_h4.value)+parseInt(g1_h5.value)+parseInt(g1_h6.value)+parseInt(g1_h7.value)+parseInt(g1_h8.value)+parseInt(g1_h9.value);
		  g2_gross.value=parseInt(g2_h1.value)+parseInt(g2_h2.value)+parseInt(g2_h3.value)+parseInt(g2_h4.value)+parseInt(g2_h5.value)+parseInt(g2_h6.value)+parseInt(g2_h7.value)+parseInt(g2_h8.value)+parseInt(g2_h9.value);
		  g3_gross.value=parseInt(g3_h1.value)+parseInt(g3_h2.value)+parseInt(g3_h3.value)+parseInt(g3_h4.value)+parseInt(g3_h5.value)+parseInt(g3_h6.value)+parseInt(g3_h7.value)+parseInt(g3_h8.value)+parseInt(g3_h9.value);
		  g4_gross.value=parseInt(g4_h1.value)+parseInt(g4_h2.value)+parseInt(g4_h3.value)+parseInt(g4_h4.value)+parseInt(g4_h5.value)+parseInt(g4_h6.value)+parseInt(g4_h7.value)+parseInt(g4_h8.value)+parseInt(g4_h9.value)">
        <legend>Add Round:</legend>
        <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <p>After selecting a golfer and week, enter the scores below. Check the box on the right of the
                            score entry to indicate that the golfer shot max and picked up.</p>
                    </div>
                </div>
            </div>
        <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <select name="week" id="week" class="form-control" onchange="checkBack(this.value)">
                            <option value="">Select Week</option>
                            <option value="1">Week 1</option>
                            <option value="2">Week 2</option>
                            <option value="3">Week 3</option>
                            <option value="4">Week 4</option>
                            <option value="5">Week 5</option>
                            <option value="6">Week 6</option>
                            <option value="7">Week 7</option>
                            <option value="8">Week 8</option>
                            <option value="9">Week 9</option>
                            <option value="10">Week 10</option>
                            <option value="11">Week 11</option>
                            <option value="12">Week 12</option>
                            <option value="13">Week 13</option>
                            <option value="14">Week 14</option>
                            <option value="15">Week 15</option>
                            <option value="16">Week 16</option>
                            <option value="17">Week 17</option>
                            <option value="18">Week 18</option>
                            <option value="19">Week 19</option>
                            <option value="20">Week 20</option>
                        </select><span class="error"> <?php echo $weekErr; ?></span>
                    </div>
                </div>
            </div>
        <div class="row">
                <div class="col-md-3">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <select name="golfer1" class="form-control">
                                    <option value="">Select Golfer</option>
                                    <optgroup label="Members">
                                        <?php
                                        $sql = "SELECT * FROM golfers";
                                        $result = mysqli_query($conn, $sql);
                                        $subs = Array();

                                        if (mysqli_num_rows($result) > 0) {

                                            while ($row = mysqli_fetch_assoc($result)) {
                                                if ($row['team'] != 0) {
                                                    echo "<option value=\"" . $row['id'] . "\">" . $row['name'] . "</option>";
                                                } else {
                                                    $subs[$row['id']] = $row['name'];
                                                }
                                            }

                                            echo "</optgroup>";
                                            echo "<optgroup label=\"Subs\">";

                                            foreach ($subs as $id => $name) {
                                                echo "<option value=\"" . $id . "\">" . $name . "</option>";
                                            }

                                        } else {
                                            echo "0 results";
                                        }

                                        ?>
                                    </optgroup>
                                </select><span class="error"> <?php echo $golfer1Err; ?></span>
                            </div>
                            <div class="form-group">

                                <div class="input-group mb-2 mr-sm-2">
                                    <input class="form-control" type="number" name="g1_h1">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <input type="checkbox" name="g1_tookMax1" value="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group mb-2 mr-sm-2">
                                    <input class="form-control" type="number" name="g1_h2">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <input type="checkbox" name="g1_tookMax2" value="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group mb-2 mr-sm-2">
                                    <input class="form-control" type="number" name="g1_h3">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <input type="checkbox" name="g1_tookMax3" value="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group mb-2 mr-sm-2">
                                    <input class="form-control" type="number" name="g1_h4">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <input type="checkbox" name="g1_tookMax4" value="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group mb-2 mr-sm-2">
                                    <input class="form-control" type="number" name="g1_h5">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <input type="checkbox" name="g1_tookMax5" value="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group mb-2 mr-sm-2">
                                    <input class="form-control" type="number" name="g1_h6">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <input type="checkbox" name="g1_tookMax6" value="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group mb-2 mr-sm-2">
                                    <input class="form-control" type="number" name="g1_h7">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <input type="checkbox" name="g1_tookMax7" value="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group mb-2 mr-sm-2">
                                    <input class="form-control" type="number" name="g1_h8">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <input type="checkbox" name="g1_tookMax8" value="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group mb-2 mr-sm-2">
                                    <input class="form-control" type="number" name="g1_h9">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <input type="checkbox" name="g1_tookMax9" value="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    Gross:
                                    <output name="g1_gross"
                                            for="g1_h1 g1_h2 g1_h3 g1_h4 g1_h5 g1_h6 g1_h7 g1_h8 g1_h9"></output>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <select name="golfer2" class="form-control">
                                    <option value="">Select Golfer</option>
                                    <optgroup label="Members">
                                        <?php
                                        $sql = "SELECT * FROM golfers";
                                        $result = mysqli_query($conn, $sql);
                                        $subs = Array();

                                        if (mysqli_num_rows($result) > 0) {

                                            while ($row = mysqli_fetch_assoc($result)) {
                                                if ($row['team'] != 0) {
                                                    echo "<option value=\"" . $row['id'] . "\">" . $row['name'] . "</option>";
                                                } else {
                                                    $subs[$row['id']] = $row['name'];
                                                }
                                            }

                                            echo "</optgroup>";
                                            echo "<optgroup label=\"Subs\">";

                                            foreach ($subs as $id => $name) {
                                                echo "<option value=\"" . $id . "\">" . $name . "</option>";
                                            }

                                        } else {
                                            echo "0 results";
                                        }

                                        ?>
                                    </optgroup>
                                </select><span class="error"> <?php echo $golfer2Err; ?></span>
                            </div>
                            <div class="form-group">
                                <div class="input-group mb-2 mr-sm-2">
                                    <input class="form-control" type="number" name="g2_h1">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <input type="checkbox" name="g2_tookMax1" value="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group mb-2 mr-sm-2">
                                    <input class="form-control" type="number" name="g2_h2">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <input type="checkbox" name="g2_tookMax2" value="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group mb-2 mr-sm-2">
                                    <input class="form-control" type="number" name="g2_h3">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <input type="checkbox" name="g2_tookMax3" value="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group mb-2 mr-sm-2">
                                    <input class="form-control" type="number" name="g2_h4">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <input type="checkbox" name="g2_tookMax4" value="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group mb-2 mr-sm-2">
                                    <input class="form-control" type="number" name="g2_h5">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <input type="checkbox" name="g2_tookMax5" value="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group mb-2 mr-sm-2">
                                    <input class="form-control" type="number" name="g2_h6">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <input type="checkbox" name="g2_tookMax6" value="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group mb-2 mr-sm-2">
                                    <input class="form-control" type="number" name="g2_h7">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <input type="checkbox" name="g2_tookMax7" value="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group mb-2 mr-sm-2">
                                    <input class="form-control" type="number" name="g2_h8">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <input type="checkbox" name="g2_tookMax8" value="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group mb-2 mr-sm-2">
                                    <input class="form-control" type="number" name="g2_h9">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <input type="checkbox" name="g2_tookMax9" value="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    Gross:
                                    <output name="g2_gross"
                                            for="g2_h1 g2_h2 g2_h3 g2_h4 g2_h5 g2_h6 g2_h7 g2_h8 g2_h9"></output>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <select name="golfer3" class="form-control">
                                    <option value="">Select Golfer</option>
                                    <optgroup label="Members">
                                        <?php
                                        $sql = "SELECT * FROM golfers";
                                        $result = mysqli_query($conn, $sql);
                                        $subs = Array();

                                        if (mysqli_num_rows($result) > 0) {

                                            while ($row = mysqli_fetch_assoc($result)) {
                                                if ($row['team'] != 0) {
                                                    echo "<option value=\"" . $row['id'] . "\">" . $row['name'] . "</option>";
                                                } else {
                                                    $subs[$row['id']] = $row['name'];
                                                }
                                            }

                                            echo "</optgroup>";
                                            echo "<optgroup label=\"Subs\">";

                                            foreach ($subs as $id => $name) {
                                                echo "<option value=\"" . $id . "\">" . $name . "</option>";
                                            }

                                        } else {
                                            echo "0 results";
                                        }

                                        ?>
                                    </optgroup>
                                </select>
                                <span class="error"> <?php echo $golfer3Err; ?></span>
                            </div>
                            <div class="form-group">
                                <div class="input-group mb-2 mr-sm-2">
                                    <input class="form-control" type="number" name="g3_h1">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <input type="checkbox" name="g3_tookMax1" value="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group mb-2 mr-sm-2">
                                    <input class="form-control" type="number" name="g3_h2">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <input type="checkbox" name="g3_tookMax2" value="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group mb-2 mr-sm-2">
                                    <input class="form-control" type="number" name="g3_h3">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <input type="checkbox" name="g3_tookMax3" value="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group mb-2 mr-sm-2">
                                    <input class="form-control" type="number" name="g3_h4">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <input type="checkbox" name="g3_tookMax4" value="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group mb-2 mr-sm-2">
                                    <input class="form-control" type="number" name="g3_h5">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <input type="checkbox" name="g3_tookMax5" value="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group mb-2 mr-sm-2">
                                    <input class="form-control" type="number" name="g3_h6">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <input type="checkbox" name="g3_tookMax6" value="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group mb-2 mr-sm-2">
                                    <input class="form-control" type="number" name="g3_h7">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <input type="checkbox" name="g3_tookMax7" value="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group mb-2 mr-sm-2">
                                    <input class="form-control" type="number" name="g3_h8">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <input type="checkbox" name="g3_tookMax8" value="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group mb-2 mr-sm-2">
                                    <input class="form-control" type="number" name="g3_h9">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <input type="checkbox" name="g3_tookMax9" value="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    Gross:
                                    <output name="g3_gross"
                                            for="g3_h1 g3_h2 g3_h3 g3_h4 g3_h5 g3_h6 g3_h7 g3_h8 g3_h9"></output>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <select name="golfer4" class="form-control">
                                    <option value="">Select Golfer</option>
                                    <optgroup label="Members">
                                        <?php
                                        $sql = "SELECT * FROM golfers";
                                        $result = mysqli_query($conn, $sql);
                                        $subs = Array();

                                        if (mysqli_num_rows($result) > 0) {

                                            while ($row = mysqli_fetch_assoc($result)) {
                                                if ($row['team'] != 0) {
                                                    echo "<option value=\"" . $row['id'] . "\">" . $row['name'] . "</option>";
                                                } else {
                                                    $subs[$row['id']] = $row['name'];
                                                }
                                            }

                                            echo "</optgroup>";
                                            echo "<optgroup label=\"Subs\">";

                                            foreach ($subs as $id => $name) {
                                                echo "<option value=\"" . $id . "\">" . $name . "</option>";
                                            }

                                        } else {
                                            echo "0 results";
                                        }

                                        ?>
                                    </optgroup>
                                </select>
                                <span class="error"> <?php echo $golfer4Err; ?></span>
                            </div>
                            <div class="form-group">
                                <div class="input-group mb-2 mr-sm-2">
                                    <input class="form-control" type="number" name="g4_h1">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <input type="checkbox" name="g4_tookMax1" value="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group mb-2 mr-sm-2">
                                    <input class="form-control" type="number" name="g4_h2">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <input type="checkbox" name="g4_tookMax2" value="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group mb-2 mr-sm-2">
                                    <input class="form-control" type="number" name="g4_h3">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <input type="checkbox" name="g4_tookMax3" value="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group mb-2 mr-sm-2">
                                    <input class="form-control" type="number" name="g4_h4">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <input type="checkbox" name="g4_tookMax4" value="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group mb-2 mr-sm-2">
                                    <input class="form-control" type="number" name="g4_h5">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <input type="checkbox" name="g4_tookMax5" value="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group mb-2 mr-sm-2">
                                    <input class="form-control" type="number" name="g4_h6">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <input type="checkbox" name="g4_tookMax6" value="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group mb-2 mr-sm-2">
                                    <input class="form-control" type="number" name="g4_h7">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <input type="checkbox" name="g4_tookMax7" value="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group mb-2 mr-sm-2">
                                    <input class="form-control" type="number" name="g4_h8">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <input type="checkbox" name="g4_tookMax8" value="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group mb-2 mr-sm-2">
                                    <input class="form-control" type="number" name="g4_h9">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <input type="checkbox" name="g4_tookMax9" value="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    Gross:
                                    <output name="g4_gross"
                                            for="g4_h1 g4_h2 g4_h3 g4_h4 g4_h5 g4_h6 g4_h7 g4_h8 g4_h9"></output>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <input class="btn btn-primary btn-lg btn-block" type="submit" value="Submit">
                </div>
            </div>
        </div>
    </form>
</div>
</body>
</html>