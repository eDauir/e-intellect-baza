<?php
function partner($db) {
        $per_page = 20;
        $start = getStart();
        $searchKey = getSearchKey();
        $activeStatus = getActiveStatus();

        if($searchKey != null) 
            $sql = "SELECT SQL_CALC_FOUND_ROWS users_profile.*, users.editor, users.mail FROM users_profile LEFT JOIN users ON users_profile.user_id = users.id WHERE users.editor = 3 AND name LIKE '%$searchKey%' OR surname LIKE '%$searchKey%' OR users.id LIKE '%$searchKey%' ORDER BY id DESC LIMIT ?i, ?i";
        else
            $sql = "SELECT SQL_CALC_FOUND_ROWS users_profile.*, users.editor, users.mail FROM users_profile LEFT JOIN users ON users_profile.user_id = users.id WHERE users.editor = 3 ORDER BY id DESC LIMIT ?i, ?i";

        $data = $db->getAll($sql, $start, $per_page);
        $rows = $db->getOne("SELECT FOUND_ROWS()");
        $customCount = 0;
        $arrayToJson = array();

        foreach($data as $elem) {
            $userId = $elem['user_id'];

            $sql = "SELECT buyRates.*, rates.name as tarifName, rates.day as rateDay FROM buyRates LEFT JOIN rates ON rates.id = buyRates.rateId WHERE userId = $userId";
            $buyRates = $db->getAll($sql);
            $elem['tarif'] = $buyRates[0];

            $oldDate = $buyRates[0]['activeDate'];
            $date1 = date("Y-m-d", strtotime($oldDate.'+ '.$buyRates[0]['rateDay'].' days'));
            $nowDate = date('Y-m-d');

            switch ($activeStatus) {
                case 'active':
                    if ($date1 >= $nowDate) {
                        $arrayToJson['users'][] = $elem;
                        $customCount++;
                    }
                    break;
                case 'inactive':
                    if ($date1 < $nowDate) {
                        $arrayToJson['users'][] = $elem;
                        $customCount++;
                    }
                    break;
                default:
                    $customCount++;
                    $arrayToJson['users'][] = $elem;
                    break;
            }
        }

        $num_pages = ceil($customCount / $per_page);
        $arrayToJson['count'] = $num_pages;

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