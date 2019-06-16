<?php

include 'conn.php';

// prints a table with the imputed weeks schedule
function printSchedule($week, $conn) {
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
            $golferA = getGolfersFromTeam($team, 2, $conn)['A'];
            $golferB = getGolfersFromTeam($team, 2, $conn)['B'];
            $oppTeam = getOppTeam($golferA, $week, $conn);

            $teamsGone[$i] = $team;
            $i = $i + 1;
            $teamsGone[$i] = $oppTeam;
            $i = $i + 1;


            if ($index % 2 == 0) {
                echo "<tr class='rowOdd'>";
                echo "<td class=\"team\" rowspan=\"2\">" . $team . "</td>";
                echo "<td class=\"name\">" . getGolferName($golferA, $week, $conn) . "</td>";
                echo "<td class=\"opp\">" . getGolferName(getOpp($golferA, $oppTeam, $week, $conn), $week, $conn) . "</td>";
                echo "</tr>";

                echo "<tr class='rowOdd'>";
                echo "<td class=\"name\">" . getGolferName($golferB, $week, $conn) . "</td>";
                echo "<td class=\"opp\">" . getGolferName(getOpp($golferB, $oppTeam, $week, $conn), $week, $conn) . "</td>";
                echo "</tr>";
            } else {
                echo "<tr class='rowEven'>";
                echo "<td class=\"team\" rowspan=\"2\">" . $team . "</td>";
                echo "<td class=\"name\">" . getGolferName($golferA, $week, $conn) . "</td>";
                echo "<td class=\"opp\">" . getGolferName(getOpp($golferA, $oppTeam, $week, $conn), $week, $conn) . "</td>";
                echo "</tr>";

                echo "<tr class='rowEven'>";
                echo "<td class=\"name\">" . getGolferName($golferB, $week, $conn) . "</td>";
                echo "<td class=\"opp\">" . getGolferName(getOpp($golferB, $oppTeam, $week, $conn), $week, $conn) . "</td>";
                echo "</tr>";
            }
            $index = $index + 1;
        }
    }

    echo "</tbody>";
    echo "</table>";
}

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

function getStandings($conn, $totalWeeks)
{
    $teams = Array(1, 2, 3, 4, 5, 6, 7, 8);
    $pointTotals = Array();

    foreach ($teams as $team) {
        $totalPoints = 0;

        for ($i = 1; $i <= $totalWeeks; $i++) {
            $golferA = getGolfersFromTeam($team, $i, $conn)['A'];
            $golferB = getGolfersFromTeam($team, $i, $conn)['B'];
            $golferAPoints = getWeekPoints($golferA, $i, $conn);
            $golferBPoints = getWeekPoints($golferB, $i, $conn);

            $totalPoints = $totalPoints + $golferAPoints + $golferBPoints;
        }

        $pointTotals[$team] = $totalPoints;
    }

    arsort($pointTotals);

    echo "<table id=\"standings\">";
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
        if ($index % 2 == 0) {
            echo "<tr class='row1'>";
            echo "<td class=\"place\" rowspan=\"2\">" . getRanks($index) . "</td>";
            echo "<td class=\"name\">" . getGolferName(getGolfersFromTeam($teamName, 2, $conn)['A'], 2, $conn) . "</td>";
            echo "<td class=\"score\">" . computeHcpNoSub(getGolfersFromTeam($teamName, 2, $conn)['A'], $totalWeeks, $conn) . "</td>";
            echo "<td class=\"score\" rowspan=\"2\">" . $score . "</td>";
            echo "</tr>";

            echo "<tr class='row1'>";
            echo "<td class=\"name\">" . getGolferName(getGolfersFromTeam($teamName, 2, $conn)['B'], 2, $conn) . "</td>";
            echo "<td class=\"score\">" . computeHcpNoSub(getGolfersFromTeam($teamName, 2, $conn)['B'], $totalWeeks, $conn) . "</td>";
            echo "</tr>";
        } else {
            echo "<tr class='row2'>";
            echo "<td class=\"place\" rowspan=\"2\">" . getRanks($index) . "</td>";
            echo "<td class=\"name\">" . getGolferName(getGolfersFromTeam($teamName, 2, $conn)['A'], 2, $conn) . "</td>";
            echo "<td class=\"score\">" . computeHcpNoSub(getGolfersFromTeam($teamName, 2, $conn)['A'], $totalWeeks, $conn) . "</td>";
            echo "<td class=\"score\" rowspan=\"2\">" . $score . "</td>";
            echo "</tr>";

            echo "<tr class='row2'>";
            echo "<td class=\"name\">" . getGolferName(getGolfersFromTeam($teamName, 2, $conn)['B'], 2, $conn) . "</td>";
            echo "<td class=\"score\">" . computeHcpNoSub(getGolfersFromTeam($teamName, 2, $conn)['B'], $totalWeeks, $conn) . "</td>";
            echo "</tr>";
        }
        $index = $index + 1;
    }

    echo "</tbody>";
    echo "</table>";
}

// returns a list of all the golfer ids
function getGolfers($conn)
{
    $sql = "SELECT * FROM golfers";
    $result = mysqli_query($conn, $sql);
    $golfers = array();

    if (mysqli_num_rows($result) > 0) {

        $index = 0;

        while ($row = mysqli_fetch_assoc($result)) {
            if ($row['team'] != 0) {
                $golfers[$index] = $row['id'];
                $index = $index + 1;
            }
        }

        return $golfers;
    }
}

// returns the golfers name when given the id number
function getGolferName($id, $week, $conn)
{
    $id = checkAbsent($id, $week, $conn);

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
function getGolferScore($id, $week, $hole, $conn)
{

    $id = checkAbsent($id, $week, $conn);

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

function isBack($week, $conn)
{
    $sql = "SELECT * FROM scores WHERE week='" . $week . "'";
    $result = mysqli_query($conn, $sql);
    $back = false;

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row['hole'] > 9) {
                $back = true;
            }
        }
    }

    return $back;
}

// creates a table with a specific weeks scores and gross totals
function showWeekScores($conn, $week)
{

    $golfers = getGolfers($conn);

    $back = isBack($week, $conn);

    echo "<table id=\"weekscores\">";
    echo "<thead>";
    echo "<tr>";
    echo "<th class=\"name\">Golfer</th>";
    if ($back) {
        echo "<th onclick=\"sortTable(1)\" class=\"verticalTableHeader\">Hole 10</th>";
        echo "<th onclick=\"sortTable(2)\" class=\"verticalTableHeader\">Hole 11</th>";
        echo "<th onclick=\"sortTable(3)\" class=\"verticalTableHeader\">Hole 12</th>";
        echo "<th onclick=\"sortTable(4)\" class=\"verticalTableHeader\">Hole 13</th>";
        echo "<th onclick=\"sortTable(5)\" class=\"verticalTableHeader\">Hole 14</th>";
        echo "<th onclick=\"sortTable(6)\" class=\"verticalTableHeader\">Hole 15</th>";
        echo "<th onclick=\"sortTable(7)\" class=\"verticalTableHeader\">Hole 16</th>";
        echo "<th onclick=\"sortTable(8)\" class=\"verticalTableHeader\">Hole 17</th>";
        echo "<th onclick=\"sortTable(9)\" class=\"verticalTableHeader\">Hole 18</th>";
    } else {
        echo "<th onclick=\"sortTable(1)\" class=\"verticalTableHeader\">Hole 1</th>";
        echo "<th onclick=\"sortTable(2)\" class=\"verticalTableHeader\">Hole 2</th>";
        echo "<th onclick=\"sortTable(3)\" class=\"verticalTableHeader\">Hole 3</th>";
        echo "<th onclick=\"sortTable(4)\" class=\"verticalTableHeader\">Hole 4</th>";
        echo "<th onclick=\"sortTable(5)\" class=\"verticalTableHeader\">Hole 5</th>";
        echo "<th onclick=\"sortTable(6)\" class=\"verticalTableHeader\">Hole 6</th>";
        echo "<th onclick=\"sortTable(7)\" class=\"verticalTableHeader\">Hole 7</th>";
        echo "<th onclick=\"sortTable(8)\" class=\"verticalTableHeader\">Hole 8</th>";
        echo "<th onclick=\"sortTable(9)\" class=\"verticalTableHeader\">Hole 9</th>";
    }

    echo "<th onclick=\"sortTable(10)\" class=\"gross\">Gross</th>";
    echo "<th onclick=\"sortTable(11)\" class=\"net\">Net</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    foreach ($golfers as $golfer) {

        $golfer = checkAbsent($golfer, $week, $conn);
        $sql = "SELECT * FROM scores WHERE week='" . $week . "' AND golfer='" . $golfer . "'";
        $result = mysqli_query($conn, $sql);
        $name = getGolferName($golfer, $week, $conn);
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

            $net = getNet($golfer, $week, $conn);

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
    //echo '<script type="text/javascript">', 'sortTable(10);', '</script>';
}

// creates a table with a specific weeks scores and gross totals
function showWeekHandicaps($conn)
{

    $golfers = getGolfers($conn);

    $back = isBack($week, $conn);

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
        echo "<td class=\"name\">" . getGolferName($golfer, 2, $conn) . "</td>";
        for ($i = 1; $i <= 20; $i++) {
            if ($i <= 5) {
                $hcp = computeHcpNoSub($golfer, $i, $conn);
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

// returns true or false for a given week
function isFront($week, $conn)
{
    $sql = "SELECT * FROM schedule WHERE week='" . $week . "'";
    $result = mysqli_query($conn, $sql);
    $return = false;

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row['front'] = 1) {
                $return = true;
            }
        }
    }

    return $return;
}

// returns a handicap for golfer and week and returns 0 if there isnt one
function getHcp($id, $week, $conn)
{
    $id = checkAbsent($id, $week, $conn);
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

// returns a handicap for golfer and week and returns 0 if there isnt one
function computeHcpNoSub($id, $week, $conn)
{
    $totalStrokes = 0;
    $daysMissed = 0;
    $bestRound = 99;
    $finalHcp = 0;
    $worstRound = 0;

    if ($week < 5) {
        $finalHcp = getHcp($id, $week, $conn);
    } else {

        for ($i = 1; $i <= $week; $i++) {

            $gross = getGross($id, $i, $conn, false);

            if ($gross == 0) {
                $daysMissed = $daysMissed + 1;
            } else {

                $totalStrokes = $totalStrokes + $gross;

                if ($bestRound > $gross) {
                    $bestRound = $gross;
                }

                if ($worstRound < $gross) {
                    $worstRound = $gross;
                }
            }
        }

        $totalRounds = $week - $daysMissed;

        if ($totalRounds >= 5) {
            $totalStrokes = $totalStrokes - $bestRound - $worstRound;
            $daysMissed = $daysMissed + 2;
        }

        $average = $totalStrokes / ($week - $daysMissed);

        $trueHcp = $average - 36;

        $finalHcp = round($trueHcp * .8);

    }

    return $finalHcp;
}

// returns a handicap for golfer and week and returns 0 if there isnt one
function computeHcp($id, $week, $conn)
{
    $totalStrokes = 0;
    $daysMissed = 0;
    $bestRound = 99;
    $finalHcp = 0;
    $worstRound = 0;

    $id = checkAbsent($id, $week, $conn);

    if ($week < 5) {
        $finalHcp = getHcp($id, $week, $conn);
    } else {

        for ($i = 1; $i <= $week; $i++) {

            $gross = getGross($id, $i, $conn, false);

            if ($gross == 0) {
                $daysMissed = $daysMissed + 1;
            } else {

                $totalStrokes = $totalStrokes + $gross;

                if ($bestRound > $gross) {
                    $bestRound = $gross;
                }

                if ($worstRound < $gross) {
                    $worstRound = $gross;
                }
            }
        }

        $totalRounds = $week - $daysMissed;

        if ($totalRounds >= 5) {
            $totalStrokes = $totalStrokes - $bestRound - $worstRound;
            $daysMissed = $daysMissed + 2;
        }

        $average = $totalStrokes / ($week - $daysMissed);

        $trueHcp = $average - 36;

        $finalHcp = round($trueHcp * .8);

    }

    return $finalHcp;
}

function getNet($id, $week, $conn)
{
    $id = checkAbsent($id, $week, $conn);
    $sql = "SELECT * FROM scores WHERE (golfer='" . $id . "' AND week='" . $week . "')";
    $result = mysqli_query($conn, $sql);
    $gross = 0;

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $gross = $gross + $row['score'];
        }
    }

    $return = $gross - getHcp($id, $week, $conn);

    return $return;
}

function getHoleYards($hole, $conn)
{
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

function getHolePar($hole, $conn)
{
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

// returns an map with the holes handicaps
function holeHcps($conn)
{
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

function getHoleHcp($hole, $conn)
{
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

function getWonNetPoints($golfer, $week, $conn)
{
    $oppTeam = getOppTeam($golfer, $week, $conn);
    $golferOpp = getOpp($golfer, $oppTeam, $week, $conn);

    $golfer = checkAbsent($golfer, $week, $conn);

    $golferGross = getGross($golfer, $week, $conn, true);
    $golferNet = $golferGross - getHcp($golfer, $week, $conn);

    $golferOpp = checkAbsent($golferOpp, $week, $conn);

    $oppGross = getGross($golferOpp, $week, $conn, true);
    $opponentNet = $oppGross - getHcp($golferOpp, $week, $conn);

    if ($golferNet > $opponentNet) {
        $roundPoints = 0;
    } elseif ($golferNet < $opponentNet) {
        $roundPoints = 3;
    } else {
        $roundPoints = 1.5;
    }

    return $roundPoints;
}

function getGolferFromSub($sub, $week, $conn)
{
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

function getHolePoints($golfer, $week, $holeIndex, $conn)
{
    $holeHcp = holeHcps($conn);
    $isBack = isBack($week, $conn);
    $opponent = getOpp($golfer, getOppTeam($golfer, $week, $conn), $week, $conn);

    $opponentHcp = getHcp($opponent, $week, $conn);
    $golferHcp = getHcp($golfer, $week, $conn);

    $golferScore = getGolferScore($golfer, $week, getHoleNumber($holeIndex, $isBack), $conn);
    $oppScore = getGolferScore($opponent, $week, getHoleNumber($holeIndex, $isBack), $conn);

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

// returns the weekly points for a golfer
function getWeekPoints($id, $week, $conn)
{
    $oppTeam = getOppTeam($id, $week, $conn);
    $isBack = isBack($week, $conn);
    $holeHcp = holeHcps($conn);

    $opponent = getOpp($id, $oppTeam, $week, $conn);

    $opponentHcp = getHcp($opponent, $week, $conn);
    $golferHcp = getHcp($id, $week, $conn);

    $hcpDiff = $golferHcp - $opponentHcp;
    $giving = false;
    $even = false;

    if ($hcpDiff < 0) {
        $giving = true;
    } elseif ($hcpDiff == 0) {
        $even = true;
    }

    $hcpDiff = abs($hcpDiff);

    $hole0Score = getGolferScore($id, $week, getHoleNumber(1, $isBack), $conn);
    $hole1Score = getGolferScore($id, $week, getHoleNumber(2, $isBack), $conn);
    $hole2Score = getGolferScore($id, $week, getHoleNumber(3, $isBack), $conn);
    $hole3Score = getGolferScore($id, $week, getHoleNumber(4, $isBack), $conn);
    $hole4Score = getGolferScore($id, $week, getHoleNumber(5, $isBack), $conn);
    $hole5Score = getGolferScore($id, $week, getHoleNumber(6, $isBack), $conn);
    $hole6Score = getGolferScore($id, $week, getHoleNumber(7, $isBack), $conn);
    $hole7Score = getGolferScore($id, $week, getHoleNumber(8, $isBack), $conn);
    $hole8Score = getGolferScore($id, $week, getHoleNumber(9, $isBack), $conn);

    $oppHole0Score = getGolferScore($opponent, $week, getHoleNumber(1, $isBack), $conn);
    $oppHole1Score = getGolferScore($opponent, $week, getHoleNumber(2, $isBack), $conn);
    $oppHole2Score = getGolferScore($opponent, $week, getHoleNumber(3, $isBack), $conn);
    $oppHole3Score = getGolferScore($opponent, $week, getHoleNumber(4, $isBack), $conn);
    $oppHole4Score = getGolferScore($opponent, $week, getHoleNumber(5, $isBack), $conn);
    $oppHole5Score = getGolferScore($opponent, $week, getHoleNumber(6, $isBack), $conn);
    $oppHole6Score = getGolferScore($opponent, $week, getHoleNumber(7, $isBack), $conn);
    $oppHole7Score = getGolferScore($opponent, $week, getHoleNumber(8, $isBack), $conn);
    $oppHole8Score = getGolferScore($opponent, $week, getHoleNumber(9, $isBack), $conn);

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

function getTotalYards($isBack, $conn)
{
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

// returns the correct opponent based on your handicap
function getOpp($id, $oppTeam, $week, $conn)
{
    $golferId = $id;
    $opponent1Id = 0;
    $opponent2Id = 0;

    $partnerId = getPartner($golferId, $conn);

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
    $opponent1Hcp = getHcp($opponent1Id, $week, $conn);
    $opponent2Hcp = getHcp($opponent2Id, $week, $conn);
    $partnerHcp = getHcp($partnerId, $week, $conn);
    $golferHcp = getHcp($golferId, $week, $conn);

    // check for subs
    $opponent1IdAbsent = checkAbsent($opponent1Id, $week, $conn);
    $golferIdAbsent = checkAbsent($golferId, $week, $conn);

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

function isA($golfer, $week, $conn)
{
    $partnerId = 0;

    // get partner id
    $sql = "SELECT * FROM golfers WHERE team='" . getTeam($golfer, $conn) . "'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row['id'] != $golfer) {
                $partnerId = $row['id'];
            }
        }
    }

    // check for subs
    $partnerId = checkAbsent($partnerId, $week, $conn);
    $golfer = checkAbsent($golfer, $week, $conn);

    // get handicaps
    $partnerHcp = getHcp($partnerId, $week, $conn);
    $golferHcp = getHcp($golfer, $week, $conn);

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

// checks if golfer was absent and returns the sub id if so, otherwise it returns the original id
function checkAbsent($id, $week, $conn)
{
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

// returns the opponents team for a specific week
function getOppTeam($id, $week, $conn)
{
    $team = getTeam($id, $conn);

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

function getPartner($golfer, $conn)
{
    // get partner id
    $sql = "SELECT * FROM golfers WHERE team='" . getTeam($golfer, $conn) . "'";
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

// returns the team for a specific golfers id
function getTeam($id, $conn)
{
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

function getGolfersFromTeam($team, $week, $conn)
{
    $sql = "SELECT * FROM golfers WHERE team='" . $team . "'";
    $result = mysqli_query($conn, $sql);
    $return = Array();

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            if (isA($row['id'], $week, $conn)) {
                $return['A'] = $row['id'];
            } else {
                $return['B'] = $row['id'];
            }
        }
    }

    return $return;
}

function getHoleNumber($index, $isBack)
{
    if ($isBack) {
        $return = 9 + $index;
    } else {
        $return = $index;
    }

    return $return;
}

function getGross($golfer, $week, $conn, $checkSub)
{
    if ($checkSub) {
        $golfer = checkAbsent($golfer, $week, $conn);
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

function isFrontString($week, $conn)
{
    if (!isBack($week, $conn)) {
        return "Front 9";
    } else {
        return "Back 9";
    }
}

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

function getStrokesGivenString($golfer, $week, $holeIndex, $conn) {
    $holeHcp = holeHcps($conn);
    $isBack = isBack($week, $conn);
    $return = "";
    $opponent = getOpp($golfer, getOppTeam($golfer, $week, $conn), $week, $conn);
    $holePar = getHolePar(getHoleNumber($holeIndex, $isBack), $conn);
    $golferScore = getGolferScore($golfer, $week, getHoleNumber($holeIndex, $isBack), $conn);
    $scoreFromPar = $golferScore - $holePar;

    $opponentHcp = getHcp($opponent, $week, $conn);
    $golferHcp = getHcp($golfer, $week, $conn);

    $hcpDiff = $golferHcp - $opponentHcp;

    if ($hcpDiff > 0) {
        if($holeHcp[getHoleNumber($holeIndex, $isBack)] <= $hcpDiff) {
            switch ($scoreFromPar) {
                case (-2):
                    $return = ' id="shadow_inner_border_eagle"';
                    break;
                case (-1):
                    $return = ' id="shadow_inner_border_birdie"';
                    break;
                case 0:
                    $return = ' id="shadow_inner_border_par"';
                    break;
                case 1:
                    $return = ' id="shadow_inner_border_bogey"';
                    break;
                default:
                    $return = ' id="shadow_inner_border_worst"';
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

function getParColorString($golfer, $week, $holeIndex, $conn) {
    $isBack = isBack($week, $conn);
    $return = "";
    $holePar = getHolePar(getHoleNumber($holeIndex, $isBack), $conn);

    $golferScore = getGolferScore($golfer, $week, $holeIndex, $conn);
    $scoreFromPar = $golferScore - $holePar;


    switch ($scoreFromPar) {
        case -2:
            $return = ' style="background-color:lightgreen";';
            break;
        case -1:
            $return = ' style="background-color:red";';
            break;
        case 0:
            $return = ' style="background-color:#97A2A2";';
            break;
        case 1:
            $return = ' style="background-color:blue";';
            break;
        default:
            $return = ' style="background-color:black";';
            break;
    }

    return "";
}

function getCards($week, $conn)
{

    $teamsGone = Array();
    $index = 0;
    $teams = Array(1, 2, 3, 4, 5, 6, 7, 8);
    $isBack = isBack($week, $conn);


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

            $golferA = getGolfersFromTeam($team, $week, $conn)['A'];
            $golferB = getGolfersFromTeam($team, $week, $conn)['B'];
            $oppTeam = getOppTeam($golferA, $week, $conn);
            $oppA = getGolfersFromTeam($oppTeam, $week, $conn)['A'];
            $oppB = getGolfersFromTeam($oppTeam, $week, $conn)['B'];

            $teamsGone[$index] = $team;
            $index = $index + 1;
            $teamsGone[$index] = $oppTeam;
            $index = $index + 1;

            echo '<table class="tg" style="undefined;table-layout: fixed; width: 568px">
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
                <th class="tg-fymr" colspan="2">Week ' . $week . '</th>
                <th class="tg-fymr" colspan="9">' . isFrontString($week, $conn) . '</th>
                <th class="tg-fymr" colspan="2">' . getDateString($week, $conn) . '</th>
            </tr>';

            echo '<tr class="scores">';
            echo '<td class="tg-fymr">' . getGolferName($golferA, $week, $conn) . '</td>';
            echo '<td class="hcp">' . getHcp($golferA, $week, $conn) . '</td>';
            echo '<td class="tg-c3ow"' . getStrokesGivenString($golferA, $week, 1, $conn) . '>' . getGolferScore($golferA, $week, getHoleNumber(1, $isBack), $conn) . '</td>';
            echo '<td class="tg-c3ow"' . getStrokesGivenString($golferA, $week, 2, $conn) . '>' . getGolferScore($golferA, $week, getHoleNumber(2, $isBack), $conn) . '</td>';
            echo '<td class="tg-c3ow"' . getStrokesGivenString($golferA, $week, 3, $conn) . '>' . getGolferScore($golferA, $week, getHoleNumber(3, $isBack), $conn) . '</td>';
            echo '<td class="tg-c3ow"' . getStrokesGivenString($golferA, $week, 4, $conn) . '>' . getGolferScore($golferA, $week, getHoleNumber(4, $isBack), $conn) . '</td>';
            echo '<td class="tg-c3ow"' . getStrokesGivenString($golferA, $week, 5, $conn) . '>' . getGolferScore($golferA, $week, getHoleNumber(5, $isBack), $conn) . '</td>';
            echo '<td class="tg-c3ow"' . getStrokesGivenString($golferA, $week, 6, $conn) . '>' . getGolferScore($golferA, $week, getHoleNumber(6, $isBack), $conn) . '</td>';
            echo '<td class="tg-c3ow"' . getStrokesGivenString($golferA, $week, 7, $conn) . '>' . getGolferScore($golferA, $week, getHoleNumber(7, $isBack), $conn) . '</td>';
            echo '<td class="tg-c3ow"' . getStrokesGivenString($golferA, $week, 8, $conn) . '>' . getGolferScore($golferA, $week, getHoleNumber(8, $isBack), $conn) . '</td>';
            echo '<td class="tg-c3ow"' . getStrokesGivenString($golferA, $week, 9, $conn) . '>' . getGolferScore($golferA, $week, getHoleNumber(9, $isBack), $conn) . '</td>';
            echo '<td class="tg-c3ow" style="background-color:#97A2A2">' . getGross($golferA, $week, $conn, true) . '</td>';
            echo '<td class="total" style="background-color:#97A2A2">' . getNet($golferA, $week, $conn) . '</td>';
            echo '</tr>';

            echo '<tr class="points">';
            echo '<td class="tg-fymr" colspan="2">POINTS:</td>';
            echo '<td class="points">' . getHolePoints($golferA, $week, 1, $conn) . '</td>';
            echo '<td class="points">' . getHolePoints($golferA, $week, 2, $conn) . '</td>';
            echo '<td class="points">' . getHolePoints($golferA, $week, 3, $conn) . '</td>';
            echo '<td class="points">' . getHolePoints($golferA, $week, 4, $conn) . '</td>';
            echo '<td class="points">' . getHolePoints($golferA, $week, 5, $conn) . '</td>';
            echo '<td class="points">' . getHolePoints($golferA, $week, 6, $conn) . '</td>';
            echo '<td class="points">' . getHolePoints($golferA, $week, 7, $conn) . '</td>';
            echo '<td class="points">' . getHolePoints($golferA, $week, 8, $conn) . '</td>';
            echo '<td class="points">' . getHolePoints($golferA, $week, 9, $conn) . '</td>';
            echo '<td class="points">' . getWonNetPoints($golferA, $week, $conn) . '</td>';
            echo '<td class="total">' . getWeekPoints($golferA, $week, $conn) . '</td>';
            echo '</tr>';

            echo '<tr class="scores">';
            echo '<td class="tg-fymr">' . getGolferName($oppA, $week, $conn) . '</td>';
            echo '<td class="hcp">' . getHcp($oppA, $week, $conn) . '</td>';
            echo '<td class="tg-c3ow"' . getStrokesGivenString($oppA, $week, 1, $conn) . '>' . getGolferScore($oppA, $week, getHoleNumber(1, $isBack), $conn) . '</td>';
            echo '<td class="tg-c3ow"' . getStrokesGivenString($oppA, $week, 2, $conn) . '>' . getGolferScore($oppA, $week, getHoleNumber(2, $isBack), $conn) . '</td>';
            echo '<td class="tg-c3ow"' . getStrokesGivenString($oppA, $week, 3, $conn) . '>' . getGolferScore($oppA, $week, getHoleNumber(3, $isBack), $conn) . '</td>';
            echo '<td class="tg-c3ow"' . getStrokesGivenString($oppA, $week, 4, $conn) . '>' . getGolferScore($oppA, $week, getHoleNumber(4, $isBack), $conn) . '</td>';
            echo '<td class="tg-c3ow"' . getStrokesGivenString($oppA, $week, 5, $conn) . '>' . getGolferScore($oppA, $week, getHoleNumber(5, $isBack), $conn) . '</td>';
            echo '<td class="tg-c3ow"' . getStrokesGivenString($oppA, $week, 6, $conn) . '>' . getGolferScore($oppA, $week, getHoleNumber(6, $isBack), $conn) . '</td>';
            echo '<td class="tg-c3ow"' . getStrokesGivenString($oppA, $week, 7, $conn) . '>' . getGolferScore($oppA, $week, getHoleNumber(7, $isBack), $conn) . '</td>';
            echo '<td class="tg-c3ow"' . getStrokesGivenString($oppA, $week, 8, $conn) . '>' . getGolferScore($oppA, $week, getHoleNumber(8, $isBack), $conn) . '</td>';
            echo '<td class="tg-c3ow"' . getStrokesGivenString($oppA, $week, 9, $conn) . '>' . getGolferScore($oppA, $week, getHoleNumber(9, $isBack), $conn) . '</td>';
            echo '<td class="tg-c3ow" style="background-color:#97A2A2">' . getGross($oppA, $week, $conn, true) . '</td>';
            echo '<td class="total" style="background-color:#97A2A2">' . getNet($oppA, $week, $conn) . '</td>';
            echo '</tr>';

            echo '<tr class="points">';
            echo '<td class="tg-fymr" colspan="2">POINTS:</td>';
            echo '<td class="points">' . getHolePoints($oppA, $week, 1, $conn) . '</td>';
            echo '<td class="points">' . getHolePoints($oppA, $week, 2, $conn) . '</td>';
            echo '<td class="points">' . getHolePoints($oppA, $week, 3, $conn) . '</td>';
            echo '<td class="points">' . getHolePoints($oppA, $week, 4, $conn) . '</td>';
            echo '<td class="points">' . getHolePoints($oppA, $week, 5, $conn) . '</td>';
            echo '<td class="points">' . getHolePoints($oppA, $week, 6, $conn) . '</td>';
            echo '<td class="points">' . getHolePoints($oppA, $week, 7, $conn) . '</td>';
            echo '<td class="points">' . getHolePoints($oppA, $week, 8, $conn) . '</td>';
            echo '<td class="points">' . getHolePoints($oppA, $week, 9, $conn) . '</td>';
            echo '<td class="points">' . getWonNetPoints($oppA, $week, $conn) . '</td>';
            echo '<td class="total">' . getWeekPoints($oppA, $week, $conn) . '</td>';
            echo '</tr>';

            echo '<tr class="data">';
            echo '<td class="tg-4erg" colspan="2">HOLE</td>';
            echo '<td class="tg-rvyq">' . getHoleNumber(1, $isBack) . '</td>';
            echo '<td class="tg-rvyq">' . getHoleNumber(2, $isBack) . '</td>';
            echo '<td class="tg-rvyq">' . getHoleNumber(3, $isBack) . '</td>';
            echo '<td class="tg-rvyq">' . getHoleNumber(4, $isBack) . '</td>';
            echo '<td class="tg-rvyq">' . getHoleNumber(5, $isBack) . '</td>';
            echo '<td class="tg-rvyq">' . getHoleNumber(6, $isBack) . '</td>';
            echo '<td class="tg-rvyq">' . getHoleNumber(7, $isBack) . '</td>';
            echo '<td class="tg-rvyq">' . getHoleNumber(8, $isBack) . '</td>';
            echo '<td class="tg-rvyq">' . getHoleNumber(9, $isBack) . '</td>';
            echo '<td class="tg-rvyq" rowspan="2">IN</td>';
            echo '<td class="tg-c3ow"></td>';
            echo '</tr>';

            echo '<tr class="data">';
            echo '<td class="tg-4erg" colspan="2">HANDICAP</td>';
            echo '<td class="tg-rvyq">' . getHoleHcp(getHoleNumber(1, $isBack), $conn) . '</td>';
            echo '<td class="tg-rvyq">' . getHoleHcp(getHoleNumber(2, $isBack), $conn) . '</td>';
            echo '<td class="tg-rvyq">' . getHoleHcp(getHoleNumber(3, $isBack), $conn) . '</td>';
            echo '<td class="tg-rvyq">' . getHoleHcp(getHoleNumber(4, $isBack), $conn) . '</td>';
            echo '<td class="tg-rvyq">' . getHoleHcp(getHoleNumber(5, $isBack), $conn) . '</td>';
            echo '<td class="tg-rvyq">' . getHoleHcp(getHoleNumber(6, $isBack), $conn) . '</td>';
            echo '<td class="tg-rvyq">' . getHoleHcp(getHoleNumber(7, $isBack), $conn) . '</td>';
            echo '<td class="tg-rvyq">' . getHoleHcp(getHoleNumber(8, $isBack), $conn) . '</td>';
            echo '<td class="tg-rvyq">' . getHoleHcp(getHoleNumber(9, $isBack), $conn) . '</td>';
            echo '<td class="tg-c3ow"></td>';
            echo '</tr>';

            echo '<tr class="data">';
            echo '<td class="tg-4erg" colspan="2">YARDS</td>';
            echo '<td class="tg-rvyq">' . getHoleYards(getHoleNumber(1, $isBack), $conn) . '</td>';
            echo '<td class="tg-rvyq">' . getHoleYards(getHoleNumber(2, $isBack), $conn) . '</td>';
            echo '<td class="tg-rvyq">' . getHoleYards(getHoleNumber(3, $isBack), $conn) . '</td>';
            echo '<td class="tg-rvyq">' . getHoleYards(getHoleNumber(4, $isBack), $conn) . '</td>';
            echo '<td class="tg-rvyq">' . getHoleYards(getHoleNumber(5, $isBack), $conn) . '</td>';
            echo '<td class="tg-rvyq">' . getHoleYards(getHoleNumber(6, $isBack), $conn) . '</td>';
            echo '<td class="tg-rvyq">' . getHoleYards(getHoleNumber(7, $isBack), $conn) . '</td>';
            echo '<td class="tg-rvyq">' . getHoleYards(getHoleNumber(8, $isBack), $conn) . '</td>';
            echo '<td class="tg-rvyq">' . getHoleYards(getHoleNumber(9, $isBack), $conn) . '</td>';
            echo '<td class="tg-rvyq">' . getTotalYards($isBack, $conn) . '</td>';
            echo '<td class="tg-c3ow"></td>';
            echo '</tr>';

            echo '<tr class="data">';
            echo '<td class="tg-4erg" colspan="2">PAR</td>';
            echo '<td class="tg-rvyq">' . getHolePar(getHoleNumber(1, $isBack), $conn) . '</td>';
            echo '<td class="tg-rvyq">' . getHolePar(getHoleNumber(2, $isBack), $conn) . '</td>';
            echo '<td class="tg-rvyq">' . getHolePar(getHoleNumber(3, $isBack), $conn) . '</td>';
            echo '<td class="tg-rvyq">' . getHolePar(getHoleNumber(4, $isBack), $conn) . '</td>';
            echo '<td class="tg-rvyq">' . getHolePar(getHoleNumber(5, $isBack), $conn) . '</td>';
            echo '<td class="tg-rvyq">' . getHolePar(getHoleNumber(6, $isBack), $conn) . '</td>';
            echo '<td class="tg-rvyq">' . getHolePar(getHoleNumber(7, $isBack), $conn) . '</td>';
            echo '<td class="tg-rvyq">' . getHolePar(getHoleNumber(8, $isBack), $conn) . '</td>';
            echo '<td class="tg-rvyq">' . getHolePar(getHoleNumber(9, $isBack), $conn) . '</td>';
            echo '<td class="tg-rvyq">36</td>';
            echo '<td class="tg-c3ow"></td>';
            echo '</tr>';

            echo '<tr class="scores">';
            echo '<td class="tg-fymr">' . getGolferName($golferB, $week, $conn) . '</td>';
            echo '<td class="hcp">' . getHcp($golferB, $week, $conn) . '</td>';
            echo '<td class="tg-c3ow"' . getStrokesGivenString($golferB, $week, 1, $conn) . '>' . getGolferScore($golferB, $week, getHoleNumber(1, $isBack), $conn) . '</td>';
            echo '<td class="tg-c3ow"' . getStrokesGivenString($golferB, $week, 2, $conn) . '>' . getGolferScore($golferB, $week, getHoleNumber(2, $isBack), $conn) . '</td>';
            echo '<td class="tg-c3ow"' . getStrokesGivenString($golferB, $week, 3, $conn) . '>' . getGolferScore($golferB, $week, getHoleNumber(3, $isBack), $conn) . '</td>';
            echo '<td class="tg-c3ow"' . getStrokesGivenString($golferB, $week, 4, $conn) . '>' . getGolferScore($golferB, $week, getHoleNumber(4, $isBack), $conn) . '</td>';
            echo '<td class="tg-c3ow"' . getStrokesGivenString($golferB, $week, 5, $conn) . '>' . getGolferScore($golferB, $week, getHoleNumber(5, $isBack), $conn) . '</td>';
            echo '<td class="tg-c3ow"' . getStrokesGivenString($golferB, $week, 6, $conn) . '>' . getGolferScore($golferB, $week, getHoleNumber(6, $isBack), $conn) . '</td>';
            echo '<td class="tg-c3ow"' . getStrokesGivenString($golferB, $week, 7, $conn) . '>' . getGolferScore($golferB, $week, getHoleNumber(7, $isBack), $conn) . '</td>';
            echo '<td class="tg-c3ow"' . getStrokesGivenString($golferB, $week, 8, $conn) . '>' . getGolferScore($golferB, $week, getHoleNumber(8, $isBack), $conn) . '</td>';
            echo '<td class="tg-c3ow"' . getStrokesGivenString($golferB, $week, 9, $conn) . '>' . getGolferScore($golferB, $week, getHoleNumber(9, $isBack), $conn) . '</td>';
            echo '<td class="tg-c3ow" style="background-color:#97A2A2">' . getGross($golferB, $week, $conn, true) . '</td>';
            echo '<td class="total" style="background-color:#97A2A2">' . getNet($golferB, $week, $conn) . '</td>';
            echo '</tr>';

            echo '<tr class="points">';
            echo '<td class="tg-fymr" colspan="2">POINTS:</td>';
            echo '<td class="points"">' . getHolePoints($golferB, $week, 1, $conn) . '</td>';
            echo '<td class="points">' . getHolePoints($golferB, $week, 2, $conn) . '</td>';
            echo '<td class="points">' . getHolePoints($golferB, $week, 3, $conn) . '</td>';
            echo '<td class="points">' . getHolePoints($golferB, $week, 4, $conn) . '</td>';
            echo '<td class="points">' . getHolePoints($golferB, $week, 5, $conn) . '</td>';
            echo '<td class="points">' . getHolePoints($golferB, $week, 6, $conn) . '</td>';
            echo '<td class="points">' . getHolePoints($golferB, $week, 7, $conn) . '</td>';
            echo '<td class="points">' . getHolePoints($golferB, $week, 8, $conn) . '</td>';
            echo '<td class="points">' . getHolePoints($golferB, $week, 9, $conn) . '</td>';
            echo '<td class="points">' . getWonNetPoints($golferB, $week, $conn) . '</td>';
            echo '<td class="total">' . getWeekPoints($golferB, $week, $conn) . '</td>';
            echo '</tr>';

            echo '<tr class="scores">';
            echo '<td class="tg-fymr">' . getGolferName($oppB, $week, $conn) . '</td>';
            echo '<td class="hcp">' . getHcp($oppB, $week, $conn) . '</td>';
            echo '<td class="tg-c3ow"' . getStrokesGivenString($oppB, $week, 1, $conn) . '>' . getGolferScore($oppB, $week, getHoleNumber(1, $isBack), $conn) . '</td>';
            echo '<td class="tg-c3ow"' . getStrokesGivenString($oppB, $week, 2, $conn) . '>' . getGolferScore($oppB, $week, getHoleNumber(2, $isBack), $conn) . '</td>';
            echo '<td class="tg-c3ow"' . getStrokesGivenString($oppB, $week, 3, $conn) . '>' . getGolferScore($oppB, $week, getHoleNumber(3, $isBack), $conn) . '</td>';
            echo '<td class="tg-c3ow"' . getStrokesGivenString($oppB, $week, 4, $conn) . '>' . getGolferScore($oppB, $week, getHoleNumber(4, $isBack), $conn) . '</td>';
            echo '<td class="tg-c3ow"' . getStrokesGivenString($oppB, $week, 5, $conn) . '>' . getGolferScore($oppB, $week, getHoleNumber(5, $isBack), $conn) . '</td>';
            echo '<td class="tg-c3ow"' . getStrokesGivenString($oppB, $week, 6, $conn) . '>' . getGolferScore($oppB, $week, getHoleNumber(6, $isBack), $conn) . '</td>';
            echo '<td class="tg-c3ow"' . getStrokesGivenString($oppB, $week, 7, $conn) . '>' . getGolferScore($oppB, $week, getHoleNumber(7, $isBack), $conn) . '</td>';
            echo '<td class="tg-c3ow"' . getStrokesGivenString($oppB, $week, 8, $conn) . '>' . getGolferScore($oppB, $week, getHoleNumber(8, $isBack), $conn) . '</td>';
            echo '<td class="tg-c3ow"' . getStrokesGivenString($oppB, $week, 9, $conn) . '>' . getGolferScore($oppB, $week, getHoleNumber(9, $isBack), $conn) . '</td>';
            echo '<td class="tg-c3ow" style="background-color:#97A2A2">' . getGross($oppB, $week, $conn, true) . '</td>';
            echo '<td class="total" style="background-color:#97A2A2">' . getNet($oppB, $week, $conn) . '</td>';
            echo '</tr>';

            echo '<tr class="points">';
            echo '<td class="tg-fymr" colspan="2">POINTS:</td>';
            echo '<td class="points">' . getHolePoints($oppB, $week, 1, $conn) . '</td>';
            echo '<td class="points">' . getHolePoints($oppB, $week, 2, $conn) . '</td>';
            echo '<td class="points">' . getHolePoints($oppB, $week, 3, $conn) . '</td>';
            echo '<td class="points">' . getHolePoints($oppB, $week, 4, $conn) . '</td>';
            echo '<td class="points">' . getHolePoints($oppB, $week, 5, $conn) . '</td>';
            echo '<td class="points">' . getHolePoints($oppB, $week, 6, $conn) . '</td>';
            echo '<td class="points">' . getHolePoints($oppB, $week, 7, $conn) . '</td>';
            echo '<td class="points">' . getHolePoints($oppB, $week, 8, $conn) . '</td>';
            echo '<td class="points">' . getHolePoints($oppB, $week, 9, $conn) . '</td>';
            echo '<td class="points">' . getWonNetPoints($oppB, $week, $conn) . '</td>';
            echo '<td class="total">' . getWeekPoints($oppB, $week, $conn) . '</td>';
            echo '</tr>';

            echo '</table>';
            echo '<br>';
        }
    }
}


