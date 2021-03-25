<?php 

function getWalletValue($filePath)
{
    $fs = fopen($filePath, 'r');

    $wallet = 0;

    $betNumber = fgets($fs);
    $bets = [];
    for ($i = 0; $i < $betNumber; $i++) {
        list($gameId, $betAmount, $betWinner) = explode(" ", fgets($fs));
        $bets[$gameId]['betAmount'] = (int)$betAmount;
        $bets[$gameId]['winner'] = trim($betWinner, "\n\r");
    }

    $gameNumber = fgets($fs);

    $games = [];
    for ($i = 0; $i < $gameNumber; $i++) {
        list($gameId, 
            $gameScaleL, 
            $gameScaleR, 
            $gameScaleD, 
            $gameWinner) = explode(" ", fgets($fs));

        $games[$gameId]['gameScaleL'] = (float)$gameScaleL;
        $games[$gameId]['gameScaleR'] = (float)$gameScaleR;
        $games[$gameId]['gameScaleD'] = (float)$gameScaleD;
        $games[$gameId]['gameWinner'] = trim($gameWinner, "\n\r");
    }

    foreach ($bets as $gameId => $bet) {
        if ($bet['winner'] == $games[$gameId]['gameWinner']) {
            $wallet += (100*$games[$gameId]['gameScale'.$bet['winner']] - 100) * $bet['betAmount'];
        }
        else {
            $wallet -= 100*$bet['betAmount'];
        }
    }

    return  $wallet/100;
}
