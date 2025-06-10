<!DOCTYPE html>
<html lang="ja">
    <body>
        
        <?php
            $start = strtotime(date("m/d"));

            $end = strtotime("+1 year", $start);

            for ($current = $start; $current <= $end; 
            $current = strtotime("+1 day",$current)){
                echo date("m/d(D)",$current)." \n " ;
            }
        ?>

    </body>
    

</html>
