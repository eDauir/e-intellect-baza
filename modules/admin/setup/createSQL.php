<?php
$queries = array();

$queries[] = "CREATE TABLE `global` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `color1` varchar(20) NOT NULL,
 `color2` varchar(20) NOT NULL,
 `color3` varchar(20) NOT NULL,
 `logo` varchar(255) NOT NULL,
 `homeBlock` varchar(50) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";