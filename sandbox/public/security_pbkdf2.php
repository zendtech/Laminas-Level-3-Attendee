<?php
// sandbox/public/security_pbkdf2.php

include __DIR__ . '/../mvc-test/vendor/autoload.php';
use Laminas\Crypt\Key\Derivation\Pbkdf2;
use Laminas\Math\Rand;

$pass = 'password';
$salt = Rand::getBytes(32, true);
$key  = Pbkdf2::calc('sha256', $pass, $salt, 10000, 32);
printf ("%12s : %s\n", 'Original:', $pass);
printf ("%12s : %s\n", 'Derived:', base64_encode($key));
