<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate"/>
    <meta http-equiv="Pragma" content="no-cache"/>
    <meta http-equiv="Expires" content="0"/>
    <title>Chatterbox Golf League</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="The Official Chatterbox Golf League Website">
    <link rel="stylesheet" href="main.css">
    <script src="index.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>

<div class="navbar">
    <a href="/index.php">Home</a>
    <a href="/addround.php">Add New Round</a>
    <div class="dropdown">
        <button class="dropbtn" onclick="dropdown()">Weeks
            <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-content" id="myDropdown">
            <a href="/weeks/1.php">Week 1</a>
            <a href="/weeks/2.php">Week 2</a>
            <a href="/weeks/3.php">Week 3</a>
            <a href="/weeks/4.php">Week 4</a>
            <a href="/weeks/5.php">Week 5</a>
        </div>
    </div>
    <a href="/spreadsheet.php">Spreadsheet</a>
</div>


<h1>Chatterbox Golf League 2019</h1>

<h2>We will be using this page for schedules and statistics including standings and other fun stats!</h2>

<?php
include 'functions.php';
getStandings($conn, 5);
?>

<script src="index.js"></script>
</body>

</html>
