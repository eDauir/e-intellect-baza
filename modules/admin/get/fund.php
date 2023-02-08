<?php
function fund($db) {
        $per_page = 20;
        $start = getStart();
        $searchKey = getSearchKey();

        if($searchKey != null) 
            $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM billionaireFund WHERE type = '$searchKey' ORDER BY id DESC LIMIT ?i, ?i";
        else 
            $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM billionaireFund ORDER BY id DESC LIMIT ?i, ?i";

        $data = $db->getAll($sql, $start, $per_page);
        $rows = $db->getOne("SELECT FOUND_ROWS()");

        $num_pages = ceil($rows / $per_page);

        $arrayToJson = array();
        $arrayToJson['count'] = $num_pages;
        $arrayToJson['fundHistory'] = $data;

        $sql = "SELECT SUM(amount) as sum FROM billionaireFund WHERE type = 1";
        $sumPlus = $db->getOne($sql);

        $sql = "SELECT SUM(amount) as sum FROM billionaireFund WHERE type = 0";
        $sumMinus = $db->getOne($sql);

        $arrayToJson['sum'] = strval($sumPlus - $sumMinus);

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