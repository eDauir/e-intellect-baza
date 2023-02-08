<?php
function get($db) {

    $sql = "SELECT * FROM rates ORDER BY price ASC";
    $data = $db->getAll($sql);

    return $data;
}