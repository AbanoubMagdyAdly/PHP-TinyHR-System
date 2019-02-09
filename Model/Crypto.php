<?php 
class Crypto{
    public static function encrypt($plaintext, $salt)
    {
        $td = mcrypt_module_open('cast-256', '', 'ecb', '');
        $iv = mcrypt_create_iv (mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        mcrypt_generic_init($td, $salt, $iv);
        $encrypted_data = mcrypt_generic($td, $plaintext);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        $encoded_64 = base64_encode($encrypted_data);
        return trim($encoded_64);
    }

    public static function decrypt($crypttext, $salt)
    {
        $decoded_64=base64_decode($crypttext);
        $td = mcrypt_module_open('cast-256', '', 'ecb', '');
        $iv = mcrypt_create_iv (mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        mcrypt_generic_init($td, $salt, $iv);
        $decrypted_data = mdecrypt_generic($td, $decoded_64);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        return trim($decrypted_data);
    }
}
?>