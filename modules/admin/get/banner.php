<?php
function banner($db) {
        $sql = "SELECT * FROM banner";

        $data = $db->getAll($sql);
        return $data;
}