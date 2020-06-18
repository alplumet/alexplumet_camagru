<?php

function setup_db()
{
    include("database.php");

    try {
        $db = new PDO('mysql:host=localhost', 'root', 'alplumet');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $err){
        die('mysql error: ' . $err->getMessage());
    }
    $db->exec("CREATE DATABASE IF NOT EXISTS camagru");
    try {
        $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $err){
        die($err->getMessage());
    }
    $db->exec("CREATE TABLE IF NOT EXISTS user (
        `id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
		`login` VARCHAR(24) NOT NULL DEFAULT 'john doe',
		`email` VARCHAR(320) NOT NULL,
		`passwd` VARCHAR(1024) NOT NULL,
        `notif` VARCHAR(2) NOT NULL DEFAULT 'Y',
        `keymail` VARCHAR(32) NOT NULL DEFAULT 'keymail',
        `actif` INT NOT NULL DEFAULT 0)");

    $db->exec("CREATE TABLE IF NOT EXISTS picture (
        `id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT, 
        `name` VARCHAR(320) NOT NULL DEFAULT 'mystery',
		`login` VARCHAR(24) NOT NULL DEFAULT 'john doe',
        `email` VARCHAR(320) NOT NULL)");

    $db->exec("CREATE TABLE IF NOT EXISTS comment (
        `id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT, 
        `picture` VARCHAR(320) NOT NULL,
		`login` VARCHAR(24) NOT NULL DEFAULT 'john doe',
        `com` VARCHAR(320) NOT NULL DEFAULT 'mystery')");
    
    $db->exec("CREATE TABLE IF NOT EXISTS likes (
        `id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT, 
        `picture` VARCHAR(320) NOT NULL,
        `boss` VARCHAR(24) NOT NULL DEFAULT 'john doe',
		`login` VARCHAR(24) NOT NULL DEFAULT 'john doe;',
        `number` INT NOT NULL DEFAULT 0)");
}
?>

