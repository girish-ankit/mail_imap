<?php

error_reporting(E_ERROR | E_PARSE);

class SA_Encryption {

    const OPEN_SSL_METHOD = 'aes-256-cbc';
    // Generate a 256-bit encryption key
    const BASE64_ENCRYPTION_KEY = 'G1fM0aXhguJ5tVaqVMJOVHB+Jk6QFd99FgkfAcEgwjI'; //base64_encode(openssl_random_pseudo_bytes(32));
    const BASE64_IV = 'xIkaHuquZFjtP4SI4mIyOg'; //base64_encode(openssl_random_pseudo_bytes(openssl_cipher_iv_length(AES_256_CBC)));

    static private function base64_url_encode($input) {
        return strtr(base64_encode($input), '+/=', '-_,');
    }

    static private function base64_url_decode($input) {
        return base64_decode(strtr($input, '-_,', '+/='));
    }

    static function encrypt_to_url_param($message) {
        $encrypted = openssl_encrypt($message, self::OPEN_SSL_METHOD, base64_decode(self::BASE64_ENCRYPTION_KEY), 0, base64_decode(self::BASE64_IV));
        $base64_encrypted = self::base64_url_encode($encrypted);
        return $base64_encrypted;
    }

    static function decrypt_from_url_param($base64_encrypted) {
        $encrypted = self::base64_url_decode($base64_encrypted);
        $decrypted = openssl_decrypt($encrypted, self::OPEN_SSL_METHOD, base64_decode(self::BASE64_ENCRYPTION_KEY), 0, base64_decode(self::BASE64_IV));
        return $decrypted;
    }

}
echo '<h3>Url Decription</h3>';

echo 'To check url decryptioin copy the encrypted value and paste it in url with <b>&url=encrypted value</b><br />';

// Demo  pid-uid-yes
$string = '123-15-yes';
echo '<b>original Sting:</b>'.$string;

$encrypted_string = SA_Encryption::encrypt_to_url_param($string);

echo '<br /> <b>Encrypted String:</b> ' . $encrypted_string;

$decrypted_string = SA_Encryption::decrypt_from_url_param($encrypted_string);

echo '<br /> <b>Decrypted String:</b> ' . $decrypted_string;

if ($_GET['url']) {
    
    echo '<br /> <b>URL String:</b> ' . $_GET['url'];

    $url_decrypted_string = SA_Encryption::decrypt_from_url_param($_GET['url']);

    echo '<br /> <b>URL Decripted String:</b> ' . $url_decrypted_string;
}
?>