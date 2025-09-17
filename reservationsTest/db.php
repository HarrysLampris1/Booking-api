<?php

$mysqli = new mysqli($DBHost, $DBUser, $DBPassword,$DBName);
$mysqli->query("set character set utf8");
$mysqli->query("SET NAMES utf8");
$mysqli->set_charset('utf8');