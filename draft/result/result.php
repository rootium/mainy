<!DOCTYPE html>

<html>
    <head>
        <title>Draft</title>
    </head>
    
    <body>
        <p id="label"></p>
    </body>
    <script src="result.js"></script>
</html>

<?php
require("lol.php");

$version = "12.23";

$weights = json_decode(file_get_contents("weights.json"), true);

$players = htmlspecialchars($_GET["players"]);
$players = explode(",", $players);

set_time_limit(9999);
$time_start = time();

$DATA = array();

foreach ($players as $player) {

    $summoner = summoner("euw1", $player);

    if ($summoner != false) {

        $DATA[$player] = [];

        $puuid = $summoner["puuid"];

        $N = 0;

        foreach (array(420, 440) as $queueId) {

            $start = 0;

            while (true) {

                $matches = matches("europe", $puuid, $queueId, $start);

                if ($matches != false && count($matches) > 0) {

                    $start += 100;

                    foreach ($matches as $matchId) {

                        $match = mmatch("europe", $matchId);

                        if ($match != false) {

                            if (str_starts_with($match["info"]["gameVersion"], $version)) {

                                $N += 1;

                                $index = array_search($puuid, $match["metadata"]["participants"]);

                                $participants = $match["info"]["participants"];

                                $championName = $participants[$index]["championName"];

                                $team = array();
                                foreach ($participants as $pp) {
                                    $team_ = array();
                                    foreach ($weights as $key => $value) {
                                        array_push($team_, $pp[$key] * $value);
                                    }
                                    array_push($team, $team_);
                                }

                                $sum = array();
                                for ($J = 0; $J < count($weights); $J++){
                                    $sum_ = array();
                                    for ($K = 0; $K < count($team); $K++){
                                        array_push($sum_, $team[$K][$J]);
                                    }
                                    array_push($sum, array_sum($sum_));
                                }

                                foreach ($sum as $key => $value) {
                                    if ($value == 0){
                                        $sum[$key] = 1;
                                    }
                                }

                                $op = array();
                                foreach ($team as $row){
                                    $op_ = array();
                                    foreach ($sum as $key => $value){
                                        array_push($op_, $row[$key] / $value);
                                    }
                                    array_push($op, array_sum($op_));
                                }

                                if (!array_key_exists($championName, $DATA[$player])){
                                    $DATA[$player][$championName] = 0;
                                }

                                $DATA[$player][$championName] += $op[$index];
                            }
                            else {
                                break 2;
                            }
                        }

                        while (time() - $time_start / get_times() < 1.2){}
                    }
                }
                else {
                    break;
                }
            }
        }
    }

    foreach ($DATA[$player] as $key => $value) {
        $DATA[$player][$key] = round($value / $N, 2);
    }

    print_r($DATA);
}
?>