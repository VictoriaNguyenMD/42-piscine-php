<?php
function ft_is_sort($arr) {
    $temp = $arr;
    sort($temp);
    return ($temp === $arr);
}
?>