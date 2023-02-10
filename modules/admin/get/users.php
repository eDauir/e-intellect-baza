<?php
function users($db) {
        $per_page = 20;
        $start = getStart();
        $searchKey = getSearchKey();
        $activeStatus = getActiveStatus();

        if($searchKey != null) {
            switch ($activeStatus) {
                case 'active':
                    $sql = "SELECT SQL_CALC_FOUND_ROWS users_profile.*, users.editor, users.mail , users.activeStatus FROM users_profile LEFT JOIN users ON users_profile.user_id = users.id WHERE users.activeStatus = 0 AND (name LIKE '%$searchKey%' OR surname LIKE '%$searchKey%' OR users.id LIKE '%$searchKey%') ORDER BY id DESC LIMIT ?i, ?i";
                    break;
                case 'inactive':
                    $sql = "SELECT SQL_CALC_FOUND_ROWS users_profile.*, users.editor, users.mail , users.activeStatus FROM users_profile LEFT JOIN users ON users_profile.user_id = users.id WHERE users.activeStatus = 1 AND (name LIKE '%$searchKey%' OR surname LIKE '%$searchKey%' OR users.id LIKE '%$searchKey%') ORDER BY id DESC LIMIT ?i, ?i";
                    break;
                default:
                    $sql = "SELECT SQL_CALC_FOUND_ROWS users_profile.*, users.editor, users.mail , users.activeStatus FROM users_profile LEFT JOIN users ON users_profile.user_id = users.id WHERE name LIKE '%$searchKey%' OR surname LIKE '%$searchKey%' OR users.id LIKE '%$searchKey%' ORDER BY id DESC LIMIT ?i, ?i";
                    break;
            }
        }
        else {
            switch ($activeStatus) {
                case 'active':
                    $sql = "SELECT SQL_CALC_FOUND_ROWS users_profile.*, users.editor, users.mail , users.activeStatus FROM users_profile LEFT JOIN users ON users_profile.user_id = users.id WHERE users.activeStatus = 0 ORDER BY id DESC LIMIT ?i, ?i";
                    break;
                case 'inactive':
                    $sql = "SELECT SQL_CALC_FOUND_ROWS users_profile.*, users.editor, users.mail , users.activeStatus FROM users_profile LEFT JOIN users ON users_profile.user_id = users.id WHERE users.activeStatus = 1 ORDER BY id DESC LIMIT ?i, ?i";
                    break;
                default:
                    $sql = "SELECT SQL_CALC_FOUND_ROWS users_profile.*, users.editor, users.mail , users.activeStatus FROM users_profile LEFT JOIN users ON users_profile.user_id = users.id ORDER BY id DESC LIMIT ?i, ?i";
                    break;
            }
        }

        $data = $db->getAll($sql, $start, $per_page);
        $rows = $db->getOne("SELECT FOUND_ROWS()");

        $num_pages = ceil($rows / $per_page);

        $arrayToJson = array();

        foreach($data as $item) {
            $userId = $item['user_id'];
            $sql = "SELECT COUNT(id) FROM orders WHERE userId = $userId";
            $item['ordersCount'] = $db->getOne($sql);
            $arrayToJson['users'][] = $item;
        }

        $arrayToJson['count'] = $num_pages;
        // $arrayToJson['users'] = $data;

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