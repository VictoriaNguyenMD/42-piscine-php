#!/usr/bin/php
<?php
if ($argc != 4)
    echo "Incorrect Parameters";
else {
    $vals = [];
    foreach ($argv as $arg)
        $vals[] = trim($arg);
    if ($vals[2] == "+")
        echo (int)$vals[1] + (int)$vals[3];
    elseif ($vals[2] == "-")
        echo (int)$vals[1] - (int)$vals[3];
    else if ($vals[2] == "*")
        echo (int)$vals[1] * (int)$vals[3];
    else if ($vals[2] == "/")
        echo (int)$vals[1] / (int)$vals[3];
    else if ($vals[2] == "%")
        echo (int)$vals[1] % (int)$vals[3];
}
?>