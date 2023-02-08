<?php
function mentorList($db) {
	if(isset($_GET['authToken'])) {
		$authToken = convertStr($_GET['authToken']);
		$searchKey = getSearchKey();

		$per_page = 10;
        $start = getStart();

		$sql = "SELECT SQL_CALC_FOUND_ROWS linkPartnerMentor.mentorId as id, users_profile.name, users_profile.surname, users.mail, users_profile.avatar FROM linkPartnerMentor LEFT JOIN users_profile ON linkPartnerMentor.mentorId = users_profile.user_id LEFT JOIN users ON linkPartnerMentor.mentorId = users.id WHERE linkPartnerMentor.partnerId = (SELECT id FROM users WHERE accessToken = '$authToken') AND linkPartnerMentor.accepted = 1 AND (users_profile.name LIKE '%$searchKey%' OR users.mail LIKE '%$searchKey%' OR linkPartnerMentor.mentorId LIKE '%$searchKey%') ORDER BY id DESC LIMIT ?i, ?i";

		$data = $db->getAll($sql, $start, $per_page);
		$rows = $db->getOne("SELECT FOUND_ROWS()");
        $num_pages = ceil($rows / $per_page);

		$res = array();

		$res['mentors'] = $data;
        $res['count'] = $num_pages;

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

function getSearchKey() {
    if(!empty($_GET['searchKey']))
        return convertStr($_GET['searchKey']);

    return null;
}

