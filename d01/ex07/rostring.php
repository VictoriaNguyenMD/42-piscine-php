#!/usr/bin/php
<?php
if ($argc > 1) {   
    $arr = [];
    for ($i = 1; $i < $argc; $i++)
        $arr = array_merge($arr, preg_split("/[^a-z0-9]+/i", $argv[$i], 0, PREG_SPLIT_NO_EMPTY));
    if (count($arr) > 0) {
        if (count($arr) >= 2)
            echo implode(" ", array_merge(array_slice($arr, 1, -1), [$arr[0]])) . "\n";
        else
            echo $arr[0] . "\n";
    } else
        echo "\n";
}
?>