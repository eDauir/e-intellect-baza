<?php
function info($db) {

	if(isset($_GET['searchKey'])) {
		$searchKey = convertStr($_GET['searchKey']);

		$per_page = 10;
        $start = getStart();

		$sql = "SELECT SQL_CALC_FOUND_ROWS users_profile.*, users.editor FROM users_profile INNER JOIN users ON users_profile.user_id = users.id WHERE users.editor = 1 AND (users_profile.name LIKE '%$searchKey%' OR users_profile.surname LIKE '%$searchKey%' OR users_profile.otchestvo LIKE '%$searchKey%') LIMIT ?i, ?i";

		$data = $db->getAll($sql, $start, $per_page);
		$rows = $db->getOne("SELECT FOUND_ROWS()");
        $num_pages = ceil($rows / $per_page);

		$res = array();

		$sql = "SELECT COUNT(users_profile.id) as idCount FROM users_profile INNER JOIN users ON users_profile.user_id = users.id WHERE users.editor = 1 AND (users_profile.name LIKE '%$searchKey%' OR users_profile.surname LIKE '%$searchKey%' OR users_profile.otchestvo LIKE '%$searchKey%')";
		$count = $db->getOne($sql);

		$res['workers'] = $data;
        $res['count'] = $num_pages;
		$res['total'] = $count;

		return $res;
	}
	
	
}

function getStart() {
    $cur_page = 1;
    $per_page = 10;
    if (isset($_GET['page']) && $_GET['page'] > 0) $cur_page = convertStr($_GET['page']);
    $start = ($cur_page - 1) * $per_page;

    return $start;
}