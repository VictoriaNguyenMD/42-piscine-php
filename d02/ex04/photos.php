#!/usr/bin/php
<?php
if ($argc == 2) {
    $html_contents = file_get_contents($argv[1]);
    $regex = "/<img src=\"(https:\/\/[^\"]*)\"[^>]*>/";
    preg_match_all($regex, $html_contents, $matches);
    preg_match("/[^\/]*\//", $matches[1][0], $filename);
    $dir = $filename[0];
    file_put_contents(basename($matches[1][0],"/"), fopen($matches[1][0] ,"r"));
    rename(basename($matches[1][0],"/"), $dir . "/" . basename($matches[1][0],"/"));
}
?>