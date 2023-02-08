<?php
function getMy($db) {
    if(!empty($_GET['authToken'])) {
        $authToken = convertStr($_GET['authToken']);
        $per_page = 10;
        $start = getStart();

        // $sql = "SELECT SQL_CALC_FOUND_ROWS products.id, orders.status, orders.payboxLink, products.name, COUNT(DISTINCT lessons.id) as lessonsCount, products.price, COUNT(DISTINCT progress.id) as progressCount,images.link as file FROM orders LEFT JOIN products ON products.id = orders.productId LEFT JOIN images ON products.id = images.productId LEFT JOIN progress ON products.id = progress.productId AND progress.userId = (SELECT id FROM users WHERE accessToken = '$authToken') LEFT JOIN lessons ON products.id = lessons.productId LEFT JOIN videos ON lessons.id = videos.lessonsId WHERE orders.userId = (SELECT id FROM users WHERE accessToken = '$authToken') LIMIT ?i, ?i";

        $sql = "SELECT SQL_CALC_FOUND_ROWS products.id, products.name, products.price, images.link as file FROM orders LEFT JOIN products ON products.id = orders.productId LEFT JOIN images ON orders.productId = images.productId WHERE orders.userId = (SELECT id FROM users WHERE accessToken = '$authToken') LIMIT ?i, ?i";

        $data = $db->getAll($sql, $start, $per_page);
        $rows = $db->getOne("SELECT FOUND_ROWS()");
        $num_pages = ceil($rows / $per_page);

        $res = array();


        foreach($data as $item) {
            $elemId = $item['id'];

            $sql = "SELECT COUNT(DISTINCT lessons.id) as lessonsCount FROM lessons WHERE productId = '$elemId'";
            $lessonsCount = $db->getOne($sql);

            $sql = "SELECT COUNT(DISTINCT progress.id) as progressCount FROM progress WHERE productId = '$elemId' AND userId = (SELECT id FROM users WHERE accessToken = '$authToken')";
            $progressCount = $db->getOne($sql);

            $sql = "SELECT SUM(videos.duration) as progressDuration FROM progress INNER JOIN videos ON videos.lessonsId = progress.lessonId WHERE progress.productId = '$elemId' AND progress.userId = (SELECT id FROM users WHERE accessToken = '$authToken')";
            $progressDuration = $db->getOne($sql);

            $item['lessonsCount'] = $lessonsCount;
            $item['progressCount'] = $progressCount;
            $item['progressDuration'] = $progressDuration;

            $res['products'][] = $item;
        }

        if($data[0]['id'] != null) {
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