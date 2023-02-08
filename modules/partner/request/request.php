<?php
function request($db) {
    switch ($_GET['action']) {
    case 'checkId':
        include "modules/partner/request/checkId.php";
        $res = checkId($db);
        break;
    case 'send':
        include "modules/partner/request/send.php";
        $res = send($db);
        break;
    case 'accept':
        include "modules/partner/request/accept.php";
        $res = accept($db);
        break;
    case 'unit':
        include "modules/partner/request/unit.php";
        $res = unit($db);
        break;
    }
    return $res;
}