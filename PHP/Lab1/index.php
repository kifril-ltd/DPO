<?php

require './function.php';

$inputs = glob("A/*.dat");
$outputs =  glob("A/*.ans");

$i = 1;
foreach (array_combine($inputs, $outputs) as $input => $output) {
    $fs = fopen($output, 'r');
    $rightAnswer = fgets($fs);
    $programAnswer = getWalletValue($input);
    var_dump($rightAnswer, $programAnswer);
    echo "<p>Test $i: ";
    if ($programAnswer == $rightAnswer) {
        echo  "OK</p>";
    }
    else {
        echo "WRONG ANSWER</p>";
    }
    $i++;
}
