<?php
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 'On');

include 'cloudcheck.php';
$CC = new cloudcheck;
?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <pre>
<code>
                <?php
                //$res = $CC->checkfssp('Иванов', 'Иван', 'Иванович', '13.04.1981');
                //$res = $CC->checkfms('9909', '247652');
                //$res = $CC->checkmvd('Иванов', 'Иван', 'Иванович', '13.04.1981');
                //$res = $CC->check115fl('Иванов', 'Иван', 'Иванович', '13.04.1981');
                //$res = $CC->getegrul('6671450552');
                //$res = $CC->checkoffense('Иванов', 'Иван', 'Иванович', '13.04.1981','5703','114376',59,'Пермь','КИМ','97');
                //$res = $CC->getdossier('Иванов', 'Иван', 'Иванович', '13.04.1981','5703','114376',59,'Пермь','КИМ','97');
                $res = $CC->getcrnbki('Иванов', 'Иван', 'Иванович', '13.04.1981','5703','114376','28.05.2002');
                //$res = $CC->getcrbrs('Иванов', 'Иван', 'Иванович', '13.04.1981','г. Пермь','5703','114376','28.05.2002','г. Пермь','УВД');

                echo htmlspecialchars($res);
                
                ?>
    </code>
        </pre>
    </body>
</html>