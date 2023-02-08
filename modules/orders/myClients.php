<?php
function myClients($db) {

	if(isset($_GET['searchKey']) && !empty($_GET['authToken'])) {
		$searchKey = convertStr($_GET['searchKey']);
        $authToken = convertStr($_GET['authToken']);

		$per_page = 15;
        $start = getStart();

		$sql = "SELECT SQL_CALC_FOUND_ROWS users_profile.name, users_profile.surname, users_profile.avatar, users.mail FROM users_profile INNER JOIN users ON users_profile.user_id = users.id WHERE users.id IN (SELECT userId FROM orders WHERE productId IN (SELECT id FROM products WHERE userId = (SELECT id FROM users WHERE accessToken = '$authToken'))) AND (users_profile.name LIKE '%$searchKey%' OR users_profile.surname LIKE '%$searchKey%') LIMIT ?i, ?i";

		$data = $db->getAll($sql, $start, $per_page);
		$rows = $db->getOne("SELECT FOUND_ROWS()");
        $num_pages = ceil($rows / $per_page);

		$res = array();

		$res['clients'] = $data;
        $res['count'] = $num_pages;

		return $res;
	}
	
	
}

function getStart() {
    $cur_page = 1;
    $per_page = 15;
    if (isset($_GET['page']) && $_GET['page'] > 0) $cur_page = convertStr($_GET['page']);
    $start = ($cur_page - 1) * $per_page;

    return $start;
}