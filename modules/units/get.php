<?php
function get($db) {
    $sql = "SELECT SUM(amount) as sum FROM units";
    $data = $db->getAll($sql);

    return $data;
}