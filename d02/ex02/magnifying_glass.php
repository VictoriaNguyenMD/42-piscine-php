#!/usr/bin/php
<?php
function replaces($matches) {
    return str_replace($matches[1], strtoupper($matches[1]), $matches[0]); 
}

if ($argc = 2)
{
    $file = fopen($argv[1], "r") or die ("Unable to open file!");
    $regex_text="/<[^>]*(?:href|src)[^>]*>([^<]*)</";
    $regex_title="/title=\"([^\"]*)/";
    while (!feof($file)) {
        $line = fgets($file);
        $line = preg_replace_callback($regex_text, "replaces", $line);
        $line = preg_replace_callback($regex_title, "replaces", $line);
        echo $line;
    }
}  
?>