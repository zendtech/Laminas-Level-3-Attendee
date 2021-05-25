<?php
// when Google responds to the auth request, this redirects back to the framework app
// the reason this redirector is needed is because Google will not recognize the domain "onlinemarket.work"!
$url = 'http://onlinemarket.work/oauth/google';
header('Location: ' . $url . '?' . $_SERVER['QUERY_STRING']);
exit;