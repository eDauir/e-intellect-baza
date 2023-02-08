<?php
function balanceHistory($db) {
        $per_page = 20;
        $start = getStart();
        $searchKey = getSearchKey();

        if($searchKey != null) 
            $sql = "SELECT SQL_CALC_FOUND_ROWS balance_history.*, fromProfile.name as fromName, fromProfile.surname as fromSurname, toProfile.name as toName, toProfile.surname as toSurname FROM balance_history LEFT JOIN users_profile as fromProfile ON fromProfile.user_id = balance_history.userId LEFT JOIN users_profile as toProfile ON toProfile.user_id = balance_history.toUser WHERE balance_history.userId = '$searchKey' OR balance_history.toUser = '$searchKey' ORDER BY id DESC LIMIT ?i, ?i";
        else 
            $sql = "SELECT SQL_CALC_FOUND_ROWS balance_history.*, fromProfile.name as fromName, fromProfile.surname as fromSurname, toProfile.name as toName, toProfile.surname as toSurname FROM balance_history LEFT JOIN users_profile as fromProfile ON fromProfile.user_id = balance_history.userId LEFT JOIN users_profile as toProfile ON toProfile.user_id = balance_history.toUser ORDER BY id DESC LIMIT ?i, ?i";

        $data = $db->getAll($sql, $start, $per_page);
        $rows = $db->getOne("SELECT FOUND_ROWS()");

        $num_pages = ceil($rows / $per_page);

        $arrayToJson = array();
        $arrayToJson['count'] = $num_pages;
        $arrayToJson['balanceHistory'] = $data;

        return $arrayToJson;
}

function getStart() {
    $cur_page = 1;
    $per_page = 20;
    if (isset($_GET['page']) && $_GET['page'] > 0) $cur_page = convertStr($_GET['page']);
    $start = ($cur_page - 1) * $per_page;

    return $start;
}

function getSearchKey() {
    if(!empty($_GET['searchKey']))
        return convertStr($_GET['searchKey']);

    return null;
}