<?php

error_reporting(E_ALL);

require_once('complex_numbers.php');

$number_1 = $_POST['number_1'];
$operation = $_POST['operation'];
$number_2 = $_POST['number_2'];

$complex = new complex_numbers($number_1, $operation, $number_2);

$result = $complex->show_result();

echo $result;
