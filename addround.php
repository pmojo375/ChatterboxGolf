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
$golferErr = $weekErr = $score1Err = $score2Err = $score3Err = $score4Err = $score5Err = $score6Err = $score7Err = $score8Err = $score9Err = "";
$golfer = $week = $score1 = $score2 = $score3 = $score4 = $score5 = $score6 = $score7 = $score8 = $score9 = "";
$tookMax1 = $tookMax2 = $tookMax3 = $tookMax4 = $tookMax5 = $tookMax6 = $tookMax7 = $tookMax8 = $tookMax9 = 0;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errFree = true;
    if (empty($_POST["golfer"])) {
        $golferErr = "Please select a golfer!";
        $errFree = false;
    } else {
        $golfer = test_input($_POST["golfer"]);
    }
    if (empty($_POST["week"])) {
        $weekErr = "Week is required";
        $errFree = false;
    } else {
        $week = test_input($_POST["week"]);
    }
    if (empty($_POST["h1"])) {
        $score1Err = "Please enter a score";
        $errFree = false;
    } else {
        $score1 = test_input($_POST["h1"]);
    }
    if (empty($_POST["h2"])) {
        $score2Err = "Please enter a score";
        $errFree = false;
    } else {
        $score2 = test_input($_POST["h2"]);
    }
    if (empty($_POST["h3"])) {
        $score3Err = "Please enter a score";
        $errFree = false;
    } else {
        $score3 = test_input($_POST["h3"]);
    }
    if (empty($_POST["h4"])) {
        $score4Err = "Please enter a score";
        $errFree = false;
    } else {
        $score4 = test_input($_POST["h4"]);
    }
    if (empty($_POST["h5"])) {
        $score5Err = "Please enter a score";
        $errFree = false;
    } else {
        $score5 = test_input($_POST["h5"]);
    }
    if (empty($_POST["h6"])) {
        $score6Err = "Please enter a score";
        $errFree = false;
    } else {
        $score6 = test_input($_POST["h6"]);
    }
    if (empty($_POST["h7"])) {
        $score7Err = "Please enter a score";
        $errFree = false;
    } else {
        $score7 = test_input($_POST["h7"]);
    }
    if (empty($_POST["h8"])) {
        $score8Err = "Please enter a score";
        $errFree = false;
    } else {
        $score8 = test_input($_POST["h8"]);
    }
    if (empty($_POST["h9"])) {
        $score9Err = "Please enter a score";
        $errFree = false;
    } else {
        $score9 = test_input($_POST["h9"]);
    }
    if (isset($_POST["tookMax1"])) {
        $tookMax1 = 1;
    }
    if (isset($_POST["tookMax2"])) {
        $tookMax2 = 1;
    }
    if (isset($_POST["tookMax3"])) {
        $tookMax3 = 1;
    }
    if (isset($_POST["tookMax4"])) {
        $tookMax4 = 1;
    }
    if (isset($_POST["tookMax5"])) {
        $tookMax5 = 1;
    }
    if (isset($_POST["tookMax6"])) {
        $tookMax6 = 1;
    }
    if (isset($_POST["tookMax7"])) {
        $tookMax7 = 1;
    }
    if (isset($_POST["tookMax8"])) {
        $tookMax8 = 1;
    }
    if (isset($_POST["tookMax9"])) {
        $tookMax9 = 1;
    }
    if ($errFree) {

        $isBack = !isFront($week, $conn);

        $sql = "INSERT INTO scores (golfer, hole, score, tookMax, week) VALUES ('" . $golfer . "','" . getHoleNumber(1, $isBack) . "','" . $score1 . "','" . $tookMax1 . "','" . $week . "'), ";
        $sql .= "('" . $golfer . "','" . getHoleNumber(2, $isBack) . "','" . $score2 . "','" . $tookMax2 . "','" . $week . "'), ";
        $sql .= "('" . $golfer . "','" . getHoleNumber(3, $isBack) . "','" . $score3 . "','" . $tookMax3 . "','" . $week . "'), ";
        $sql .= "('" . $golfer . "','" . getHoleNumber(4, $isBack) . "','" . $score4 . "','" . $tookMax4 . "','" . $week . "'), ";
        $sql .= "('" . $golfer . "','" . getHoleNumber(5, $isBack) . "','" . $score5 . "','" . $tookMax5 . "','" . $week . "'), ";
        $sql .= "('" . $golfer . "','" . getHoleNumber(6, $isBack) . "','" . $score6 . "','" . $tookMax6 . "','" . $week . "'), ";
        $sql .= "('" . $golfer . "','" . getHoleNumber(7, $isBack) . "','" . $score7 . "','" . $tookMax7 . "','" . $week . "'), ";
        $sql .= "('" . $golfer . "','" . getHoleNumber(8, $isBack) . "','" . $score8 . "','" . $tookMax8 . "','" . $week . "'), ";
        $sql .= "('" . $golfer . "','" . getHoleNumber(9, $isBack) . "','" . $score9 . "','" . $tookMax9 . "','" . $week . "')";
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
          oninput="gross.value=parseInt(h1.value)+parseInt(h2.value)+parseInt(h3.value)+parseInt(h4.value)+parseInt(h5.value)+parseInt(h6.value)+parseInt(h7.value)+parseInt(h8.value)+parseInt(h9.value)">
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
            <div class="col-12">
                <div class="form-group">
                    <select name="golfer" class="form-control">
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
                    </select><span class="error"> <?php echo $golferErr; ?></span>
                </div>
                <div class="form-group">
                    <div class="input-group mb-2 mr-sm-2">
                        <input class="form-control" type="number" name="h1">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <input type="checkbox" name="tookMax1" value="true">
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-2 mr-sm-2">
                        <input class="form-control" type="number" name="h2">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <input type="checkbox" name="tookMax2" value="true">
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-2 mr-sm-2">
                        <input class="form-control" type="number" name="h3">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <input type="checkbox" name="tookMax3" value="true">
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-2 mr-sm-2">
                        <input class="form-control" type="number" name="h4">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <input type="checkbox" name="tookMax4" value="true">
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-2 mr-sm-2">
                        <input class="form-control" type="number" name="h5">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <input type="checkbox" name="tookMax5" value="true">
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-2 mr-sm-2">
                        <input class="form-control" type="number" name="h6">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <input type="checkbox" name="tookMax6" value="true">
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-2 mr-sm-2">
                        <input class="form-control" type="number" name="h7">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <input type="checkbox" name="tookMax7" value="true">
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-2 mr-sm-2">
                        <input class="form-control" type="number" name="h8">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <input type="checkbox" name="tookMax8" value="true">
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-2 mr-sm-2">
                        <input class="form-control" type="number" name="h9">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <input type="checkbox" name="tookMax9" value="true">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        Gross:
                        <output name="gross"
                                for="h1 h2 h3 h4 h5 h6 h7 h8 h9"></output>
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