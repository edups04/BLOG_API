<?php

class Crypt{

    private $iv; //initialization vector
    private $cipher; //cipher algorithm

    public function __construct()
    {
        $this->iv = random_bytes(16); //initiaLize initialization vector
        $this->cipher = "AES-128-CBC"; //algorithm use to encrypt and decrypt data
    }

    public function encryptData($data){
        
        $encryptedString = openssl_encrypt($data, $this->cipher, SECRET_KEY, OPENSSL_RAW_DATA, $this->iv);
        $encryptedBase64 = base64_encode($this->iv . $encryptedString);
        return json_encode(array("data" => $encryptedBase64));
    }

    public function decryptData($encryptedString){

        //$data = $encryptedString['data'];
        $data = $encryptedString->data;
        $decoded = base64_decode($data);
        $iv_decoded = substr($decoded, 0, 16); //extract IV
        $encrypted_data = substr($decoded, 16);
        $decrypted = openssl_decrypt($encrypted_data, $this->cipher, SECRET_KEY, OPENSSL_RAW_DATA, $iv_decoded);
        return $decrypted;

    }
}
?>