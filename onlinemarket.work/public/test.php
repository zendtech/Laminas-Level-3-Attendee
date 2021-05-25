<?php
// code we just looked at
include __DIR__ . '/../vendor/autoload.php';
use Laminas\Crypt\Key\Derivation\Scrypt;
use Laminas\Math\Rand;
$pass = 'password';
$salt = Rand::getBytes(32, true);
$key  = Scrypt::calc($pass, $salt, 2048, 2, 1, 32);
printf ("Original password: %s\n", $pass);
printf ("Derived key (hex): %s\n", bin2hex($key));
