<?php
    $hours = 24 ;
    $minutes = 60;
    $seconds = 60;

    $seconds_per_a_day = $hours * $minutes * $seconds;

    $calculation = "$hours*$minutes*$seconds";

    print("計算式："); print("$calculation\n");

    print("計算結果："); print("$seconds_per_a_day"); print("秒");

?>