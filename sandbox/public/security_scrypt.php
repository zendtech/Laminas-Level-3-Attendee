<?php
// sandbox/public/security_scrypt.php
include __DIR__ . '/../mvc-test/vendor/autoload.php';
use Laminas\Crypt\Key\Derivation\Scrypt;
use Laminas\Math\Rand;
$pass = 'password';
$salt = Rand::getBytes(32, true);
$key  = Scrypt::calc($pass, $salt, 2048, 2, 1, 32);
printf ("Original password: %s\n", $pass);
printf ("Derived key (hex): %s\n", bin2hex($key));

// sample output:
/*
Original password: password
Derived key (hex): 721c9b69c6fedc8a2b744437e750be0e9239fae6959fc8118e19e217ed072f62
 */
