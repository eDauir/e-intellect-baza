<?php
function contacts($db) {

        $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM contacts LIMIT 1";
        $data = $db->getAll($sql);

        return $data;
}