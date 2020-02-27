#!/usr/bin/php
<?php
if ($argc > 2)
{
    $search_key = $argv[1];
    $value = NULL;
    for ($i = 0; $i < $argc; $i++) {
        $temp = explode(":", $argv[$i]);
        if (count($temp) == 2 && $search_key == $temp[0])
            $value = $temp[1];
    }
    if ($value)
        echo $value . "\n";
}
?>