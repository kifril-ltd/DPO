<?php
    if ($argc == 2) {
        $pattern = "/'(\d+)'/";

        $str = $argv[1];
        $str = preg_replace_callback($pattern, function ($matches) {
            return '\'' . (int)$matches[1] * 2 . '\'';
        },
            $str);
        echo $str . "\n";
    }
    else {
        echo 'Не указана строка для преобразования!';
    }