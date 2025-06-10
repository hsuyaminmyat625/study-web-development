<!DOCTYPE html>
<html lang="ja">
    <body>
        <div>
            <?php
                function printEven($num) {
                    if ($num >= 1) {
                        if ($num % 2 == 0) {
                            echo $num . "<br>";
                        }
                        printEven($num - 1); // 次の数へ（再帰）
                    }
                }

                $start = 100;
                if ($start <= 100) {
                    printEven($start);
                }
            ?>
        </div>
    </body>
</html>
