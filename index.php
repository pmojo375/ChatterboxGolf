<!DOCTYPE html>
<html>

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <meta name="description" content="The Official Chatterbox Golf League Website">
    <link rel="stylesheet" href="main.css?rnd=23">
    <script src="index.js"></script>
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

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="/index.php">ChatterboxGolf</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
            aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
            <a class="nav-item nav-link" href="/addround.php">Add Scores</a>
            <a class="nav-item nav-link" href="/spreadsheet.php">Spreadsheet</a>
            <div class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Weeks
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="/weeks/1.php">Week 1</a>
                    <a class="dropdown-item" href="/weeks/2.php">Week 2</a>
                    <a class="dropdown-item" href="/weeks/3.php">Week 3</a>
                    <a class="dropdown-item" href="/weeks/4.php">Week 4</a>
                    <a class="dropdown-item" href="/weeks/5.php">Week 5</a>
                    <a class="dropdown-item" href="/weeks/6.php">Week 6</a>
                    <a class="dropdown-item" href="/weeks/7.php">Week 7</a>
                    <a class="dropdown-item" href="/weeks/8.php">Week 8</a>
                    <a class="dropdown-item" href="/weeks/9.php">Week 9</a>
                    <a class="dropdown-item" href="/weeks/10.php">Week 10</a>
                </div>
            </div>
            <a class="nav-item nav-link" href="/addround_full.php">Add Full Card</a>
        </div>
    </div>
</nav>



<h1>Chatterbox Golf League 2019</h1>

<br>

<p>First half standings are below with the team of Ben Hass and Sean Muller taking first and getting the first slot in the playoffs. The second half winner will also get a slot and then the next highest two scores (not including the half winners) will take the remaining two places!</p>

<?php
include 'functions.php';
getStandings(9);
?>

<br>

<p>Second half standings are below:</p>

<br>

<?php
getStandings(10);
echo '<br>';
printSchedule(11);
?>

<script src="index.js"></script>
</body>

</html>
