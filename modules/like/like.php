<?php
function like($db) {
    switch ($_GET['subType']) {
    case 'getCards':
        include "modules/like/getCards.php";
        $res = getCards($db);
        break;
    case 'getList':
        include "modules/like/getList.php";
        $res = getList($db);
        break;
    case 'put':
        include "modules/like/put.php";
        $res = put($db);
        break;
    case 'delete':
        include "modules/like/delete.php";
        $res = delete($db);
        break;
    }
    return $res;
}