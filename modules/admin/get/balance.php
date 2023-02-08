<?php
function balance($db) {
        $per_page = 20;
        $start = getStart();
        $searchKey = getSearchKey();

        if($searchKey != null) 
            $sql = "SELECT SQL_CALC_FOUND_ROWS balance.*, users_profile.name, users_profile.surname FROM balance LEFT JOIN users_profile ON users_profile.user_id = balance.userId WHERE balance.userId = '$searchKey' ORDER BY id DESC LIMIT ?i, ?i";
        else 
            $sql = "SELECT SQL_CALC_FOUND_ROWS balance.*, users_profile.name, users_profile.surname FROM balance LEFT JOIN users_profile ON users_profile.user_id = balance.userId ORDER BY id DESC LIMIT ?i, ?i";

        $data = $db->getAll($sql, $start, $per_page);
        $rows = $db->getOne("SELECT FOUND_ROWS()");

        $num_pages = ceil($rows / $per_page);

        $arrayToJson = array();
        $arrayToJson['count'] = $num_pages;
        $arrayToJson['balance'] = $data;

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