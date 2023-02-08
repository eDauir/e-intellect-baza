<?php
function get($db) {
    $arrayToJson = array();

    if(!empty($_GET['authToken'])) {
        $authToken = convertStr($_GET['authToken']);

        $sql = "SELECT balance.*, units.amount as unitValue FROM balance LEFT JOIN units ON units.userId = balance.userId WHERE balance.userId = (SELECT id FROM users WHERE accessToken = '$authToken')";
        $data = $db->getAll($sql);
    }

    $arrayToJson['main'] = $data;

    if(!empty($_GET['authToken'])) {
        $authToken = convertStr($_GET['authToken']);

        $per_page = 5;
        $start = getStart();

        $sql = "SELECT SQL_CALC_FOUND_ROWS balance_history.*, fromUser.name as fromName, toUser.name as toName FROM balance_history LEFT JOIN users_profile AS fromUser ON fromUser.user_id = balance_history.userId LEFT JOIN users_profile AS toUser ON toUser.user_id = balance_history.toUser WHERE balance_history.userId = (SELECT id FROM users WHERE accessToken = '$authToken') OR ( balance_history.type = 5 AND balance_history.toUser = (SELECT id FROM users WHERE accessToken = '$authToken') ) ORDER BY id DESC LIMIT ?i, ?i";
        $data = $db->getAll($sql, $start, $per_page);
        $rows = $db->getOne("SELECT FOUND_ROWS()");

        $num_pages = ceil($rows / $per_page);

        $arrayToJson['count'] = $num_pages;
        $arrayToJson['history'] = $data;

        // POPOL TYPE = 1
        // VIVOD TYPE = 2 
        // BONUS TYPE = 3
        // POKUP TYPE = 4
        // PEREVOD TYPE = 5
        // PRODAJA TYPE = 6
        // POKUP ED = 7
        // BONUS ED = 8

    }

    return $arrayToJson;
}

function getStart() {
    $cur_page = 1;
    $per_page = 5;
    if (isset($_GET['page']) && $_GET['page'] > 0) $cur_page = convertStr($_GET['page']);
    $start = ($cur_page - 1) * $per_page;

    return $start;
}