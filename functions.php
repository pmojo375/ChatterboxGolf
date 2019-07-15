<?php

include 'conn.php';

// --------------- PRINT FUNCTIONS ---------------

// prints a table with the stats for a selected golfer
function printStats($id)
{
    $holes = getAllHolePars();
    $golfer = $id;

    $tableString = "<div class=\"table-responsive\">
    <table class=\"table table-striped table-dark\">
    <caption>Season Stats for " . getGolferName($golfer, 2) . "</caption>
    <thead><tr><th scope=\"col\">Week</th><th scope=\"col\">Hcp</th>
<th scope=\"col\">Gross</th>
<th scope=\"col\">Net</th>
<th scope=\"col\">Points</thv>
<th scope=\"col\">Opp.</th>
<th scope=\"col\">Opp. Score</th>
<th scope=\"col\">Opp. Net</th>
<th scope=\"col\">Birdies</th>
<th scope=\"col\">Pars</th>
<th scope=\"col\">Bogeys</th>
<th scope=\"col\">Doubles</th>
<th scope=\"col\">Triples</th>
<th scope=\"col\">Worse</th>
</tr>
</thead>
<tbody>";

    // increment by week to create table
    for ($i = 1; $i <= 20; $i++) {

        // initialize counts
        $birdies = 0;
        $pars = 0;
        $bogeys = 0;
        $doubles = 0;
        $triples = 0;
        $worse = 0;

        // check if golfer was absent by looking up if there is a sub for that id and week and comparing
        $absent = $golfer;
        $absent = checkAbsent($golfer, $i);

        // skip lookups when golfer is absent
        if (($golfer == $absent) && strtotime(date("m/d/Y")) > strtotime(getDateString($i))) {

            // determine if week was front or back
            $isFront = isFront($i);

            // increment through holes to get counts
            if ($isFront) {
                for ($j = 1; $j <= 9; $j++) {
                    $score = getGolferScore($golfer, $i, $j);
                    $par = $holes[$j];

                    $diff = $score - $par;

                    if ($diff < 0) {
                        ++$birdies;
                    } elseif ($diff == 0) {
                        ++$pars;
                    } elseif ($diff == 1) {
                        ++$bogeys;
                    } elseif ($diff == 2) {
                        ++$doubles;
                    } elseif ($diff == 3) {
                        ++$triples;
                    } elseif ($diff > 3) {
                        ++$worse;
                    }
                }
            } else {
                for ($j = 10; $j <= 18; $j++) {
                    $score = getGolferScore($golfer, $i, $j);
                    $par = $holes[$j];

                    $diff = $score - $par;

                    if ($diff < 0) {
                        ++$birdies;
                    } elseif ($diff == 0) {
                        ++$pars;
                    } elseif ($diff == 1) {
                        ++$bogeys;
                    } elseif ($diff == 2) {
                        ++$doubles;
                    } elseif ($diff == 3) {
                        ++$triples;
                    } elseif ($diff > 3) {
                        ++$worse;
                    }
                }
            }

            // create the table data
            $tableString = $tableString . "<tr><td scope=\"row\">" . $i . "</td>
<td>" . getHcp($golfer, $i) . "</td>
<td>" . getGross($golfer, $i, false) . "</td>
<td>" . getNet($golfer, $i) . "</td>
<td>" . getWeekPoints($golfer, $i) . "</td>
<td>" . getGolferName(getOpp($golfer, getOppTeam($golfer, $i), $i), $i) . "</td>
<td>" . getGross(getOpp($golfer, getOppTeam($golfer, $i), $i), $i, true) . "</td>
<td>" . getNet(getOpp($golfer, getOppTeam($golfer, $i), $i), $i) . "</td>
<td>" . $birdies . "</td>
<td>" . $pars . "</td>
<td>" . $bogeys . "</td>
<td>" . $doubles . "</td> 
<td>" . $triples . "</td>
<td>" . $worse . "</td>
</tr>";

        } else {
            $tableString = $tableString . "<tr><td scope=\"row\">" . $i . "</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
        }
    }

    $tableString = $tableString . "</tbody></table></div>";

    return $tableString;
}

function updateHCP()
{
    global $conn;
    $golfers = getGolfers();

    foreach ($golfers as $golfer) {
        for ($i = 1; $i <= 20; $i++) {
            if ($i <= 11) {
                $hcp = computeHcpNoSub($golfer, $i);
            } else {
                $hcp = 0;
            }

            $sql = "UPDATE handicaps SET `" . $i . "`=" . $hcp . " WHERE `golfer`='" . $golfer . "'";

            if (mysqli_query($conn, $sql)) {
                echo "Updated";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }


        }
    }
}


// prints the html for the navbar
function printNav()
{
    echo "<nav class=\"navbar navbar-expand-lg navbar-light bg-light\">";
    echo "<a class=\"navbar-brand\" href=\"/index.php\">ChatterboxGolf</a>";
    echo "<button class=\"navbar-toggler\" type=\"button\" data-toggle=\"collapse\" data-target=\"#navbarNavAltMarkup\"";
    echo "aria-controls=\"navbarNavAltMarkup\" aria-expanded=\"false\" aria-label=\"Toggle navigation\">";
    echo "<span class=\"navbar-toggler-icon\"></span>";
    echo "</button>";
    echo "<div class=\"collapse navbar-collapse\" id=\"navbarNavAltMarkup\">";
    echo "<div class=\"navbar-nav\">";
    echo "<a class=\"nav-item nav-link\" href=\"/addround.php\">Add Scores</a>";
    echo "<a class=\"nav-item nav-link\" href=\"/spreadsheet.php\">Spreadsheet</a>";
    echo "<div class=\"nav-item dropdown\">";
    echo "<a class=\"nav-link dropdown-toggle\" href=\"#\" id=\"navbarDropdownMenuLink\" role=\"button\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">";
    echo "Weeks";
    echo "</a>";
    echo "<div class=\"dropdown-menu\" aria-labelledby=\"navbarDropdownMenuLink\">";
    echo "<a class=\"dropdown-item\" href=\"/weeks/1.php\">Week 1</a>";
    echo "<a class=\"dropdown-item\" href=\"/weeks/2.php\">Week 2</a>";
    echo "<a class=\"dropdown-item\" href=\"/weeks/3.php\">Week 3</a>";
    echo "<a class=\"dropdown-item\" href=\"/weeks/4.php\">Week 4</a>";
    echo "<a class=\"dropdown-item\" href=\"/weeks/5.php\">Week 5</a>";
    echo "<a class=\"dropdown-item\" href=\"/weeks/6.php\">Week 6</a>";
    echo "<a class=\"dropdown-item\" href=\"/weeks/7.php\">Week 7</a>";
    echo "<a class=\"dropdown-item\" href=\"/weeks/8.php\">Week 8</a>";
    echo "<a class=\"dropdown-item\" href=\"/weeks/9.php\">Week 9</a>";
    echo "<a class=\"dropdown-item\" href=\"/weeks/10.php\">Week 10</a>";
    echo "</div>";
    echo "</div>";
    echo "<a class=\"nav-item nav-link\" href=\"/addround_full.php\">Add Card</a>";
    echo "<a class=\"nav-item nav-link\" href=\"/golfer_stats.php\">Golfer Stats</a>";
    echo "</div>";
    echo "</div>";
    echo "</nav>";
}

// prints a table with the schedule for a given week
function printSchedule($week)
{
    $teams = Array(1, 2, 3, 4, 5, 6, 7, 8);
    $index = 1;
    $teamsGone = Array();
    $i = 0;

    echo "<table id=\"schedule\">";
    echo "<caption>Week " . $week . " Schedule</caption>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>Team #</th>";
    echo "<th>Golfers</th>";
    echo "<th>Opponent</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    foreach ($teams as $team) {

        if (!in_array($team, $teamsGone)) {
            $golferA = getGolfersFromTeam($team, 2)['A'];
            $golferB = getGolfersFromTeam($team, 2)['B'];
            $oppTeam = getOppTeam($golferA, $week);

            $teamsGone[$i] = $team;
            $i = $i + 1;
            $teamsGone[$i] = $oppTeam;
            $i = $i + 1;

            echo "<tr>";
            echo "<td class=\"team\" rowspan=\"2\">" . $team . "</td>";
            echo "<td class=\"name\">" . getGolferName($golferA, $week) . "</td>";
            echo "<td class=\"name\">" . getGolferName(getOpp($golferA, $oppTeam, $week), $week) . "</td>";
            echo "</tr>";

            echo "<tr>";
            echo "<td class=\"name\">" . getGolferName($golferB, $week) . "</td>";
            echo "<td class=\"name\">" . getGolferName(getOpp($golferB, $oppTeam, $week), $week) . "</td>";
            echo "</tr>";

            $index = $index + 1;
        }
    }

    echo "</tbody>";
    echo "</table>";
}

// prints a table with the standings for a given week
function getStandings($totalWeeks)
{
    $teams = Array(1, 2, 3, 4, 5, 6, 7, 8);
    $pointTotals = Array();

    foreach ($teams as $team) {
        $totalPoints = 0;
        $firstHalfPoints = 0;

        for ($i = 1; $i <= $totalWeeks; $i++) {
            $golferA = getGolfersFromTeam($team, $i)['A'];
            $golferB = getGolfersFromTeam($team, $i)['B'];
            $golferAPoints = getWeekPoints($golferA, $i);
            $golferBPoints = getWeekPoints($golferB, $i);

            if ($i == 9) {
                $firstHalfPoints = $totalPoints + $golferAPoints + $golferBPoints;
            }

            if ($i == $totalWeeks) {
                if ($i > 9) {
                    $totalPoints = $totalPoints + $golferAPoints + $golferBPoints - $firstHalfPoints;
                } else {
                    $totalPoints = $totalPoints + $golferAPoints + $golferBPoints;
                }
            } else {
                $totalPoints = $totalPoints + $golferAPoints + $golferBPoints;
            }
        }

        $pointTotals[$team] = $totalPoints;
    }

    arsort($pointTotals);

    echo "<table id='standings'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>Place</th>";
    echo "<th>Team</th>";
    echo "<th>HCP</th>";
    echo "<th>Points</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    $index = 1;

    foreach ($pointTotals as $teamName => $score) {

        echo "<tr>";
        echo "<td class=\"place\" rowspan=\"2\">" . getRanks($index) . "</td>";
        echo "<td class=\"name\">" . getGolferName(getGolfersFromTeam($teamName, 2)['A'], 2) . "</td>";
        echo "<td class=\"hcp\">" . computeHcpNoSub(getGolfersFromTeam($teamName, 2)['A'], $totalWeeks) . "</td>";
        echo "<td class=\"score\" rowspan=\"2\">" . $score . "</td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td class=\"name\">" . getGolferName(getGolfersFromTeam($teamName, 2)['B'], 2) . "</td>";
        echo "<td class=\"hcp\">" . computeHcpNoSub(getGolfersFromTeam($teamName, 2)['B'], $totalWeeks) . "</td>";
        echo "</tr>";

        $index = $index + 1;
    }

    echo "</tbody>";
    echo "</table>";
}

// returns the correct rank wording (1st, 2nd, 3rd, etc.) as a string
function getRanks($rank)
{
    $return = '';
    switch ($rank) {
        case 1:
            $return = "1st";
            break;
        case 2:
            $return = "2nd";
            break;
        case 3:
            $return = "3rd";
            break;
        case 4:
            $return = "4th";
            break;
        case 5:
            $return = "5th";
            break;
        case 6:
            $return = "6th";
            break;
        case 7:
            $return = "7th";
            break;
        case 8:
            $return = "8th";
            break;
    }

    return $return;
}

// prints a table with all the scores for a given week
// THIS FUNCTION IS 'SUB SAFE' MEANING A SUB WILL BE USED IF THE GOLFER DID NOT PLAY THAT WEEK
function showWeekScores($week)
{
    global $conn;
    $golfers = getGolfers();
    $isBack = isBack($week);
    echo '<div class="table-responsive">';
    echo "<table id=\"weekscores\">";
    echo "<thead>";
    echo "<tr>";
    echo "<th nowrap class=\"name\">Golfer</th>";
    echo '<th nowrap onclick=\"sortTable(1)\" class=\"verticalTableHeader\">Hole ' . getHoleNumber(1, $isBack) . '</th>';
    echo '<th nowrap onclick=\"sortTable(2)\" class=\"verticalTableHeader\">Hole ' . getHoleNumber(2, $isBack) . '</th>';
    echo '<th nowrap onclick=\"sortTable(3)\" class=\"verticalTableHeader\">Hole ' . getHoleNumber(3, $isBack) . '</th>';
    echo '<th nowrap onclick=\"sortTable(4)\" class=\"verticalTableHeader\">Hole ' . getHoleNumber(4, $isBack) . '</th>';
    echo '<th nowrap onclick=\"sortTable(5)\" class=\"verticalTableHeader\">Hole ' . getHoleNumber(5, $isBack) . '</th>';
    echo '<th nowrap onclick=\"sortTable(6)\" class=\"verticalTableHeader\">Hole ' . getHoleNumber(6, $isBack) . '</th>';
    echo '<th nowrap onclick=\"sortTable(7)\" class=\"verticalTableHeader\">Hole ' . getHoleNumber(7, $isBack) . '</th>';
    echo '<th nowrap onclick=\"sortTable(8)\" class=\"verticalTableHeader\">Hole ' . getHoleNumber(8, $isBack) . '</th>';
    echo '<th nowrap onclick=\"sortTable(9)\" class=\"verticalTableHeader\">Hole ' . getHoleNumber(9, $isBack) . '</th>';
    echo "<th nowrap onclick=\"sortTable(10)\" class=\"gross\">Gross</th>";
    echo "<th nowrap onclick=\"sortTable(11)\" class=\"net\">Net</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    foreach ($golfers as $golfer) {

        $golfer = checkAbsent($golfer, $week);
        $sql = "SELECT * FROM scores WHERE week='" . $week . "' AND golfer='" . $golfer . "'";
        $result = mysqli_query($conn, $sql);
        $name = getGolferName($golfer, $week);
        $gross = 0;
        $hole1 = $hole2 = $hole3 = $hole4 = $hole5 = $hole6 = $hole7 = $hole8 = $hole9 = 0;

        if (mysqli_num_rows($result) > 0) {

            while ($row = mysqli_fetch_assoc($result)) {
                $gross = $gross + $row['score'];
                $hole = $row['hole'];

                if ($row['hole'] > 9) {
                    $hole = $hole - 9;
                }

                switch ($hole) {
                    case 1:
                        $hole1 = $row['score'];
                        break;
                    case 2:
                        $hole2 = $row['score'];
                        break;
                    case 3:
                        $hole3 = $row['score'];
                        break;
                    case 4:
                        $hole4 = $row['score'];
                        break;
                    case 5:
                        $hole5 = $row['score'];
                        break;
                    case 6:
                        $hole6 = $row['score'];
                        break;
                    case 7:
                        $hole7 = $row['score'];
                        break;
                    case 8:
                        $hole8 = $row['score'];
                        break;
                    case 9:
                        $hole9 = $row['score'];
                        break;
                }
            }

            $net = getNet($golfer, $week);

            echo "<tr>";
            echo "<td class=\"name\">" . $name . "</td>";
            echo "<td class=\"score\">" . $hole1 . "</td>";
            echo "<td class=\"score\">" . $hole2 . "</td>";
            echo "<td class=\"score\">" . $hole3 . "</td>";
            echo "<td class=\"score\">" . $hole4 . "</td>";
            echo "<td class=\"score\">" . $hole5 . "</td>";
            echo "<td class=\"score\">" . $hole6 . "</td>";
            echo "<td class=\"score\">" . $hole7 . "</td>";
            echo "<td class=\"score\">" . $hole8 . "</td>";
            echo "<td class=\"score\">" . $hole9 . "</td>";
            echo "<td class=\"gross\">" . $gross . "</td>";
            echo "<td class=\"gross\">" . $net . "</td>";
            echo "</tr>";
        }
    }

    echo "</tbody>";
    echo "</table>";
    echo '</div>';
}

// prints a table with a specific weeks scores and gross totals
// THIS FUNCTION IS 'SUB SAFE' MEANING A SUB WILL BE USED IF THE GOLFER DID NOT PLAY THAT WEEK
// STILL WORK IN PROGRESS
function showWeekHandicaps()
{

    $golfers = getGolfers();

    echo "<table id=\"weekHcp\">";
    echo "<thead>";
    echo "<tr>";
    echo "<th class=\"name\">Golfer</th>";
    echo "<th onclick=\"sortTable(1)\" class=\"verticalTableHeader\">Week 1</th>";
    echo "<th onclick=\"sortTable(2)\" class=\"verticalTableHeader\">Week 2</th>";
    echo "<th onclick=\"sortTable(3)\" class=\"verticalTableHeader\">Week 3</th>";
    echo "<th onclick=\"sortTable(4)\" class=\"verticalTableHeader\">Week 4</th>";
    echo "<th onclick=\"sortTable(5)\" class=\"verticalTableHeader\">Week 5</th>";
    echo "<th onclick=\"sortTable(6)\" class=\"verticalTableHeader\">Week 6</th>";
    echo "<th onclick=\"sortTable(7)\" class=\"verticalTableHeader\">Week 7</th>";
    echo "<th onclick=\"sortTable(8)\" class=\"verticalTableHeader\">Week 8</th>";
    echo "<th onclick=\"sortTable(9)\" class=\"verticalTableHeader\">Week 9</th>";
    echo "<th onclick=\"sortTable(10)\" class=\"verticalTableHeader\">Week 10</th>";
    echo "<th onclick=\"sortTable(11)\" class=\"verticalTableHeader\">Week 11</th>";
    echo "<th onclick=\"sortTable(12)\" class=\"verticalTableHeader\">Week 12</th>";
    echo "<th onclick=\"sortTable(13)\" class=\"verticalTableHeader\">Week 13</th>";
    echo "<th onclick=\"sortTable(14)\" class=\"verticalTableHeader\">Week 14</th>";
    echo "<th onclick=\"sortTable(15)\" class=\"verticalTableHeader\">Week 15</th>";
    echo "<th onclick=\"sortTable(16)\" class=\"verticalTableHeader\">Week 16</th>";
    echo "<th onclick=\"sortTable(17)\" class=\"verticalTableHeader\">Week 17</th>";
    echo "<th onclick=\"sortTable(18)\" class=\"verticalTableHeader\">Week 18</th>";
    echo "<th onclick=\"sortTable(19)\" class=\"verticalTableHeader\">Week 19</th>";
    echo "<th onclick=\"sortTable(20)\" class=\"verticalTableHeader\">Week 20</th>";

    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    foreach ($golfers as $golfer) {
        echo "<tr>";
        echo "<td class=\"name\">" . getGolferName($golfer, 2) . "</td>";
        for ($i = 1; $i <= 20; $i++) {
            if ($i <= 5) {
                $hcp = computeHcpNoSub($golfer, $i);
                echo "<td class=\"score\">" . $hcp . "</td>";
            } else {
                echo "<td class=\"score\">0</td>";
            }
        }
        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";
}

// --------------- SUB SAFE FUNCTIONS ---------------
// THESE FUNCTIONS ARE 'SUB SAFE' MEANING A SUB WILL BE USED IF THE GOLFER DID NOT PLAY THAT WEEK

// returns a string with the requested golfers name when given an id
function getGolferName($id, $week)
{
    global $conn;
    $id = checkAbsent($id, $week);

    $sql = "SELECT name FROM golfers WHERE id='" . $id . "'";
    $result = mysqli_query($conn, $sql);
    $return = "Unknown";

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $return = $row['name'];
        }
    }


    return $return;
}

// returns the score for a specific hole, week and golfer
function getGolferScore($id, $week, $hole)
{
    $id = checkAbsent($id, $week);
    global $conn;

    $sql = "SELECT * FROM scores WHERE (golfer='" . $id . "' AND week='" . $week . "' AND hole='" . $hole . "')";
    $result = mysqli_query($conn, $sql);
    $return = 0;

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $return = $row['score'];
        }
    }

    return $return;
}

// returns a handicap for golfer and week and returns 0 if there isn't one
function getHcp($id, $week)
{
    global $conn;
    $id = checkAbsent($id, $week);
    $sql = "SELECT * FROM handicaps WHERE golfer='" . $id . "'";
    $result = mysqli_query($conn, $sql);
    $return = 0;

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $return = $row[$week];
        }
    }

    return $return;
}

// returns a handicap for golfer and week and returns 0 if there isn't one
function computeHcp($id, $week)
{
    $totalStrokes = 0;
    $bestRound = 99;
    $worstRound = 0;
    $roundCount = 0;
    $isSub = false;

    $buffer = $id;

    $id = checkAbsent($id, $week);

    if ($week > 1) {
        $week = $week - 1;
    }

    if ($buffer !== $id) {
        $isSub = true;
    }

    if ($isSub) {
        $finalHcp = getHcp($id, $week);
    } else {
        for ($i = 1; $i <= $week; $i++) {

            // get the score
            $gross = getGross($id, $i, false);

            // add to the total round count if there is a score
            if ($gross !== 0) {
                $roundCount = $roundCount + 1;

                $totalStrokes = $totalStrokes + $gross;

                // store best round
                if ($gross < $bestRound) {
                    $bestRound = $gross;
                }

                // store worst round
                if ($gross > $worstRound) {
                    $worstRound = $gross;
                }
            }

            // if there aren't enough rounds to compute, go to the next week and try again
            if ($roundCount < 3 && $i == $week) {
                $week = $week + 1;
            }
        }

        if ($roundCount >= 5) {
            $totalStrokes = $totalStrokes - $bestRound - $worstRound;
            $roundCount = $roundCount - 2;
        }

        $average = $totalStrokes / $roundCount;

        $trueHcp = $average - 36;

        $finalHcp = round($trueHcp * .8);
    }

    return $finalHcp;
}

// returns the net score for a golfer and given week
function getNet($id, $week)
{
    global $conn;
    $id = checkAbsent($id, $week);
    $sql = "SELECT * FROM scores WHERE (golfer='" . $id . "' AND week='" . $week . "')";
    $result = mysqli_query($conn, $sql);
    $gross = 0;

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $gross = $gross + $row['score'];
        }
    }

    $return = $gross - getHcp($id, $week);

    return $return;
}

// returns the points won for the total score
function getWonNetPoints($golfer, $week)
{
    $oppTeam = getOppTeam($golfer, $week);
    $golferOpp = getOpp($golfer, $oppTeam, $week);

    $golfer = checkAbsent($golfer, $week);

    $golferGross = getGross($golfer, $week, true);
    $golferNet = $golferGross - getHcp($golfer, $week);

    $golferOpp = checkAbsent($golferOpp, $week);

    $oppGross = getGross($golferOpp, $week, true);
    $opponentNet = $oppGross - getHcp($golferOpp, $week);

    if ($golferNet > $opponentNet) {
        $roundPoints = 0;
    } elseif ($golferNet < $opponentNet) {
        $roundPoints = 3;
    } else {
        $roundPoints = 1.5;
    }

    return $roundPoints;
}

// returns the points won on a specific hole for the given week
function getHolePoints($golfer, $week, $holeIndex)
{
    $holeHcp = holeHcps();
    $isBack = isBack($week);
    $opponent = getOpp($golfer, getOppTeam($golfer, $week), $week);

    $opponentHcp = getHcp($opponent, $week);
    $golferHcp = getHcp($golfer, $week);

    $golferScore = getGolferScore($golfer, $week, getHoleNumber($holeIndex, $isBack));
    $oppScore = getGolferScore($opponent, $week, getHoleNumber($holeIndex, $isBack));

    $hcpDiff = $golferHcp - $opponentHcp;
    $giving = false;
    $even = false;

    if ($hcpDiff < 0) {
        $giving = true;
    } elseif ($hcpDiff == 0) {
        $even = true;
    }

    $hcpDiff = abs($hcpDiff);

    if ($even) {
        $points = evenHcpPoints($golferScore, $oppScore);
    } elseif ($giving) {
        $points = givingHcpPoints($golferScore, $oppScore, $holeHcp[getHoleNumber($holeIndex, $isBack)], $hcpDiff);
    } else {
        $points = gettingHcpPoints($golferScore, $oppScore, $holeHcp[getHoleNumber($holeIndex, $isBack)], $hcpDiff);
    }

    return $points;
}

// returns the total points won for a golfer and week
function getWeekPoints($id, $week)
{
    $oppTeam = getOppTeam($id, $week);
    $isBack = isBack($week);
    $holeHcp = holeHcps();

    $opponent = getOpp($id, $oppTeam, $week);

    $opponentHcp = getHcp($opponent, $week);
    $golferHcp = getHcp($id, $week);

    $hcpDiff = $golferHcp - $opponentHcp;
    $giving = false;
    $even = false;

    if ($hcpDiff < 0) {
        $giving = true;
    } elseif ($hcpDiff == 0) {
        $even = true;
    }

    $hcpDiff = abs($hcpDiff);

    $hole0Score = getGolferScore($id, $week, getHoleNumber(1, $isBack));
    $hole1Score = getGolferScore($id, $week, getHoleNumber(2, $isBack));
    $hole2Score = getGolferScore($id, $week, getHoleNumber(3, $isBack));
    $hole3Score = getGolferScore($id, $week, getHoleNumber(4, $isBack));
    $hole4Score = getGolferScore($id, $week, getHoleNumber(5, $isBack));
    $hole5Score = getGolferScore($id, $week, getHoleNumber(6, $isBack));
    $hole6Score = getGolferScore($id, $week, getHoleNumber(7, $isBack));
    $hole7Score = getGolferScore($id, $week, getHoleNumber(8, $isBack));
    $hole8Score = getGolferScore($id, $week, getHoleNumber(9, $isBack));

    $oppHole0Score = getGolferScore($opponent, $week, getHoleNumber(1, $isBack));
    $oppHole1Score = getGolferScore($opponent, $week, getHoleNumber(2, $isBack));
    $oppHole2Score = getGolferScore($opponent, $week, getHoleNumber(3, $isBack));
    $oppHole3Score = getGolferScore($opponent, $week, getHoleNumber(4, $isBack));
    $oppHole4Score = getGolferScore($opponent, $week, getHoleNumber(5, $isBack));
    $oppHole5Score = getGolferScore($opponent, $week, getHoleNumber(6, $isBack));
    $oppHole6Score = getGolferScore($opponent, $week, getHoleNumber(7, $isBack));
    $oppHole7Score = getGolferScore($opponent, $week, getHoleNumber(8, $isBack));
    $oppHole8Score = getGolferScore($opponent, $week, getHoleNumber(9, $isBack));

    if ($even) {
        $hole0Points = evenHcpPoints($hole0Score, $oppHole0Score);
        $hole1Points = evenHcpPoints($hole1Score, $oppHole1Score);
        $hole2Points = evenHcpPoints($hole2Score, $oppHole2Score);
        $hole3Points = evenHcpPoints($hole3Score, $oppHole3Score);
        $hole4Points = evenHcpPoints($hole4Score, $oppHole4Score);
        $hole5Points = evenHcpPoints($hole5Score, $oppHole5Score);
        $hole6Points = evenHcpPoints($hole6Score, $oppHole6Score);
        $hole7Points = evenHcpPoints($hole7Score, $oppHole7Score);
        $hole8Points = evenHcpPoints($hole8Score, $oppHole8Score);
    } elseif ($giving) {
        $hole0Points = givingHcpPoints($hole0Score, $oppHole0Score, $holeHcp[getHoleNumber(1, $isBack)], $hcpDiff);
        $hole1Points = givingHcpPoints($hole1Score, $oppHole1Score, $holeHcp[getHoleNumber(2, $isBack)], $hcpDiff);
        $hole2Points = givingHcpPoints($hole2Score, $oppHole2Score, $holeHcp[getHoleNumber(3, $isBack)], $hcpDiff);
        $hole3Points = givingHcpPoints($hole3Score, $oppHole3Score, $holeHcp[getHoleNumber(4, $isBack)], $hcpDiff);
        $hole4Points = givingHcpPoints($hole4Score, $oppHole4Score, $holeHcp[getHoleNumber(5, $isBack)], $hcpDiff);
        $hole5Points = givingHcpPoints($hole5Score, $oppHole5Score, $holeHcp[getHoleNumber(6, $isBack)], $hcpDiff);
        $hole6Points = givingHcpPoints($hole6Score, $oppHole6Score, $holeHcp[getHoleNumber(7, $isBack)], $hcpDiff);
        $hole7Points = givingHcpPoints($hole7Score, $oppHole7Score, $holeHcp[getHoleNumber(8, $isBack)], $hcpDiff);
        $hole8Points = givingHcpPoints($hole8Score, $oppHole8Score, $holeHcp[getHoleNumber(9, $isBack)], $hcpDiff);
    } else {
        $hole0Points = gettingHcpPoints($hole0Score, $oppHole0Score, $holeHcp[getHoleNumber(1, $isBack)], $hcpDiff);
        $hole1Points = gettingHcpPoints($hole1Score, $oppHole1Score, $holeHcp[getHoleNumber(2, $isBack)], $hcpDiff);
        $hole2Points = gettingHcpPoints($hole2Score, $oppHole2Score, $holeHcp[getHoleNumber(3, $isBack)], $hcpDiff);
        $hole3Points = gettingHcpPoints($hole3Score, $oppHole3Score, $holeHcp[getHoleNumber(4, $isBack)], $hcpDiff);
        $hole4Points = gettingHcpPoints($hole4Score, $oppHole4Score, $holeHcp[getHoleNumber(5, $isBack)], $hcpDiff);
        $hole5Points = gettingHcpPoints($hole5Score, $oppHole5Score, $holeHcp[getHoleNumber(6, $isBack)], $hcpDiff);
        $hole6Points = gettingHcpPoints($hole6Score, $oppHole6Score, $holeHcp[getHoleNumber(7, $isBack)], $hcpDiff);
        $hole7Points = gettingHcpPoints($hole7Score, $oppHole7Score, $holeHcp[getHoleNumber(8, $isBack)], $hcpDiff);
        $hole8Points = gettingHcpPoints($hole8Score, $oppHole8Score, $holeHcp[getHoleNumber(9, $isBack)], $hcpDiff);
    }

    $golferGross = $hole0Score + $hole1Score + $hole2Score + $hole3Score + $hole4Score + $hole5Score + $hole6Score + $hole7Score + $hole8Score;
    $oppGross = $oppHole0Score + $oppHole1Score + $oppHole2Score + $oppHole3Score + $oppHole4Score + $oppHole5Score + $oppHole6Score + $oppHole7Score + $oppHole8Score;

    $golferNet = $golferGross - $golferHcp;
    $opponentNet = $oppGross - $opponentHcp;

    if ($golferNet > $opponentNet) {
        $roundPoints = 0;
    } elseif ($golferNet < $opponentNet) {
        $roundPoints = 3;
    } else {
        $roundPoints = 1.5;
    }

    return ($hole0Points + $hole1Points + $hole2Points + $hole3Points + $hole4Points + $hole5Points + $hole6Points + $hole7Points + $hole8Points + $roundPoints);
}

// returns the correct opponent based on your handicap
function getOpp($id, $oppTeam, $week)
{
    global $conn;
    $golferId = $id;
    $opponent1Id = 0;
    $opponent2Id = 0;

    $partnerId = getPartner($golferId);

    // get opponent ids
    $sql = "SELECT * FROM golfers WHERE team='" . $oppTeam . "'";
    $result = mysqli_query($conn, $sql);
    $index = 0;

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            if ($index == 0) {
                $opponent1Id = $row['id'];
                $index = $index + 1;
            } else {
                $opponent2Id = $row['id'];
            }
        }
    }


    // get handicaps
    $opponent1Hcp = getHcp($opponent1Id, $week);
    $opponent2Hcp = getHcp($opponent2Id, $week);
    $partnerHcp = getHcp($partnerId, $week);
    $golferHcp = getHcp($golferId, $week);

    // check for subs
    $opponent1IdAbsent = checkAbsent($opponent1Id, $week);
    $golferIdAbsent = checkAbsent($golferId, $week);

    if ($golferHcp == $partnerHcp) {
        $sql = "SELECT * FROM tiebreaker WHERE golfer='" . $golferIdAbsent . "'";
        $result = mysqli_query($conn, $sql);
        $golferTiebreaker = false;

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $golferTiebreaker = $row[$week];
            }
        }

        if ($golferTiebreaker == 1) {
            $partnerHcp = $partnerHcp + 0.1;
        } else {
            $golferHcp = $golferHcp + 0.1;
        }
    }

    if ($opponent1Hcp == $opponent2Hcp) {
        $sql = "SELECT * FROM tiebreaker WHERE golfer='" . $opponent1IdAbsent . "'";
        $result = mysqli_query($conn, $sql);
        $opponent1Tiebreaker = false;

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $opponent1Tiebreaker = $row[$week];
            }
        }

        if ($opponent1Tiebreaker == 1) {
            $opponent2Hcp = $opponent2Hcp + 0.1;
        } else {
            $opponent1Hcp = $opponent1Hcp + 0.1;
        }
    }

    if ($golferHcp > $partnerHcp) {
        if ($opponent1Hcp > $opponent2Hcp) {
            $return = $opponent1Id;
        } else {
            $return = $opponent2Id;
        }
    } else {
        if ($opponent1Hcp > $opponent2Hcp) {
            $return = $opponent2Id;
        } else {
            $return = $opponent1Id;
        }
    }

    return $return;
}

// returns true or false depending on if the golfer is the better ('A' golfer) in his group
function isA($golfer, $week)
{
    $partnerId = 0;
    global $conn;

    // get partner id
    $sql = "SELECT * FROM golfers WHERE team='" . getTeam($golfer) . "'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row['id'] != $golfer) {
                $partnerId = $row['id'];
            }
        }
    }

    // check for subs
    $partnerId = checkAbsent($partnerId, $week);
    $golfer = checkAbsent($golfer, $week);

    // get handicaps
    $partnerHcp = getHcp($partnerId, $week);
    $golferHcp = getHcp($golfer, $week);

    if ($golferHcp == $partnerHcp) {
        $sql = "SELECT * FROM tiebreaker WHERE golfer='" . $golfer . "'";
        $result = mysqli_query($conn, $sql);
        $golferTiebreaker = false;

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $golferTiebreaker = $row[$week];
            }
        }

        if ($golferTiebreaker) {
            $partnerHcp = $partnerHcp + 0.1;
        } else {
            $golferHcp = $golferHcp + 0.1;
        }
    }

    if ($golferHcp > $partnerHcp) {
        $return = false;
    } else {
        $return = true;
    }

    return $return;
}

// returns a string for the formatting of a scorecards score cell
// THIS FUNCTION IS 'SUB SAFE' MEANING A SUB WILL BE USED IF THE GOLFER DID NOT PLAY THAT WEEK
function getStrokesGivenString($golfer, $week, $holeIndex)
{
    $holeHcp = holeHcps();
    $isBack = isBack($week);
    $opponent = getOpp($golfer, getOppTeam($golfer, $week), $week);
    $holePar = getHolePar(getHoleNumber($holeIndex, $isBack));
    $golferScore = getGolferScore($golfer, $week, getHoleNumber($holeIndex, $isBack));
    $scoreFromPar = $golferScore - $holePar;

    $opponentHcp = getHcp($opponent, $week);
    $golferHcp = getHcp($golfer, $week);

    $hcpDiff = $golferHcp - $opponentHcp;

    if ($hcpDiff > 0) {
        if ($holeHcp[getHoleNumber($holeIndex, $isBack)] <= $hcpDiff) {
            switch ($scoreFromPar) {
                case (-2):
                    $return = ' id="getting-stroke_eagle"';
                    break;
                case (-1):
                    $return = ' id="getting-stroke_birdie"';
                    break;
                case 0:
                    $return = ' id="getting-stroke_par"';
                    break;
                case 1:
                    $return = ' id="getting-stroke_bogey"';
                    break;
                default:
                    $return = ' id="getting-stroke_worst"';
            }
        } else {
            switch ($scoreFromPar) {
                case (-2):
                    $return = ' id="eagle"';
                    break;
                case (-1):
                    $return = ' id="birdie"';
                    break;
                case 0:
                    $return = ' id="par"';
                    break;
                case 1:
                    $return = ' id="bogey"';
                    break;
                default:
                    $return = ' id="worst"';
            }
        }
    } else {
        switch ($scoreFromPar) {
            case (-2):
                $return = ' id="eagle"';
                break;
            case (-1):
                $return = ' id="birdie"';
                break;
            case 0:
                $return = ' id="par"';
                break;
            case 1:
                $return = ' id="bogey"';
                break;
            default:
                $return = ' id="worst"';
        }
    }

    return $return;
}

// --------------- NOT SUB SAFE FUNCTIONS ---------------
// THIS FUNCTION IS DOES NOT WORK FOR SUBS

// returns a handicap for golfer and week and returns 0 if there isn't one
function computeHcpNoSub($id, $week)
{
    $totalStrokes = 0;
    $bestRound = 99;
    $worstRound = 0;
    $roundCount = 0;

    if ($week > 1) {
        $week = $week - 1;
    }

    for ($i = 1; $i <= $week; $i++) {

        // get the score
        $gross = getGross($id, $i, false);

        // add to the total round count if there is a score
        if ($gross !== 0) {
            $roundCount = $roundCount + 1;

            $totalStrokes = $totalStrokes + $gross;

            // store best round
            if ($gross < $bestRound) {
                $bestRound = $gross;
            }

            // store worst round
            if ($gross > $worstRound) {
                $worstRound = $gross;
            }
        }

        // if there aren't enough rounds to compute, go to the next week and try again
        if ($roundCount < 3 && $i == $week) {
            $week = $week + 1;
        }
    }

    if ($roundCount >= 5) {
        $totalStrokes = $totalStrokes - $bestRound - $worstRound;
        $roundCount = $roundCount - 2;
    }

    $average = $totalStrokes / $roundCount;

    $trueHcp = $average - 36;

    $finalHcp = round($trueHcp * .8);

    return $finalHcp;
}

// returns the opponents team for a specific week
function getOppTeam($id, $week)
{
    global $conn;
    $team = getTeam($id);

    $sql = "SELECT * FROM schedule WHERE week='" . $week . "'";
    $result = mysqli_query($conn, $sql);
    $return = 0;

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $return = $row[$team];
        }
    }

    return $return;
}

// returns the golfers partner
function getPartner($golfer)
{
    global $conn;
    // get partner id
    $sql = "SELECT * FROM golfers WHERE team='" . getTeam($golfer) . "'";
    $result = mysqli_query($conn, $sql);
    $partnerId = 0;

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row['id'] != $golfer) {
                $partnerId = $row['id'];
            }
        }
    }

    return $partnerId;
}

// returns the golfers on a specific team and maps them either ['A'] or ['B']
function getGolfersFromTeam($team, $week)
{
    global $conn;
    $sql = "SELECT * FROM golfers WHERE team='" . $team . "'";
    $result = mysqli_query($conn, $sql);
    $return = Array();

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            if (isA($row['id'], $week)) {
                $return['A'] = $row['id'];
            } else {
                $return['B'] = $row['id'];
            }
        }
    }

    return $return;
}

// returns the team number for a specific golfers id
function getTeam($id)
{
    global $conn;
    $sql = "SELECT team FROM golfers WHERE id='" . $id . "'";
    $result = mysqli_query($conn, $sql);
    $return = 0;

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $return = $row['team'];
        }
    }

    return $return;
}

// --------------- GENERAL FUNCTIONS ---------------

// returns the gross score for a given week
// THIS FUNCTION HAS A SELECTOR TO TOGGLE 'SUB SAFE' OR NOT
function getGross($golfer, $week, $checkSub)
{
    global $conn;
    if ($checkSub) {
        $golfer = checkAbsent($golfer, $week);
    }

    $sql = "SELECT * FROM scores WHERE week='" . $week . "' AND golfer='" . $golfer . "'";
    $result = mysqli_query($conn, $sql);
    $gross = 0;

    if (mysqli_num_rows($result) > 0) {

        while ($row = mysqli_fetch_assoc($result)) {
            $gross = $gross + $row['score'];
        }
    }

    return $gross;

}

// returns an array of all the golfers' ids without including subs
function getGolfers()
{
    global $conn;
    $sql = "SELECT * FROM golfers";
    $result = mysqli_query($conn, $sql);
    $golfers = array();

    $index = 0;

    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['team'] != 0) {
            $golfers[$index] = $row['id'];
            $index = $index + 1;
        }
    }

    return $golfers;
}

// returns true if the given week is played on the front 9
function isFront($week)
{
    global $conn;
    $sql = "SELECT * FROM schedule WHERE week='" . $week . "'";
    $result = mysqli_query($conn, $sql);
    $return = false;

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row['front'] == 1) {
                $return = true;
            }
        }
    }

    return $return;
}

// returns true if the given week is played on the back 9
function isBack($week)
{
    global $conn;
    $sql = "SELECT * FROM schedule WHERE week='" . $week . "'";
    $result = mysqli_query($conn, $sql);
    $return = false;

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row['front'] == 0) {
                $return = true;
            }
        }
    }

    return $return;
}

// returns an array with the yardage for each hole on the course
function getHoleYards($hole)
{
    global $conn;
    $sql = "SELECT * FROM holes";
    $result = mysqli_query($conn, $sql);
    $holeYards = Array();

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $holeYards[$row['hole']] = $row['yards'];
        }
    }

    return $holeYards[$hole];
}

// returns an array with each holes par on the course
function getHolePar($hole)
{
    global $conn;
    $sql = "SELECT * FROM holes";
    $result = mysqli_query($conn, $sql);
    $holePar = Array();

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $holePar[$row['hole']] = $row['par'];
        }
    }

    return $holePar[$hole];
}

// returns an array with each holes par on the course
function getAllHolePars()
{
    global $conn;
    $sql = "SELECT * FROM holes";
    $result = mysqli_query($conn, $sql);
    $holePar = Array();

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $holePar[$row['hole']] = $row['par'];
        }
    }

    return $holePar;
}

// returns an array with the 9 hole handicaps
// only use this when dealing with 9 holes at a time
function holeHcps()
{
    global $conn;
    $sql = "SELECT * FROM holes";
    $result = mysqli_query($conn, $sql);
    $return = Array();

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $return[$row['hole']] = $row['handicap9'];
        }
    }

    return $return;
}

// returns the handicap for a specific hole on the course
function getHoleHcp($hole)
{
    global $conn;
    $sql = "SELECT * FROM holes";
    $result = mysqli_query($conn, $sql);
    $holeHcps = Array();

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $holeHcps[$row['hole']] = $row['handicap'];
        }
    }

    return $holeHcps[$hole];
}

// determines the points based on two golfers scores with even handicaps
function evenHcpPoints($golfer, $opp)
{
    if ($golfer > $opp) {
        $points = 0;
    } elseif ($golfer < $opp) {
        $points = 1;
    } else {
        $points = 0.5;
    }

    return $points;
}

// determines the points when the 'golfer' is giving strokes
function givingHcpPoints($golfer, $opp, $holeHcp, $hcpDiff)
{
    if ($holeHcp <= $hcpDiff) {
        $opp = $opp - 1;
    }

    if ($holeHcp <= ($hcpDiff - 9)) {
        $opp = $opp - 1;
    }

    return evenHcpPoints($golfer, $opp);
}

// determines the points when the 'golfer' is getting strokes
function gettingHcpPoints($golfer, $opp, $holeHcp, $hcpDiff)
{
    if ($holeHcp <= $hcpDiff) {
        $golfer = $golfer - 1;
    }

    if ($holeHcp <= ($hcpDiff - 9)) {
        $golfer = $golfer - 1;
    }

    return evenHcpPoints($golfer, $opp);
}

// gets the golfer that a sub is subbing for on a given week
function getGolferFromSub($sub, $week)
{
    global $conn;
    $sql = "SELECT * FROM subrecords WHERE week='" . $week . "' AND sub_id='" . $sub . "'";
    $result = mysqli_query($conn, $sql);
    $return = $sub;

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $return = $row['absent_id'];
        }
    }

    return $return;
}

// returns the total yards for the 9 holes specified
function getTotalYards($isBack)
{
    global $conn;
    $sql = "SELECT * FROM holes";
    $result = mysqli_query($conn, $sql);
    $total = 0;

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            if (!$isBack) {
                if ($row['hole'] < 10) {
                    $total = $total + $row['yards'];
                }
            } else {
                if ($row['hole'] > 9) {
                    $total = $total + $row['yards'];
                }
            }
        }
    }

    return $total;
}

// checks if golfer was absent and returns the sub id if so, otherwise it returns the original id
function checkAbsent($id, $week)
{
    global $conn;
    $sql = "SELECT * FROM subrecords WHERE week='" . $week . "' AND absent_id='" . $id . "'";
    $result = mysqli_query($conn, $sql);
    $return = $id;

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $return = $row['sub_id'];
        }
    }

    return $return;
}

// returns the hole number when using a 1-9 hole index
function getHoleNumber($index, $isBack)
{
    if ($isBack) {
        $return = 9 + $index;
    } else {
        $return = $index;
    }

    return $return;
}

// returns the either "Front 9" or "Back 9" strings
function isFrontString($week)
{
    if (!isBack($week)) {
        return "Front 9";
    } else {
        return "Back 9";
    }
}

// returns the data string for a given week
function getDateString($week)
{
    $return = "";

    switch ($week) {
        case 1:
            $return = "4/23/19";
            break;
        case 2:
            $return = "5/14/19";
            break;
        case 3:
            $return = "5/21/19";
            break;
        case 4:
            $return = "5/28/19";
            break;
        case 5:
            $return = "6/4/19";
            break;
        case 6:
            $return = "6/11/19";
            break;
        case 7:
            $return = "6/18/19";
            break;
        case 8:
            $return = "6/25/19";
            break;
        case 9:
            $return = "7/2/19";
            break;
        case 10:
            $return = "7/9/19";
            break;
        case 11:
            $return = "7/16/19";
            break;
        case 12:
            $return = "7/23/19";
            break;
        case 13:
            $return = "7/30/19";
            break;
        case 14:
            $return = "8/6/19";
            break;
        case 15:
            $return = "8/13/19";
            break;
        case 16:
            $return = "8/20/19";
            break;
        case 17:
            $return = "8/27/19";
            break;
        case 18:
            $return = "9/3/19";
            break;
        case 19:
            $return = "9/10/19";
            break;
        case 20:
            $return = "9/17/19";
            break;
    }

    return $return;
}

// prints the scorecards for a given week
function getCards($week)
{

    $teamsGone = Array();
    $index = 0;
    $teams = Array(1, 2, 3, 4, 5, 6, 7, 8);
    $isBack = isBack($week);


    echo '<table id="legend">
        <tr>
            <td id="eagle">Eagle</td>
            <td id="birdie">Birdie</td>
            <td id="par">Par</td>
            <td id="bogey">Bogey</td>
            <td id="worst">Double or Worse</td>
        </tr>
    </table>
    <br>';

    foreach ($teams as $team) {

        if (!in_array($team, $teamsGone)) {

            $golferA = getGolfersFromTeam($team, $week)['A'];
            $golferB = getGolfersFromTeam($team, $week)['B'];
            $oppTeam = getOppTeam($golferA, $week);
            $oppA = getGolfersFromTeam($oppTeam, $week)['A'];
            $oppB = getGolfersFromTeam($oppTeam, $week)['B'];

            $teamsGone[$index] = $team;
            $index = $index + 1;
            $teamsGone[$index] = $oppTeam;
            $index = $index + 1;
            echo '<div class="table-responsive">';
            echo '<table class="scorecard" style="undefined;table-layout: fixed; width: 568px">
            <colgroup>
                <col style="width: 139px">
                <col style="width: 32px">
                <col style="width: 35px">
                <col style="width: 35px">
                <col style="width: 33px">
                <col style="width: 35px">
                <col style="width: 35px">
                <col style="width: 35px">
                <col style="width: 35px">
                <col style="width: 35px">
                <col style="width: 35px">
                <col style="width: 43px">
                <col style="width: 41px">
            </colgroup>
            <tr class="data">
                <th class="descriptor" colspan="2">Week ' . $week . '</th>
                <th class="descriptor" colspan="9">' . isFrontString($week) . '</th>
                <th class="descriptor" colspan="2">' . getDateString($week) . '</th>
            </tr>';

            echo '<tr class="scores">';
            echo '<td class="descriptor">' . getGolferName($golferA, $week) . '</td>';
            echo '<td class="hcp">' . getHcp($golferA, $week) . '</td>';
            echo '<td class="score"' . getStrokesGivenString($golferA, $week, 1) . '>' . getGolferScore($golferA, $week, getHoleNumber(1, $isBack)) . '</td>';
            echo '<td class="score"' . getStrokesGivenString($golferA, $week, 2) . '>' . getGolferScore($golferA, $week, getHoleNumber(2, $isBack)) . '</td>';
            echo '<td class="score"' . getStrokesGivenString($golferA, $week, 3) . '>' . getGolferScore($golferA, $week, getHoleNumber(3, $isBack)) . '</td>';
            echo '<td class="score"' . getStrokesGivenString($golferA, $week, 4) . '>' . getGolferScore($golferA, $week, getHoleNumber(4, $isBack)) . '</td>';
            echo '<td class="score"' . getStrokesGivenString($golferA, $week, 5) . '>' . getGolferScore($golferA, $week, getHoleNumber(5, $isBack)) . '</td>';
            echo '<td class="score"' . getStrokesGivenString($golferA, $week, 6) . '>' . getGolferScore($golferA, $week, getHoleNumber(6, $isBack)) . '</td>';
            echo '<td class="score"' . getStrokesGivenString($golferA, $week, 7) . '>' . getGolferScore($golferA, $week, getHoleNumber(7, $isBack)) . '</td>';
            echo '<td class="score"' . getStrokesGivenString($golferA, $week, 8) . '>' . getGolferScore($golferA, $week, getHoleNumber(8, $isBack)) . '</td>';
            echo '<td class="score"' . getStrokesGivenString($golferA, $week, 9) . '>' . getGolferScore($golferA, $week, getHoleNumber(9, $isBack)) . '</td>';
            echo '<td class="score" style="background-color:#97A2A2">' . getGross($golferA, $week, true) . '</td>';
            echo '<td class="total" style="background-color:#97A2A2">' . getNet($golferA, $week) . '</td>';
            echo '</tr>';

            echo '<tr class="points">';
            echo '<td class="descriptor" colspan="2">POINTS:</td>';
            echo '<td class="points">' . getHolePoints($golferA, $week, 1) . '</td>';
            echo '<td class="points">' . getHolePoints($golferA, $week, 2) . '</td>';
            echo '<td class="points">' . getHolePoints($golferA, $week, 3) . '</td>';
            echo '<td class="points">' . getHolePoints($golferA, $week, 4) . '</td>';
            echo '<td class="points">' . getHolePoints($golferA, $week, 5) . '</td>';
            echo '<td class="points">' . getHolePoints($golferA, $week, 6) . '</td>';
            echo '<td class="points">' . getHolePoints($golferA, $week, 7) . '</td>';
            echo '<td class="points">' . getHolePoints($golferA, $week, 8) . '</td>';
            echo '<td class="points">' . getHolePoints($golferA, $week, 9) . '</td>';
            echo '<td class="points">' . getWonNetPoints($golferA, $week) . '</td>';
            echo '<td class="total">' . getWeekPoints($golferA, $week) . '</td>';
            echo '</tr>';

            echo '<tr class="scores">';
            echo '<td class="descriptor">' . getGolferName($oppA, $week) . '</td>';
            echo '<td class="hcp">' . getHcp($oppA, $week) . '</td>';
            echo '<td class="score"' . getStrokesGivenString($oppA, $week, 1) . '>' . getGolferScore($oppA, $week, getHoleNumber(1, $isBack)) . '</td>';
            echo '<td class="score"' . getStrokesGivenString($oppA, $week, 2) . '>' . getGolferScore($oppA, $week, getHoleNumber(2, $isBack)) . '</td>';
            echo '<td class="score"' . getStrokesGivenString($oppA, $week, 3) . '>' . getGolferScore($oppA, $week, getHoleNumber(3, $isBack)) . '</td>';
            echo '<td class="score"' . getStrokesGivenString($oppA, $week, 4) . '>' . getGolferScore($oppA, $week, getHoleNumber(4, $isBack)) . '</td>';
            echo '<td class="score"' . getStrokesGivenString($oppA, $week, 5) . '>' . getGolferScore($oppA, $week, getHoleNumber(5, $isBack)) . '</td>';
            echo '<td class="score"' . getStrokesGivenString($oppA, $week, 6) . '>' . getGolferScore($oppA, $week, getHoleNumber(6, $isBack)) . '</td>';
            echo '<td class="score"' . getStrokesGivenString($oppA, $week, 7) . '>' . getGolferScore($oppA, $week, getHoleNumber(7, $isBack)) . '</td>';
            echo '<td class="score"' . getStrokesGivenString($oppA, $week, 8) . '>' . getGolferScore($oppA, $week, getHoleNumber(8, $isBack)) . '</td>';
            echo '<td class="score"' . getStrokesGivenString($oppA, $week, 9) . '>' . getGolferScore($oppA, $week, getHoleNumber(9, $isBack)) . '</td>';
            echo '<td class="score" style="background-color:#97A2A2">' . getGross($oppA, $week, true) . '</td>';
            echo '<td class="total" style="background-color:#97A2A2">' . getNet($oppA, $week) . '</td>';
            echo '</tr>';

            echo '<tr class="points">';
            echo '<td class="descriptor" colspan="2">POINTS:</td>';
            echo '<td class="points">' . getHolePoints($oppA, $week, 1) . '</td>';
            echo '<td class="points">' . getHolePoints($oppA, $week, 2) . '</td>';
            echo '<td class="points">' . getHolePoints($oppA, $week, 3) . '</td>';
            echo '<td class="points">' . getHolePoints($oppA, $week, 4) . '</td>';
            echo '<td class="points">' . getHolePoints($oppA, $week, 5) . '</td>';
            echo '<td class="points">' . getHolePoints($oppA, $week, 6) . '</td>';
            echo '<td class="points">' . getHolePoints($oppA, $week, 7) . '</td>';
            echo '<td class="points">' . getHolePoints($oppA, $week, 8) . '</td>';
            echo '<td class="points">' . getHolePoints($oppA, $week, 9) . '</td>';
            echo '<td class="points">' . getWonNetPoints($oppA, $week) . '</td>';
            echo '<td class="total">' . getWeekPoints($oppA, $week) . '</td>';
            echo '</tr>';

            echo '<tr class="data">';
            echo '<td class="hole-data left-align" colspan="2">HOLE</td>';
            echo '<td class="hole-data center-align">' . getHoleNumber(1, $isBack) . '</td>';
            echo '<td class="hole-data center-align">' . getHoleNumber(2, $isBack) . '</td>';
            echo '<td class="hole-data center-align">' . getHoleNumber(3, $isBack) . '</td>';
            echo '<td class="hole-data center-align">' . getHoleNumber(4, $isBack) . '</td>';
            echo '<td class="hole-data center-align">' . getHoleNumber(5, $isBack) . '</td>';
            echo '<td class="hole-data center-align">' . getHoleNumber(6, $isBack) . '</td>';
            echo '<td class="hole-data center-align">' . getHoleNumber(7, $isBack) . '</td>';
            echo '<td class="hole-data center-align">' . getHoleNumber(8, $isBack) . '</td>';
            echo '<td class="hole-data center-align">' . getHoleNumber(9, $isBack) . '</td>';
            echo '<td class="hole-data center-align" rowspan="2">IN</td>';
            echo '<td class="score"></td>';
            echo '</tr>';

            echo '<tr class="data">';
            echo '<td class="hole-data left-align" colspan="2">HANDICAP</td>';
            echo '<td class="hole-data center-align">' . getHoleHcp(getHoleNumber(1, $isBack)) . '</td>';
            echo '<td class="hole-data center-align">' . getHoleHcp(getHoleNumber(2, $isBack)) . '</td>';
            echo '<td class="hole-data center-align">' . getHoleHcp(getHoleNumber(3, $isBack)) . '</td>';
            echo '<td class="hole-data center-align">' . getHoleHcp(getHoleNumber(4, $isBack)) . '</td>';
            echo '<td class="hole-data center-align">' . getHoleHcp(getHoleNumber(5, $isBack)) . '</td>';
            echo '<td class="hole-data center-align">' . getHoleHcp(getHoleNumber(6, $isBack)) . '</td>';
            echo '<td class="hole-data center-align">' . getHoleHcp(getHoleNumber(7, $isBack)) . '</td>';
            echo '<td class="hole-data center-align">' . getHoleHcp(getHoleNumber(8, $isBack)) . '</td>';
            echo '<td class="hole-data center-align">' . getHoleHcp(getHoleNumber(9, $isBack)) . '</td>';
            echo '<td class="score"></td>';
            echo '</tr>';

            echo '<tr class="data">';
            echo '<td class="hole-data left-align" colspan="2">YARDS</td>';
            echo '<td class="hole-data center-align">' . getHoleYards(getHoleNumber(1, $isBack)) . '</td>';
            echo '<td class="hole-data center-align">' . getHoleYards(getHoleNumber(2, $isBack)) . '</td>';
            echo '<td class="hole-data center-align">' . getHoleYards(getHoleNumber(3, $isBack)) . '</td>';
            echo '<td class="hole-data center-align">' . getHoleYards(getHoleNumber(4, $isBack)) . '</td>';
            echo '<td class="hole-data center-align">' . getHoleYards(getHoleNumber(5, $isBack)) . '</td>';
            echo '<td class="hole-data center-align">' . getHoleYards(getHoleNumber(6, $isBack)) . '</td>';
            echo '<td class="hole-data center-align">' . getHoleYards(getHoleNumber(7, $isBack)) . '</td>';
            echo '<td class="hole-data center-align">' . getHoleYards(getHoleNumber(8, $isBack)) . '</td>';
            echo '<td class="hole-data center-align">' . getHoleYards(getHoleNumber(9, $isBack)) . '</td>';
            echo '<td class="hole-data center-align">' . getTotalYards($isBack) . '</td>';
            echo '<td class="score"></td>';
            echo '</tr>';

            echo '<tr class="data">';
            echo '<td class="hole-data left-align" colspan="2">PAR</td>';
            echo '<td class="hole-data center-align">' . getHolePar(getHoleNumber(1, $isBack)) . '</td>';
            echo '<td class="hole-data center-align">' . getHolePar(getHoleNumber(2, $isBack)) . '</td>';
            echo '<td class="hole-data center-align">' . getHolePar(getHoleNumber(3, $isBack)) . '</td>';
            echo '<td class="hole-data center-align">' . getHolePar(getHoleNumber(4, $isBack)) . '</td>';
            echo '<td class="hole-data center-align">' . getHolePar(getHoleNumber(5, $isBack)) . '</td>';
            echo '<td class="hole-data center-align">' . getHolePar(getHoleNumber(6, $isBack)) . '</td>';
            echo '<td class="hole-data center-align">' . getHolePar(getHoleNumber(7, $isBack)) . '</td>';
            echo '<td class="hole-data center-align">' . getHolePar(getHoleNumber(8, $isBack)) . '</td>';
            echo '<td class="hole-data center-align">' . getHolePar(getHoleNumber(9, $isBack)) . '</td>';
            echo '<td class="hole-data center-align">36</td>';
            echo '<td class="score"></td>';
            echo '</tr>';

            echo '<tr class="scores">';
            echo '<td class="descriptor">' . getGolferName($golferB, $week) . '</td>';
            echo '<td class="hcp">' . getHcp($golferB, $week) . '</td>';
            echo '<td class="score"' . getStrokesGivenString($golferB, $week, 1) . '>' . getGolferScore($golferB, $week, getHoleNumber(1, $isBack)) . '</td>';
            echo '<td class="score"' . getStrokesGivenString($golferB, $week, 2) . '>' . getGolferScore($golferB, $week, getHoleNumber(2, $isBack)) . '</td>';
            echo '<td class="score"' . getStrokesGivenString($golferB, $week, 3) . '>' . getGolferScore($golferB, $week, getHoleNumber(3, $isBack)) . '</td>';
            echo '<td class="score"' . getStrokesGivenString($golferB, $week, 4) . '>' . getGolferScore($golferB, $week, getHoleNumber(4, $isBack)) . '</td>';
            echo '<td class="score"' . getStrokesGivenString($golferB, $week, 5) . '>' . getGolferScore($golferB, $week, getHoleNumber(5, $isBack)) . '</td>';
            echo '<td class="score"' . getStrokesGivenString($golferB, $week, 6) . '>' . getGolferScore($golferB, $week, getHoleNumber(6, $isBack)) . '</td>';
            echo '<td class="score"' . getStrokesGivenString($golferB, $week, 7) . '>' . getGolferScore($golferB, $week, getHoleNumber(7, $isBack)) . '</td>';
            echo '<td class="score"' . getStrokesGivenString($golferB, $week, 8) . '>' . getGolferScore($golferB, $week, getHoleNumber(8, $isBack)) . '</td>';
            echo '<td class="score"' . getStrokesGivenString($golferB, $week, 9) . '>' . getGolferScore($golferB, $week, getHoleNumber(9, $isBack)) . '</td>';
            echo '<td class="score" style="background-color:#97A2A2">' . getGross($golferB, $week, true) . '</td>';
            echo '<td class="total" style="background-color:#97A2A2">' . getNet($golferB, $week) . '</td>';
            echo '</tr>';

            echo '<tr class="points">';
            echo '<td class="descriptor" colspan="2">POINTS:</td>';
            echo '<td class="points"">' . getHolePoints($golferB, $week, 1) . '</td>';
            echo '<td class="points">' . getHolePoints($golferB, $week, 2) . '</td>';
            echo '<td class="points">' . getHolePoints($golferB, $week, 3) . '</td>';
            echo '<td class="points">' . getHolePoints($golferB, $week, 4) . '</td>';
            echo '<td class="points">' . getHolePoints($golferB, $week, 5) . '</td>';
            echo '<td class="points">' . getHolePoints($golferB, $week, 6) . '</td>';
            echo '<td class="points">' . getHolePoints($golferB, $week, 7) . '</td>';
            echo '<td class="points">' . getHolePoints($golferB, $week, 8) . '</td>';
            echo '<td class="points">' . getHolePoints($golferB, $week, 9) . '</td>';
            echo '<td class="points">' . getWonNetPoints($golferB, $week) . '</td>';
            echo '<td class="total">' . getWeekPoints($golferB, $week) . '</td>';
            echo '</tr>';

            echo '<tr class="scores">';
            echo '<td class="descriptor">' . getGolferName($oppB, $week) . '</td>';
            echo '<td class="hcp">' . getHcp($oppB, $week) . '</td>';
            echo '<td class="score"' . getStrokesGivenString($oppB, $week, 1) . '>' . getGolferScore($oppB, $week, getHoleNumber(1, $isBack)) . '</td>';
            echo '<td class="score"' . getStrokesGivenString($oppB, $week, 2) . '>' . getGolferScore($oppB, $week, getHoleNumber(2, $isBack)) . '</td>';
            echo '<td class="score"' . getStrokesGivenString($oppB, $week, 3) . '>' . getGolferScore($oppB, $week, getHoleNumber(3, $isBack)) . '</td>';
            echo '<td class="score"' . getStrokesGivenString($oppB, $week, 4) . '>' . getGolferScore($oppB, $week, getHoleNumber(4, $isBack)) . '</td>';
            echo '<td class="score"' . getStrokesGivenString($oppB, $week, 5) . '>' . getGolferScore($oppB, $week, getHoleNumber(5, $isBack)) . '</td>';
            echo '<td class="score"' . getStrokesGivenString($oppB, $week, 6) . '>' . getGolferScore($oppB, $week, getHoleNumber(6, $isBack)) . '</td>';
            echo '<td class="score"' . getStrokesGivenString($oppB, $week, 7) . '>' . getGolferScore($oppB, $week, getHoleNumber(7, $isBack)) . '</td>';
            echo '<td class="score"' . getStrokesGivenString($oppB, $week, 8) . '>' . getGolferScore($oppB, $week, getHoleNumber(8, $isBack)) . '</td>';
            echo '<td class="score"' . getStrokesGivenString($oppB, $week, 9) . '>' . getGolferScore($oppB, $week, getHoleNumber(9, $isBack)) . '</td>';
            echo '<td class="score" style="background-color:#97A2A2">' . getGross($oppB, $week, true) . '</td>';
            echo '<td class="total" style="background-color:#97A2A2">' . getNet($oppB, $week) . '</td>';
            echo '</tr>';

            echo '<tr class="points">';
            echo '<td class="descriptor" colspan="2">POINTS:</td>';
            echo '<td class="points">' . getHolePoints($oppB, $week, 1) . '</td>';
            echo '<td class="points">' . getHolePoints($oppB, $week, 2) . '</td>';
            echo '<td class="points">' . getHolePoints($oppB, $week, 3) . '</td>';
            echo '<td class="points">' . getHolePoints($oppB, $week, 4) . '</td>';
            echo '<td class="points">' . getHolePoints($oppB, $week, 5) . '</td>';
            echo '<td class="points">' . getHolePoints($oppB, $week, 6) . '</td>';
            echo '<td class="points">' . getHolePoints($oppB, $week, 7) . '</td>';
            echo '<td class="points">' . getHolePoints($oppB, $week, 8) . '</td>';
            echo '<td class="points">' . getHolePoints($oppB, $week, 9) . '</td>';
            echo '<td class="points">' . getWonNetPoints($oppB, $week) . '</td>';
            echo '<td class="total">' . getWeekPoints($oppB, $week) . '</td>';
            echo '</tr>';

            echo '</table>';
            echo '</div>';
            echo '<br>';
        }
    }
}


