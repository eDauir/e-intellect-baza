<?php
function info($db) {
	$per_page = 15;
	$start = getStart();

	$sql = "SELECT SQL_CALC_FOUND_ROWS users_profile.*, users.editor FROM users_profile INNER JOIN users ON users_profile.user_id = users.id WHERE users.editor = 1 LIMIT ?i, ?i";
	$data = $db->getAll($sql, $start, $per_page);
	$rows = $db->getOne("SELECT FOUND_ROWS()");
	$num_pages = ceil($rows / $per_page);

	$res = array();

    $res['workers'] = $data;
    $res['count'] = $num_pages;

	return $res;
}

function getStart() {
    $cur_page = 1;
    $per_page = 15;
    if (isset($_GET['page']) && $_GET['page'] > 0) $cur_page = convertStr($_GET['page']);
    $start = ($cur_page - 1) * $per_page;

    return $start;
}