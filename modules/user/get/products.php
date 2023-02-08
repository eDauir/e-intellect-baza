<?php
function products($db) {
    if(isset($_GET['id'])) {
        $id = convertStr($_GET['id']);
        $per_page = 10;
        $start = getStart();

        $sql = "SELECT SQL_CALC_FOUND_ROWS COUNT(products.id) as countFind, products.id, products.name, products.price, COUNT(lessons.id) as lessonsCount, SUM(videos.duration) as lessonsDuration, users_profile.avatar, users_profile.name as userName, users_profile.surname as userSurname, category.name as catName, AVG(comments.rating) as rating, COUNT(comments.id) as ratingCount, images.link as file FROM products LEFT JOIN images ON products.id = images.productId LEFT JOIN lessons ON products.id = lessons.productId LEFT JOIN videos ON lessons.id = videos.lessonsId INNER JOIN category ON category.id = products.categoryId LEFT JOIN comments ON products.id = comments.productId INNER JOIN users_profile ON products.userId = users_profile.user_id WHERE products.userId = '$id' GROUP BY products.id LIMIT ?i, ?i";

        $data = $db->getAll($sql, $start, $per_page);
        $rows = $db->getOne("SELECT FOUND_ROWS()");
        $num_pages = ceil($rows / $per_page);

        $res = array();

        $res['products'] = $data;
        $res['count'] = $num_pages;

        return $res;
    }
}

function getStart() {
    $cur_page = 1;
    $per_page = 10;
    if (isset($_GET['page']) && $_GET['page'] > 0) $cur_page = convertStr($_GET['page']);
    $start = ($cur_page - 1) * $per_page;

    return $start;
}