<?php
function partner($db) {
    switch ($_GET['subType']) {
    case 'mentorList':
        include "modules/partner/mentorList.php";
        $res = mentorList($db);
        break;
    case 'request':
        include "modules/partner/request/request.php";
        $res = request($db);
        break;
    }
    return $res;
}