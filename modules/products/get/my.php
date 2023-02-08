<?php
function my($db) {
    if(!empty($_GET['authToken'])) {
        $authToken = convertStr($_GET['authToken']);
        $per_page = 10;
        $start = getStart();

        // $sql = "SELECT SQL_CALC_FOUND_ROWS COUNT(products.id) as countFind, products.id, products.name, products.price, COUNT(lessons.id) as lessonsCount, SUM(videos.duration) as lessonsDuration, users_profile.avatar, users_profile.name as userName, users_profile.surname as userSurname, category.name as catName, AVG(comments.rating) as rating, COUNT(comments.id) as ratingCount, GROUP_CONCAT(images.link) as file FROM products LEFT JOIN images ON products.id = images.productId LEFT JOIN lessons ON products.id = lessons.productId LEFT JOIN videos ON lessons.id = videos.lessonsId INNER JOIN category ON category.id = products.categoryId LEFT JOIN comments ON products.id = comments.productId INNER JOIN users_profile ON products.userId = users_profile.user_id WHERE products.userId = (SELECT id FROM users WHERE accessToken = '$authToken') LIMIT ?i, ?i";

        
        $sql = "SELECT SQL_CALC_FOUND_ROWS products.id, products.name, products.price, users_profile.avatar, users_profile.name as userName, users_profile.surname as userSurname, category.name as catName, images.link as file FROM products LEFT JOIN images ON products.id = images.productId LEFT JOIN category ON category.id = products.categoryId LEFT JOIN users_profile ON products.userId = users_profile.user_id  WHERE products.userId = (SELECT id FROM users WHERE accessToken = '$authToken') AND products.active = 1 LIMIT ?i, ?i";

        $data = $db->getAll($sql, $start, $per_page);
        $rows = $db->getOne("SELECT FOUND_ROWS()");
        $num_pages = ceil($rows / $per_page);

        $res = array();

        foreach($data as $item) {
            $elemId = $item['id'];

            $sql = "SELECT COUNT(lessons.id) as lessonsCount FROM lessons WHERE productId = '$elemId'";
            $lessonsCount = $db->getOne($sql);

            $item['lessonsCount'] = $lessonsCount;

            $sql = "SELECT id FROM lessons WHERE productId = '$elemId'";
            $lessonsId = $db->getAll($sql);

            $lessonsDuration = 0;

            foreach($lessonsId as $elem) {
                $lessonId = $elem['id'];
                $sql = "SELECT SUM(duration) as videoDuration FROM videos WHERE lessonsId = '$lessonId'";
                $videoDuration= $db->getOne($sql);

                $lessonsDuration += $videoDuration;
            }

            $item['lessonsDuration'] = strval($lessonsDuration);

            $sql = "SELECT AVG(comments.rating) as rating FROM comments WHERE productId = '$elemId'";
            $rating = $db->getOne($sql);

            $item['rating'] = $rating;

            $sql = "SELECT COUNT(comments.id) as ratingCount FROM comments WHERE productId = '$elemId'";
            $ratingCount = $db->getOne($sql);

            $item['ratingCount'] = $ratingCount;

            $res['products'][] = $item;
        }


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