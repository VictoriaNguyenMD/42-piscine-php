#!/usr/bin/php
<?php
$arr = [];
if ($argc >= 2) {
    for ($i = 1; $i < $argc; $i++)
        $arr = array_merge($arr, preg_split("/\s+/", $argv[$i], 0, PREG_SPLIT_NO_EMPTY));
    sort($arr);
    foreach ($arr as $val)
        echo $val . "\n";
}
?>