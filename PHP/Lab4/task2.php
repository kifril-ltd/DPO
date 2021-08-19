<?php

function readUrlsFromFile($filename)
{
    $urls = [];
    $handle = @fopen($filename, "r");
    if ($handle) {
        while (($buffer = fgets($handle, 4096)) !== false) {
            $urls[] = $buffer;
        }
        fclose($handle);
    }

    return $urls;
}

if ($argc == 3) {
    $pattern = "/(\d+-*\d+)/";
    $input_file = $argv[1];
    $output_file = $argv[2];

    $old_urls = readUrlsFromFile($input_file);
    $new_urls = [];

    foreach ($old_urls as $old_url) {
        $bill_id = [];
        preg_match($pattern, $old_url, $bill_id);
        $new_urls[] = "https://sozd.duma.gov.ru/bill/$bill_id[0]\r\n";
    }

    file_put_contents($output_file, $new_urls);
} else {
    echo 'Не указаны название входного или выходного файла!';
}