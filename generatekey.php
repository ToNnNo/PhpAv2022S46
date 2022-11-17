<?php

$passphrase = "commentestvotreblanquette";
$config = [
    // 'config' => 'C:/wamp64/bin/php/php7.4.9/extras/ssl/openssl.cnf',
    'private_key_bits' => 2048,
    'private_key_type' => OPENSSL_KEYTYPE_RSA
];

// Configure et crée la clé privé en mémoire
$resource = openssl_pkey_new($config);


// export la clé privé
// $status = openssl_pkey_export_to_file($privateKey, __DIR__."/key.rsa", $passphrase);

openssl_pkey_export($resource, $privateKey, $passphrase, $config);
file_put_contents(__DIR__."/key.rsa", $privateKey);

// vérifie la clé
// si $status est faux
/*if(!$status) {
    // openssl_error_string() retourne les erreurs de openssl
    throw new \RuntimeException(openssl_error_string());
}*/

//export de la clé public
$arrayKey = openssl_pkey_get_details($resource);
file_put_contents(__DIR__."/key.rsa.pub", $arrayKey['key']);

//efface la clé de la mémoire
openssl_free_key($resource);
