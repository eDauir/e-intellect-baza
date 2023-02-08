<?php
function lessons($db) {

    if(!empty($_GET['id'])) {
        $per_page = 20;
        $start = getStart();
        $id = convertStr($_GET['id']);

        $sql = "SELECT SQL_CALC_FOUND_ROWS lessons.*, sections.name, lessons.name as lessonsName,
        CASE
        WHEN lessons.elemType = 1 THEN videos.link
        ELSE tests.id
        END as elemValue 
        FROM lessons LEFT JOIN sections ON sections.id = lessons.sectionId LEFT JOIN videos ON videos.lessonsId = lessons.id LEFT JOIN tests ON tests.lessonsId = lessons.id WHERE lessons.productId = $id ORDER BY lessons.id DESC LIMIT ?i, ?i";

        $data = $db->getAll($sql, $start, $per_page);
        $rows = $db->getOne("SELECT FOUND_ROWS()");

        $num_pages = ceil($rows / $per_page);

        $arrayToJson = array();
        $arrayToJson['count'] = $num_pages;
        $arrayToJson['lessons'] = $data;

        return $arrayToJson;
    }

    return false;
}

function getStart() {
    $cur_page = 1;
    $per_page = 20;
    if (isset($_GET['page']) && $_GET['page'] > 0) $cur_page = convertStr($_GET['page']);
    $start = ($cur_page - 1) * $per_page;

    return $start;
}