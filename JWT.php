<?php

require 'SECURITY/KEY.php';

class JWT extends KEY
{
    private $key;
    private $arrayKey;

    public function __construct()
    {
        $this->key = $this->securitykey(1);
        $this->arrayKey = $this->securitykey(2);

        echo "KEY: " . $this->key;
        echo "<hr><pre>";
        var_dump($this->arrayKey);
        echo "</pre>";
    }
}


$JWT = new JWT();
