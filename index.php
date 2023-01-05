<div style="font-size: 10px;"></div>
<?php

require 'jwt.php';

$jwt = new jwt();

$token = $jwt->create(['id_user' => rand(0, 99)]);

echo '<div style="font-size: 12px;">' . $token . '</div>';

echo "<hr>";

if ($jwt->validate($token)) {

    echo "Token Válido!<br><br>";
    var_dump($jwt->validate($token));
} else {

    echo "Token Inválido!";
}

echo "<hr>";
