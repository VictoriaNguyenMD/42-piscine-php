<?php
class Jaime extends Lannister {
    function sleepWith($victim) {
		if (get_class($victim) === "Cersei" )
			echo "With pleasure, but only in a tower in Winterfell, then." . "\n";
		else
			parent::sleepWith($victim);
	}
}
?>