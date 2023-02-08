<?php

$sql = "INSERT INTO orders (userId, productId) VALUES ('$userId', '$productId')";
$db->query($sql);
$orderId = $db->insertId();

$sql = "INSERT INTO balance_history (userId, type, amount) VALUES ('$userId', 4, '$amount')";
$insertQuery = $db->query($sql);

$sql = "SELECT userId FROM products WHERE id = $productId";
$sellerId = $db->getOne($sql);

$sql = "INSERT INTO balance_history (userId, type, amount) VALUES ($sellerId, 6, $amount * 0.3)";
$insertQuery = $db->query($sql);

$sql = "UPDATE balance SET amount = amount + $amount * 0.3 WHERE userId = $sellerId";
$updateQuery = $db->query($sql);

// RASCHET PARTNER PROCENT

    // НУЖНО НАПИСАТЬ ФУНКЦИЮ КОТОРАЯ ОПРЕДЕЛЯЕТ ПРОЦЕНТ ПОПОЛНЕНИЯ ОТ СУММЫ ПОКУПКИ КЛИЕНТОМ
        // ПРОЦЕНТ ЗАВИСИТ ОТ ОБЪЕМА ВЫПОЛНЕННЫЙ ПАРТНЕРОМ
            // ВЫВЕСТИ ОБЪЕМ КОТОРЫЙ ВЫПОЛНИЛ ПАРТНЕР И ЗАТЕМ ПОСТАВИТЬ В СВИТЧ И СЧИТАТЬ СУММУ

$sql = "SELECT tutorId FROM linkPartnerMentor WHERE mentorId = $sellerId";
$partnerId = $db->getOne($sql);

$sql = "INSERT INTO balance_history (userId, type, amount) VALUES ($partnerId, 3, $amount * 0.1)";
$insertQuery = $db->query($sql);

$sql = "UPDATE balance SET amount = amount + $amount * 0.1 WHERE userId = $partnerId";
$updateQuery = $db->query($sql);

// 0.1 PROCENT VSEGDA V FUND

    // FUND - 1 TYPE - POPOLNENIE
    // FUND - 2 TYPE - VIVOD

$sql = "INSERT INTO billionaireFund (type, amount) VALUES (1, $amount * 0.1)";
$insertQuery = $db->query($sql);