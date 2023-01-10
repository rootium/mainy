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

$file = fopen("test.json", "w");
fwrite($file, json_encode($weights, true));
fclose($file);

$players = htmlspecialchars($_GET["players"]);
$players = explode(",", $players);

set_time_limit(9999);
$time_start = time();

foreach ($players as $player) {

    $summoner = summoner("euw1", $player);

    if ($summoner != false) {

        $puuid = $summoner["puuid"];
        
        echo $puuid;
    }
}
?>