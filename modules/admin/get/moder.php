<?php
function moder($db) {
        $sql = "SELECT users_profile.*, users.editor, users.mail FROM users_profile LEFT JOIN users ON users_profile.user_id = users.id WHERE users.editor = 2 ORDER BY id DESC";

        $data = $db->getAll($sql);
        return $data;
}