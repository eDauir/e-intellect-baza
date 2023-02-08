<?php
function progress($db) {
    switch ($_GET['subType']) {
    case 'get':
        include "modules/progress/get.php";
        $res = get($db);
        break;
    case 'getFinish':
        include "modules/progress/getFinish.php";
        $res = getFinish($db);
        break;
    case 'update':
        include "modules/progress/update.php";
        $res = update($db);
        break;
    case 'updateFinish':
        include "modules/progress/updateFinish.php";
        $res = updateFinish($db);
        break;
    }
    return $res;
}