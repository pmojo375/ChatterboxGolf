<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate"/>
    <meta http-equiv="Pragma" content="no-cache"/>
    <meta http-equiv="Expires" content="0"/>
    <title>Chatterbox Golf League - Week 2</title>
    <meta name="description" content="Week 2 Stats and Standings">
    <link rel="stylesheet" href="../main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="../index.js"></script>
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

<h1>Week 2 Stats</h1>
<p>Click on a header to sort!</p>

<?php
include '../functions.php';

showWeekScores($conn, 2);

?>

<br>

<?php
getCards(2, $conn);
?>

</body>

</html>