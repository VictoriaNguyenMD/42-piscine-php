<?php
class Lannister {
    function sleepWith($victim) {
        if (get_parent_class($victim) !== get_parent_class($this))
            echo "Let's do this." ."\n";
        else
            echo "Not even if I'm drunk !" . "\n";
    }
}
?>