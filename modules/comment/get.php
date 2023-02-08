<?php
function get($db) {
    if(isset($_GET['productId'])) {
        $productId = convertStr($_GET['productId']);
        $per_page = 15;
        $start = getStart();

        $sql = "SELECT SQL_CALC_FOUND_ROWS comments.*, users_profile.name, users_profile.surname, users_profile.avatar FROM comments INNER JOIN users_profile ON users_profile.user_id = comments.userId LEFT JOIN comment_likes ON comment_likes.commentId = comments.id WHERE productId = '$productId' LIMIT ?i, ?i";
        $data = $db->getAll($sql, $start, $per_page);
        $rows = $db->getOne("SELECT FOUND_ROWS()");
        $num_pages = ceil($rows / $per_page);

        $res = array();

        $res['comments'] = $data;
        $res['count'] = $num_pages;

        return $res;
    }
}


function getStart() {
    $cur_page = 1;
    $per_page = 15;
    if (isset($_GET['page']) && $_GET['page'] > 0) $cur_page = convertStr($_GET['page']);
    $start = ($cur_page - 1) * $per_page;

    return $start;
}