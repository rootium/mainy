<?php

$times = 0;

$api_key = "RGAPI-3032e99b-ace3-4133-98ac-2fca4485584f";
function summoner($server, $summonerName){
    $path = "summonerData/${server}/${summonerName}.json";

    if (file_exists($path)){
        $js = file_get_contents($path);
        $success = true;
    }

    else {
        global $api_key;
        $summonerName = rawurlencode($summonerName);
        $js = @file_get_contents("https://${server}.api.riotgames.com/lol/summoner/v4/summoners/by-name/${summonerName}?api_key=${api_key}");
        if ($js){
            $file = fopen($path, "w");
            fwrite($file, $js);
            fclose($file);
            $success = true;
        }
        else {
            $success = false;
        }
        global $times;
        $times++;
    }

    if ($success){
        return json_decode($js, true);
    }
    else {
        return false;
    }
}

function matches($region, $puuid, $queueId, $start = 0, $count = 100){
    global $api_key;
    $js = @file_get_contents("https://${region}.api.riotgames.com/lol/match/v5/matches/by-puuid/${puuid}/ids?queue=${queueId}&start=${start}&count=${count}&api_key=${api_key}");
    if ($js) {
        $success = true;
    } else {
        $success = false;
    }
    global $times;
    $times++;

    if ($success){
        return json_decode($js, true);
    }
    else {
        return false;
    }
}

function mmatch($region, $matchId){
    $path = "matchData/${region}/${matchId}.json";
    if (file_exists($path)){
        $js = file_get_contents($path);
        $success = true;
    }
    else {
        global $api_key;
        $js = file_get_contents("https://${region}.api.riotgames.com/lol/match/v5/matches/${matchId}?api_key=${api_key}");
        if ($js){
            $file = fopen($path, "w");
            fwrite($file, $js);
            fclose($file);
            $success = true;
        }
        else {
            $success = false;
        }
        global $times;
        $times++;
    }

    if ($success){
        return json_decode($js, true);
    }
    else {
        return false;
    }
}

function get_times(){
    global $times;
    return $times;
}
?>