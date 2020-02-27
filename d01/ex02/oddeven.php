<?php
do {
    echo "Enter a number: ";
    $input = trim(fgets(STDIN));
    if (is_numeric($input)) {
        if (intval($input) % 2 == 0)
            echo "The number $input is even\n";   
        else
            echo "The number $input is odd\n";
    } elseif (feof(STDIN)) {
        echo "\n";
    } else {
        echo "'$input' is not a number\n";
    }
} while(!feof(STDIN));
?>