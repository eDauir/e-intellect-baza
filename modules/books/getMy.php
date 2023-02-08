<?php
function getMy($db) {
    if(isset($_GET['authToken'])) {
        $authToken = convertStr($_GET['authToken']);

        $sql = "SELECT books.*, category.name as catName, users_profile.name, users_profile.surname FROM orderBook INNER JOIN books ON books.id = orderBook.bookId LEFT JOIN users_profile ON users_profile.user_id = books.userId LEFT JOIN category ON category.id = books.category WHERE orderBook.userId = (SELECT id FROM users WHERE accessToken = '$authToken')";
        $data = $db->getAll($sql);

        return $data;
    }
}