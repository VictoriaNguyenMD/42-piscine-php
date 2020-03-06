<?php
class NightsWatch implements IFighter{
    private $people = array();

    function recruit($person) {
        if ($person instanceof IFighter)
            $this->people[] = $person;
    }   

    function fight() {
        foreach ($this->people as $psn => $value)
            $value->fight();
    }
}
?>