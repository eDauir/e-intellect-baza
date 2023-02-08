<?php
function change($db) {
    $changeElem = convertStr($_GET['changeElem']);

    switch ($changeElem) {
    case 'default':
        include "elem/defElem.php";
        $res = defElem($db);
        break;
    case 'login':
        include "elem/login.php";
        $res = login($db);
        break;
    case 'fio':
        include "elem/fio.php";
        $res = fio($db);
        break;
    case 'mail':
        include "elem/mail.php";
        $res = changeMail($db);
        break;
    case 'checkPass':
        include "pass/check.php";
        $res = checkPass($db);
        break;
    case 'changePass':
        include "pass/change.php";
        $res = changePass($db);
        break;
    }
    return $res;
}