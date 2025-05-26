<?php
$password = 'syakirah123';
$hash = password_hash($password, PASSWORD_DEFAULT);
echo "Hash untuk password '$password': " . $hash;

$password = 'reyqal25';
$hash = password_hash($password, PASSWORD_DEFAULT);
echo "Hash untuk password '$password': " . $hash;

$password = 'putri123';
$hash = password_hash($password, PASSWORD_DEFAULT);
echo "Hash untuk password '$password': " . $hash;
?>