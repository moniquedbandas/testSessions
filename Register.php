<?php
session_start();
include_once 'Conexao.php';

$conex = new Conexao();
$conex->fazConexao();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    if ($password !== $password_confirm) {
        //se as senhas nao forem iguais, mostra uma mensagenzinha de erro
        $error = 'As senhas não coincidem.';
    } else {
        $stmt = $conex->conn->prepare("SELECT * FROM users WHERE username = ?");
        //executa a query com o usuario fornecido.
        $stmt->execute(['$username']);
        if ($stmt->fetch()) {
            $error = 'Usuário existente.';
        } else {
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $conex->conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            if ($stmt->execute([$username, $hashed_password])) {
                $sucess = 'Usuário cadastrado com sucesso. Faça login agora.';
            } else {
                $error = 'Erro ao registrar usuário. Tente novamente.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de usuário</title>
</head>

<body>
    <h2>Registro de novo Usuário</h2>
    <?php
    if (isset($error)) : ?>
        <p style="color:red;">
            <?php echo $error; ?>
        </p>
    <?php endif; ?>
    <?php if (isset($sucess)) : ?>
        <p style="color:green;">
            <?php echo $sucess; ?>
        </p>
    <?php endif; ?>
    <form method="post">
        <label for="username">Nome de usuário:</label>
        <input type="text" name="username" required><br>
        <label for="password">Senha:</label>
        <input type="password" name="password" required><br>
        <label for="confirm_password">Confirme a senha:</label>
        <input type="password" name="password_confirm" required><br>
        <button type="submit">Registrar</button>
    </form>
    <br>
    <a href="login.php">Já possui uma conta? Faça login</a>
</body>

</html>