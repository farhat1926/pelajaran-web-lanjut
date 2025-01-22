<?php

use phpseclib3\Crypt\RSA;

require 'vendor/autoload.php'; // Pastikan phpseclib terinstall

function generateRSAKeyPair() {
    $rsa = RSA::createKey(2048); // Generate RSA 2048-bit key pair
    return [
        'private_key' => $rsa->toString('PKCS1'),
        'public_key' => $rsa->getPublicKey()->toString('PKCS1'),
    ];
}
