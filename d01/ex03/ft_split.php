<?php
function ft_split($str) {
    $arr = preg_split("/\s+/", $str, 0, PREG_SPLIT_NO_EMPTY);
    sort($arr);
    return $arr;
}
?>