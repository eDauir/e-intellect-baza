<?php
function getNotify($db) {
    $per_page = 20;
    $start = getStart();

    if(empty($_GET['authToken']))
        return [];

    $authToken = convertStr($_GET['authToken']);

    $sql = "SELECT * FROM notify WHERE userId = (SELECT id FROM users WHERE accessToken = '$authToken') OR userId = 'all' GROUP BY YEAR(date), MONTH(date), DAY(date) ORDER BY date DESC LIMIT ?i, ?i";
    $data = $db->getAll($sql, $start, $per_page);
    $rows = $db->getOne("SELECT FOUND_ROWS()");
    $num_pages = ceil($rows / $per_page);

    $res = array();

    foreach($data as $notify) {
        $date = explode(" ", $notify['date'])[0];
        list($y, $m, $d) = explode('-', $date);

        $sql = "SELECT * FROM notify WHERE userId = (SELECT id FROM users WHERE accessToken = '$authToken') OR userId = 'all' AND DAY(date) = $d AND MONTH(date) = $m AND YEAR(date) = $y ORDER BY id DESC";
        $temporary = $db->getAll($sql);

        $date_now = new DateTime();
        $date_tomorrow = new DateTime('yesterday');
        $date2 = new DateTime($date);

        if ($date_now->format('Y-m-d') == $date2->format('Y-m-d')) {
            $date = 'Сегодня';
        }
        elseif ($date_tomorrow->format('Y-m-d') == $date2->format('Y-m-d')) {
            $date = 'Вчера';
        }

        $res['notify'][$date] = $temporary;
    }

    $res['count'] = $num_pages;

    if(empty($res['notift']))
        return [];

    return $res;
}

function getStart() {
    $cur_page = 1;
    $per_page = 20;
    if (isset($_GET['page']) && $_GET['page'] > 0) $cur_page = convertStr($_GET['page']);
    $start = ($cur_page - 1) * $per_page;

    return $start;
}