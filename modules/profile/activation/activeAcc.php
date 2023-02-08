<?php
function activeAcc($db) {
    $activeType = convertStr($_GET['activeType']);

    switch ($activeType) {
    case 'mailSend':
        include "elem/mailSend.php";
        $res = mailSend($db);
        break;
    case 'mailCheck':
        include "elem/mailCheck.php";
        $res = mailCheck($db);
        break;
    }

    return $res;
}