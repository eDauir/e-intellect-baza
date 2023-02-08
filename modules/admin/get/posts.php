<?php
function posts($db) {
        $per_page = 20;
        $start = getStart();
        $searchKey = getSearchKey();
        $activeStatus = getActiveStatus();

	    $authToken = convertStr($_GET['authToken']);

        if($searchKey != null) 
            switch ($activeStatus) {
                case 'active':
                    $sql = "SELECT SQL_CALC_FOUND_ROWS products.*, category.name as catName, images.link, users_profile.name as uName, users_profile.surname as uSurname FROM products LEFT JOIN category ON category.id = products.categoryId LEFT JOIN users_profile ON users_profile.user_id = products.userId LEFT JOIN images ON images.productId = products.id WHERE products.active = 1 AND products.name LIKE '%$searchKey%' OR products.id LIKE '%$searchKey%' ORDER BY products.id DESC LIMIT ?i, ?i";
                    break;
                case 'inactive':
                    $sql = "SELECT SQL_CALC_FOUND_ROWS products.*, category.name as catName, images.link, users_profile.name as uName, users_profile.surname as uSurname FROM products LEFT JOIN category ON category.id = products.categoryId LEFT JOIN users_profile ON users_profile.user_id = products.userId LEFT JOIN images ON images.productId = products.id WHERE products.active = 0 AND products.name LIKE '%$searchKey%' OR products.id LIKE '%$searchKey%' ORDER BY products.id DESC LIMIT ?i, ?i";
                    break;
                default:
                    $sql = "SELECT SQL_CALC_FOUND_ROWS products.*, category.name as catName, images.link, users_profile.name as uName, users_profile.surname as uSurname FROM products LEFT JOIN category ON category.id = products.categoryId LEFT JOIN users_profile ON users_profile.user_id = products.userId LEFT JOIN images ON images.productId = products.id WHERE products.name LIKE '%$searchKey%' OR products.id LIKE '%$searchKey%' ORDER BY products.id DESC LIMIT ?i, ?i";
                    break;
            }   
        else
            switch ($activeStatus) {
                case 'active':
                    $sql = "SELECT SQL_CALC_FOUND_ROWS products.*, category.name as catName, images.link, users_profile.name as uName, users_profile.surname as uSurname FROM products LEFT JOIN category ON category.id = products.categoryId LEFT JOIN users_profile ON users_profile.user_id = products.userId LEFT JOIN images ON images.productId = products.id WHERE products.active = 1 ORDER BY products.id DESC LIMIT ?i, ?i";
                    break;
                case 'inactive':
                    $sql = "SELECT SQL_CALC_FOUND_ROWS products.*, category.name as catName, images.link, users_profile.name as uName, users_profile.surname as uSurname FROM products LEFT JOIN category ON category.id = products.categoryId LEFT JOIN users_profile ON users_profile.user_id = products.userId LEFT JOIN images ON images.productId = products.id WHERE products.active = 0 ORDER BY products.id DESC LIMIT ?i, ?i";
                    break;
                default:
                    $sql = "SELECT SQL_CALC_FOUND_ROWS products.*, category.name as catName, images.link, users_profile.name as uName, users_profile.surname as uSurname FROM products LEFT JOIN category ON category.id = products.categoryId LEFT JOIN users_profile ON users_profile.user_id = products.userId LEFT JOIN images ON images.productId = products.id  ORDER BY products.id DESC LIMIT ?i, ?i";
                    break;
            } 

        $data = $db->getAll($sql, $start, $per_page);
        $rows = $db->getOne("SELECT FOUND_ROWS()");

        $num_pages = ceil($rows / $per_page);

        $arrayToJson = array();
        $arrayToJson['count'] = $num_pages;
        $arrayToJson['posts'] = $data;

        return $arrayToJson;
}

function getStart() {
    $cur_page = 1;
    $per_page = 20;
    if (isset($_GET['page']) && $_GET['page'] > 0) $cur_page = convertStr($_GET['page']);
    $start = ($cur_page - 1) * $per_page;

    return $start;
}

function getSearchKey() {
    if(!empty($_GET['searchKey']))
        return convertStr($_GET['searchKey']);

    return null;
}

function getActiveStatus() {
    if(!empty($_GET['activeStatus']))
        return convertStr($_GET['activeStatus']);

    return null;
}