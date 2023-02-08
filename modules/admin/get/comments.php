<?php
function comments($db) {
        $per_page = 20;
        $start = getStart();

        $sql = "SELECT SQL_CALC_FOUND_ROWS comments.*, users_profile.name as userName, products.name as productName FROM comments LEFT JOIN products ON comments.productId = products.id LEFT JOIN users_profile ON users_profile.user_id = comments.userId ORDER BY comments.id DESC LIMIT ?i, ?i";

        $data = $db->getAll($sql, $start, $per_page);
        $rows = $db->getOne("SELECT FOUND_ROWS()");

        $num_pages = ceil($rows / $per_page);

        $arrayToJson = array();
        $arrayToJson['count'] = $num_pages;
        $arrayToJson['comments'] = $data;

        return $arrayToJson;
}

function getStart() {
    $cur_page = 1;
    $per_page = 20;
    if (isset($_GET['page']) && $_GET['page'] > 0) $cur_page = convertStr($_GET['page']);
    $start = ($cur_page - 1) * $per_page;

    return $start;
}