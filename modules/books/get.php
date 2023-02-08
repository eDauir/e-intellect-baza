<?php
function get($db) {
        $per_page = 1;
        $start = getStart();
        $searchKey = getSearchKey();
        $categoryKey = getCategoryKey();

        if($searchKey != null) 
            if($categoryKey != null) 
                $sql = "SELECT SQL_CALC_FOUND_ROWS books.*, users_profile.name, users_profile.surname, category.name as catName FROM books LEFT JOIN users_profile ON users_profile.user_id = books.userId LEFT JOIN category ON category.id = books.category WHERE books.category = '$categoryKey' AND (books.title LIKE '%$searchKey%' OR users_profile.name LIKE '%$searchKey%') ORDER BY id DESC LIMIT ?i, ?i";
            else   
                $sql = "SELECT SQL_CALC_FOUND_ROWS books.*, users_profile.name, users_profile.surname, category.name as catName FROM books LEFT JOIN users_profile ON users_profile.user_id = books.userId LEFT JOIN category ON category.id = books.category WHERE books.title LIKE '%$searchKey%' OR users_profile.name LIKE '%$searchKey%' ORDER BY id DESC LIMIT ?i, ?i";
        else 
            if($categoryKey != null) 
                $sql = "SELECT SQL_CALC_FOUND_ROWS books.*, users_profile.name, users_profile.surname, category.name as catName FROM books LEFT JOIN users_profile ON users_profile.user_id = books.userId LEFT JOIN category ON category.id = books.category WHERE books.category = '$categoryKey' ORDER BY id DESC LIMIT ?i, ?i";
            else   
                $sql = "SELECT SQL_CALC_FOUND_ROWS books.*, users_profile.name, users_profile.surname, category.name as catName FROM books LEFT JOIN users_profile ON users_profile.user_id = books.userId LEFT JOIN category ON category.id = books.category ORDER BY id DESC LIMIT ?i, ?i";

        $data = $db->getAll($sql, $start, $per_page);
        $rows = $db->getOne("SELECT FOUND_ROWS()");

        $num_pages = ceil($rows / $per_page);

        $arrayToJson = array();
        $arrayToJson['count'] = $num_pages;
        $arrayToJson['books'] = $data;

        return $arrayToJson;
}

function getStart() {
    $cur_page = 1;
    $per_page = 1;
    if (isset($_GET['page']) && $_GET['page'] > 0) $cur_page = convertStr($_GET['page']);
    $start = ($cur_page - 1) * $per_page;

    return $start;
}

function getSearchKey() {
    if(!empty($_GET['searchKey']))
        return convertStr($_GET['searchKey']);

    return null;
}

function getCategoryKey() {
    if(!empty($_GET['categoryKey']))
        return convertStr($_GET['categoryKey']);

    return null;
}