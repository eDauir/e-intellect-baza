<?php
function getFaq($db) {
    $per_page = 15;
    $start = getStart();

    $sql = "SELECT * FROM faq ORDER BY id DESC LIMIT ?i, ?i";
    $data = $db->getAll($sql, $start, $per_page);
    $rows = $db->getOne("SELECT FOUND_ROWS()");
    $num_pages = ceil($rows / $per_page);

    $res = array();

    $res['faq'] = $data;
    $res['count'] = $num_pages;

    return $res;
}

function getStart() {
    $cur_page = 1;
    $per_page = 15;
    if (isset($_GET['page']) && $_GET['page'] > 0) $cur_page = convertStr($_GET['page']);
    $start = ($cur_page - 1) * $per_page;

    return $start;
}