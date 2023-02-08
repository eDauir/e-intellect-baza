<?php
function one($db) {
    if(!empty($_GET['productId'])) {
        $productId = convertStr($_GET['productId']);

        $sql = "SELECT SQL_CALC_FOUND_ROWS products.*, ROUND(AVG(comments.rating), 0) as rating, COUNT(DISTINCT comments.id) as ratingCount, category.name as catName, COUNT(DISTINCT orders.id) as orderCount, GROUP_CONCAT(DISTINCT images.link) as file FROM products LEFT JOIN images ON products.id = images.productId LEFT JOIN orders ON orders.productId = products.id INNER JOIN category ON category.id = products.categoryId LEFT JOIN comments ON products.id = comments.productId WHERE products.id = $productId";
        $data = $db->getAll($sql);

        $sqlLessons = "SELECT * FROM lessons WHERE productId = $productId";
        $dataLessons = $db->getAll($sqlLessons);

        $sqlUser = "SELECT SQL_CALC_FOUND_ROWS * FROM users_profile WHERE user_id = (SELECT userId FROM products WHERE id = $productId)";
        $dataUser = $db->getAll($sqlUser);

        $sqlSection = "SELECT SQL_CALC_FOUND_ROWS * FROM sections WHERE productId = $productId";
        $dataSection = $db->getAll($sqlSection);

        $arrayToJson = array();
        $arrayToJson['lessonsCount'] = count($dataLessons);
        $arrayToJson['userInfo'] = $dataUser;
        $arrayToJson['product'] = $data;

        $duration = 0;

        foreach ($dataSection as $value) {
            foreach ($dataLessons as $elem) {
                if($elem['sectionId'] == $value['id']) {
                    $id = $elem['id'];

                    if($elem['elemType'] == '1')
                        $sqlElem = "SELECT * FROM videos WHERE lessonsId = $id";
                    else 
                        $sqlElem = "SELECT * FROM tests WHERE lessonsId = $id"; 

                    $dataElem = $db->getAll($sqlElem);

                    if($elem['elemType'] == '1') {
                        if($_GET['isWeb'] != true) $elem['elemLink'] = $dataElem[0]['link'];
                        $elem['elemDuration'] = $dataElem[0]['duration'];
                        $duration += $dataElem[0]['duration'];
                    }
                    else
                        $elem['elemLink'] = $dataElem[0]['id'];

                    $value['lessons'][] = $elem;
                }    
            }

            $arrayToJson['sections'][] = $value;
        }

        $arrayToJson['allDuration'] = $duration;

        return $arrayToJson;
    }
}