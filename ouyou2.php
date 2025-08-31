<?php
    $height = $_POST['height'];
    $weight = $_POST['weight'];
    $height_m = $height / 100; 
    $StandardWeight = ($height_m ** 2) * 22; 

    $weight_difference = $StandardWeight- $weight;
    echo "体重" . $weight . "kg<br>";
    echo "理想" . $StandardWeight . "kg<br>";
    echo "後" . number_format($weight_difference,2) . "kgで適正体重です。<br>";
?>