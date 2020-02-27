#!/usr/bin/php
<?php

function is_operator($c) {
    return ($c == "+" || $c == "-" || $c == "*" || $c == "/" || $c == "%");
}

if ($argc != 2)
    echo "Incorrect Parameters\n";
else {
    if (preg_match("/^\s*(-?[0-9]+)\s*([\+\-\*\/\%])\s*(-?[0-9]+)\s*$/", $argv[1], $matches, 0))
    {  
        $n1 = trim($matches[1]);
        $op = trim($matches[2]);
        $n2 = trim($matches[3]);

        if ($op == "+")
            echo $n1 + $n2 . "\n";
        elseif ($op == "-")
            echo $n1 - $n2 . "\n";
        else if ($op == "*")
            echo $n1 * $n2 . "\n";
        else if ($op == "/")
            echo $n1 / $n2 . "\n";
        else if ($op == "%")
            echo $n1 % $n2 . "\n";
    }
    else 
        echo "Syntax Error\n";
}
?>