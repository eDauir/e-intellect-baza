<?php
function media($db) {
        $per_page = 12;
        $start = getStart();

        $media = $_GET['mType'] == 'videos' ? 'videos' : 'images';

        $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM $media ORDER BY id DESC LIMIT ?i, ?i";

        $data = $db->getAll($sql, $start, $per_page);
        $rows = $db->getOne("SELECT FOUND_ROWS()");

        $num_pages = ceil($rows / $per_page);


        $dir  = '/var/www/proba/www';

        $arrayToJson = array();
        $arrayToJson['count'] = 1;
        $arrayToJson['media'] = $data;

        return $arrayToJson;
}

function getStart() {
    $cur_page = 1;
    $per_page = 12;
    if (isset($_GET['page']) && $_GET['page'] > 0) $cur_page = convertStr($_GET['page']);
    $start = ($cur_page - 1) * $per_page;

    return $start;
}
