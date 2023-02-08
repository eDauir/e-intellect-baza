<?php
$sql = "SELECT SQL_CALC_FOUND_ROWS products.id, products.name, products.price, COUNT(DISTINCT lessons.id) as lessonsCount, SUM(videos.duration) as lessonsDuration, users_profile.avatar, users_profile.name as userName, users_profile.surname as userSurname, category.name as catName, AVG(DISTINCT comments.rating) as rating, COUNT(DISTINCT comments.id) as ratingCount, GROUP_CONCAT(DISTINCT images.link) as file FROM products LEFT JOIN images ON products.id = images.productId LEFT JOIN lessons ON products.id = lessons.productId LEFT JOIN videos ON lessons.id = videos.lessonsId LEFT JOIN category ON category.id = products.categoryId LEFT JOIN comments ON products.id = comments.productId LEFT JOIN users_profile ON products.userId = users_profile.user_id WHERE";

$sql = $sql . " products.active = 1";

if(!empty($_GET['categoryId'])) {
    $catId = convertStr($_GET['categoryId']);

    $sql = $sql . " AND products.categoryId = '$catId'";
}

if(!empty($_GET['searchKey'])) {
    $searchKey = convertStr($_GET['searchKey']);

    $sql = $sql . " AND products.name LIKE '%$searchKey%'";
}

if(!empty($_GET['online'])) {
    $online = convertStr($_GET['online']);
    if($online == 'true')
        $sql = $sql . " AND products.online = 1";
    else 
        $sql = $sql . " AND products.online = 0";
}

if(!empty($_GET['userId'])) {
    $userId = convertStr($_GET['userId']);

    $sql = $sql . " AND products.userId = '$userId'";
}

$sql = $sql . " GROUP BY products.id ORDER BY products.$orderBy $orderType LIMIT ?i, ?i";