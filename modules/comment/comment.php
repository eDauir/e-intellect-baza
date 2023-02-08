<?php
function comment($db) {
    switch ($_GET['subType']) {
    case 'get':
        include "modules/comment/get.php";
        $res = get($db);
        break;
    case 'put':
        include "modules/comment/put.php";
        $res = put($db);
        break;
    case 'putLike':
        include "modules/comment/putLike.php";
        $res = putLike($db);
        break;
    }
    return $res;
}