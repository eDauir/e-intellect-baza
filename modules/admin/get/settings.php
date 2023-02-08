<?php
function settings($db) {

        $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM settings LIMIT 1";
        $data = $db->getAll($sql);

        return $data;
}