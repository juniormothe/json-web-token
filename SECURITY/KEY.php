<?php

/**
 * Classe responsável por gerar a chave de autenticação, chave atualiza mensalmente
 */

class key
{
    /**
     * Parâmetro com caminho do arquivo json com as chaves de autenticação
     */
    public static $securitykey = 'securitykey.json';

    /**
     * Método para retornar a ultima chave ou um array com todas as chaves
     * Parâmetro type obrigatório (1 retorna a ultima chave, diferente de 1 retorna um array com todas as chaves)
     */
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

    /**
     * Método para converter json em array
     */
    private function jsonToArray()
    {
        return json_decode(file_get_contents(self::$securitykey), true);
    }

    /**
     * Método para atualizar a chave mensalmente
     */
    private function checkDateJson()
    {
        $arrayJson = $this->jsonToArray();
        if ($arrayJson[count($arrayJson)]['date'] < date('Ym')) {
            $arrayJson[(count($arrayJson) + 1)] = ['date' => date('Ym'), 'key' => $this->createKey()];
            file_put_contents(self::$securitykey, json_encode($arrayJson));
        }
    }

    /**
     * Método para criar arquivo jason com a primeira chave
     */
    private function createJson()
    {
        if (!file_exists(self::$securitykey)) {
            $data = ['1' => ['date' => date('Ym'), 'key' => $this->createKey()]];
            file_put_contents(self::$securitykey, json_encode($data));
        }
    }

    /**
     * Método para gera a chave em 256-bit
     */
    private function createKey()
    {
        $key = openssl_random_pseudo_bytes(rand(0, 99));
        $iv = openssl_random_pseudo_bytes(
            openssl_cipher_iv_length('aes-256-ctr')
        );
        $data = $_SERVER['HTTP_HOST'] . time() . rand(0, 99);
        return str_replace([",", "\\", "/", "}", "{"], ["", "", "", "", ""], openssl_encrypt($data, 'aes-256-ctr', $key, 0, $iv));
    }
}
