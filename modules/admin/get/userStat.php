<?php
function userStat($db) {

        $sql = "SELECT SQL_CALC_FOUND_ROWS COUNT(products.id) AS count, users_profile.name FROM products LEFT JOIN users_profile ON products.userId = users_profile.user_id GROUP BY products.userId ORDER BY count DESC LIMIT 10";
        $data = $db->getAll($sql);

        return $data;
}