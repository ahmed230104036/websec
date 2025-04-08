<?php

// Check if OpenSSL extension is loaded
if (!extension_loaded('openssl')) {
    die('OpenSSL extension is not loaded');
}

// Test OpenSSL functions
if (!function_exists('openssl_cipher_iv_length')) {
    die('openssl_cipher_iv_length function is not available');
}

echo 'OpenSSL is working correctly!'; 