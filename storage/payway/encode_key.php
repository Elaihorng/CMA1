<?php
$key = file_get_contents(__DIR__ . '/rsa_public.pem'); // Reads the public key in the same folder
echo base64_encode($key);
