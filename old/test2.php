<?php
function mod_exp($base, $exp, $mod)
{
    $result = 1;
    while ($exp > 0) {
        if ($exp % 2 == 1) {
            $result = ($result * $base) % $mod;
        }
        $exp = $exp >> 1;
        $base = ($base * $base) % $mod;
    }
    return $result;
}

function rsa_encrypt($message, $public_key, $modulus)
{
    $message_int = bigint_str2int($message);
    return mod_exp($message_int, $public_key, $modulus);
}

function rsa_decrypt($ciphertext, $private_key, $modulus)
{
    return mod_exp($ciphertext, $private_key, $modulus);
}

function bigint_str2int($str)
{
    $result = 0;
    for ($i = 0; $i < strlen($str); $i++) {
        $result = ($result << 8) + ord($str[$i]);
    }
    return $result;
}

function bigint_int2str($int)
{
    $result = '';
    while ($int > 0) {
        $result = chr($int & 0xFF) . $result;
        $int = $int >> 8;
    }
    return $result;
}

$public_key = 65537;
$private_key = 123456789;
$modulus = 987654321;

$message = "Hello RSA!";

$ciphertext = rsa_encrypt($message, $public_key, $modulus);
echo "Encrypted: " . $ciphertext . "\n";

$decrypted = rsa_decrypt($ciphertext, $private_key, $modulus);
echo "Decrypted: " . bigint_int2str($decrypted) . "\n";
?>
