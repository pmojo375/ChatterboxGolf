<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Round</title>
    <script src="addround.js"></script>
    <link rel="stylesheet" href="main.css">
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
            <a href="/weeks/6.php">Week 6</a>
        </div>
    </div>
    <a href="/spreadsheet.php">Spreadsheet</a>
</div>

<?php include 'conn.php'; ?>

<?php

include 'functions.php';

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

    if($errFree) {
		
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

<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post"
      oninput="gross.value=parseInt(h1.value)+parseInt(h2.value)+parseInt(h3.value)+parseInt(h4.value)+parseInt(h5.value)+parseInt(h6.value)+parseInt(h7.value)+parseInt(h8.value)+parseInt(h9.value)">
    <fieldset>
        <legend>Add Round:</legend>
        <select name="golfer">
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
        <select name= "week" id="week" onchange="checkBack(this.value)">
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
        </select><span class="error"> <?php echo $weekErr; ?></span><br>
        <p>After selecting a golfer and week, enter the scores below. Check the box on the right of the score entry to indicate that the golfer shot max and picked up.</p>
        <span id='hole1'>Hole 1:</span> <input class="in" type="number" name="h1"><input type="checkbox" name="tookMax1" value="true"><span class="error"> <?php echo $score1Err; ?></span><br>
        <span id='hole2'>Hole 2:</span> <input class="in" type="number" name="h2"><input type="checkbox" name="tookMax2" value="true"><span class="error"> <?php echo $score2Err; ?></span><br>
        <span id='hole3'>Hole 3:</span> <input class="in" type="number" name="h3"><input type="checkbox" name="tookMax3" value="true"><span class="error"> <?php echo $score3Err; ?></span><br>
        <span id='hole4'>Hole 4:</span> <input class="in" type="number" name="h4"><input type="checkbox" name="tookMax4" value="true"><span class="error"> <?php echo $score4Err; ?></span><br>
        <span id='hole5'>Hole 5:</span> <input class="in" type="number" name="h5"><input type="checkbox" name="tookMax5" value="true"><span class="error"> <?php echo $score5Err; ?></span><br>
        <span id='hole6'>Hole 6:</span> <input class="in" type="number" name="h6"><input type="checkbox" name="tookMax6" value="true"><span class="error"> <?php echo $score6Err; ?></span><br>
        <span id='hole7'>Hole 7:</span> <input class="in" type="number" name="h7"><input type="checkbox" name="tookMax7" value="true"><span class="error"> <?php echo $score7Err; ?></span><br>
        <span id='hole8'>Hole 8:</span> <input class="in" type="number" name="h8"><input type="checkbox" name="tookMax8" value="true"><span class="error"> <?php echo $score8Err; ?></span><br>
        <span id='hole9'>Hole 9:</span> <input class="in" type="number" name="h9"><input type="checkbox" name="tookMax9" value="true"><span class="error"> <?php echo $score9Err; ?></span><br>
        Gross:
        <output name="gross" for="h1 h2 h3 h4 h5 h6 h7 h8 h9"></output>
        <br>
        <input type="submit" value="Submit">
    </fieldset>
</form>
</body>
</html>