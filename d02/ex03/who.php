#!/usr/bin/php
<?php
/*
Source: https://gist.github.com/eua1024/e4f69ffdbcc191c81e953d1d67913e4e
Open the file /var/run/utmpx
Read in 628 bytes each time
Use the unpack() function, and the format "a256user/a4id/a32line/ipid/itype/itime". \
The first part of each of these refers to a type, like the i in front of the last 3 means integer. 
(See here https://www.php.net/manual/en/function.pack.php). The second part is the name for key it will 
be listed under in the array ("user", "id", "line", "pid", "type", and "time"). You could name them anything, and 
here were a few people who just named them a b c d e f, but those names are the accurate ones to describe what they are
Print out the ones where type is 7. This page has some info on that http://www.linux-tutorial.info/modules.php?name=ManPage&sec=5&manpage=utmp
*/
date_default_timezone_set("America/Los_Angeles");

$file = fopen("/var/run/utmpx", "r") or die ("Unable to open file!");
$users = [];
while ($line = fread($file, 628)) {
    $line = unpack("a256user/a4id/a32line/ipid/itype/itime", $line);
    if(strcmp($line["type"], 7) == 0)
        $users[] = $line;
}
foreach ($users as $user)
    printf("%s %s  %s\n", $user["user"], $user["line"], date("M d H:i", $user["time"]));
fclose($file)
?>