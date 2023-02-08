<?php
function rates($db) {
        $sql = "SELECT * FROM rates";

        $data = $db->getAll($sql);
        return $data;
}