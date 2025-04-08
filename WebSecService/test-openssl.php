<?php
echo "PHP Version: " . phpversion() . "\n";
echo "OpenSSL installed: " . (extension_loaded('openssl') ? 'Yes' : 'No') . "\n";
echo "OpenSSL version: " . OPENSSL_VERSION_TEXT . "\n";
echo "OpenSSL functions:\n";
var_dump(function_exists('openssl_cipher_iv_length'));
echo "\nLoaded extensions:\n";
print_r(get_loaded_extensions());
?> 