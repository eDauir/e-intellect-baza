<?php
function getCards($db) {
    if(!empty($_GET['authToken'])) {
        $authToken = convertStr($_GET['authToken']);
        $per_page = 10;
        $start = getStart();

        $sql = "SELECT SQL_CALC_FOUND_ROWS COUNT(products.id) as countFind, products.id, products.name, products.price, COUNT(lessons.id) as lessonsCount, SUM(videos.duration) as lessonsDuration, users_profile.avatar, users_profile.name as userName, users_profile.surname as userSurname, category.name as catName, AVG(comments.rating) as rating, COUNT(comments.id) as ratingCount, images.link as file FROM likes INNER JOIN products ON likes.productId = products.id INNER JOIN category ON category.id = products.categoryId INNER JOIN users_profile ON products.userId = users_profile.user_id INNER JOIN images ON likes.productId = images.productId LEFT JOIN lessons ON products.id = lessons.productId LEFT JOIN videos ON lessons.id = videos.lessonsId LEFT JOIN comments ON products.id = comments.productId WHERE likes.userId = (SELECT id FROM users WHERE accessToken = '$authToken') GROUP BY products.id ORDER BY products.id DESC LIMIT ?i, ?i";

        $data = $db->getAll($sql, $start, $per_page);
        $rows = $db->getOne("SELECT FOUND_ROWS()");
        $num_pages = ceil($rows / $per_page);

        $res = array();

        if($data[0]['id'] != null) {
            $res['products'] = $data;
            $res['count'] = $num_pages;

            return $res;
        }

        return [];
    }
}

function getStart() {
    $cur_page = 1;
    $per_page = 10;
    if (isset($_GET['page']) && $_GET['page'] > 0) $cur_page = convertStr($_GET['page']);
    $start = ($cur_page - 1) * $per_page;

    return $start;
}