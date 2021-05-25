<?php
session_start();
$fn = trim($_GET['fn']) ?? '';
$fn = __DIR__ . '/../data/uploads/' . $fn;
if (!file_exists($fn)) {
    $fn = __DIR__ . '/../data/uploads/person.png';
}
header('Content-Type: ' . mime_content_type($fn));
readfile($fn);

