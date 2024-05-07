<?php


session_start();
session_destroy();

header('HTTP/1.1 401 Unauthorized');
header('WWW-Authenticate: Digest realm="Restricted area",qop="auth",nonce="' . uniqid() . '",opaque="' . md5('Restricted area') . '"');

exit;
?>