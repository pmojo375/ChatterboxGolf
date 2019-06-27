<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Chatterbox Golf League - Week 7</title>
    <meta name="description" content="Week 7 Stats and Standings">
    <link rel="stylesheet" href="../main.css?rnd=23">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="../index.js"></script>
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
                </div>
            </div>
        </div>
    </div>
</nav>

<h1>Week 7 Stats</h1>
<p>Click on a header to sort!</p>

<?php
include '../functions.php';

showWeekScores(7);

?>
</div>
<br>

<?php
getCards(7);
?>
</div>

</body>

</html>