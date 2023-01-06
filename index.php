<?php
if ((isset($_POST['token'])) && (!empty($_POST['token']))) {
    header('Cache-Control: no-cache, must-revalidate');
    header('Pragma: no-cache');
    header("Content-Type: application/jason");
    header("Content-Disposition: attachment; filename=token.jason");
    $token = ['token' => $_POST['token']];
    echo json_encode($token);
} else {
    require 'jwt.php';
    $jwt = new jwt();
    $token = $jwt->create(['id' => rand(0, 99)]);
?>

    <!DOCTYPE html>
    <html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Json Web Token</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    </head>

    <body>

        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center pt-2">
                    <h1>Json Web Token</h1>
                    <hr>
                </div>

                <div class="col-lg-12">
                    <div class="col-lg-12 text-center pt-1 pb-1" style="overflow-x: scroll; white-space: nowrap; font-size: 12px;">
                        <?php echo $token; ?><br><br>
                    </div>
                </div>
                <div class="col-lg-12">
                    <hr>
                </div>
                <div class="col-lg-12 pb-2">
                    <?php
                    if ($jwt->validate($token)) {
                        echo "Token Válido!<br><br>";
                        foreach ($jwt->validate($token) as $key => $value) {
                            echo "<b>" . $key . "</b>: " . $value . "<br>";
                        }
                        echo "<br>";
                    ?>
                    <?php } else {
                        echo "Token Inválido!<br><br>";
                    } ?>
                </div>
                <div class="col-lg-2 pb-3">
                    <a class="btn btn-outline-secondary btn-sm btn-block" href="http://localhost/json-web-token/" role="button">&#8635; Atualizar</a>
                </div>
                <div class="col-lg-10"></div>
                <div class="col-lg-2">
                    <form method="POST">
                        <input type="hidden" name="token" value="<?php echo $token; ?>">
                        <button type="submit" class="btn btn-outline-secondary btn-sm btn-block">&#8628; Baixar</button>
                    </form>
                </div>
                <div class="col-lg-10"></div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    </body>

    </html>
<?php } ?>