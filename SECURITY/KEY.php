<?php

class KEY
{

    public function securitykey(int $type)
    {
        $this->createJson();
        $this->checkDateJson();
        $securitykey = $this->jsonToArray();
        if ($type == 1) {
            return $securitykey[count($securitykey)]['key'];
        } else {
            return $securitykey;
        }
    }

    private function jsonToArray()
    {
        return json_decode(file_get_contents('securitykey.json'), true);
    }

    private function checkDateJson()
    {
        $arrayJson = $this->jsonToArray();
        if ($arrayJson[count($arrayJson)]['date'] < date('Ym')) {
            $arrayJson[(count($arrayJson) + 1)] = ['date' => date('Ym'), 'key' => $this->createKey()];
            file_put_contents('securitykey.json', json_encode($arrayJson));
        }
    }

    private function createJson()
    {
        if (!file_exists('securitykey.json')) {
            $data = ['1' => ['date' => date('Ym'), 'key' => $this->createKey()]];
            file_put_contents('securitykey.json', json_encode($data));
        }
    }

    private function createKey()
    {
        $key = openssl_random_pseudo_bytes(rand(0, 99));
        $iv = openssl_random_pseudo_bytes(
            openssl_cipher_iv_length('aes-256-ctr')
        );
        $data = $_SERVER['HTTP_HOST'] . time() . rand(0, 99);
        return str_replace(
            ",",
            "",
            str_replace(
                "\\",
                "",
                str_replace(
                    "/",
                    "",
                    str_replace(
                        "}",
                        "",
                        str_replace("{", "", openssl_encrypt($data, 'aes-256-ctr', $key, 0, $iv))
                    )
                )
            )
        );
    }
}
