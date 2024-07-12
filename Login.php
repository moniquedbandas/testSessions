<?php
session_start();
include_once 'Conexao.php';

$conex = new Conexao();
$conex->fazConexao();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conex->conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header('Location: Itens.php');
        exit();
    } else {
        $error = 'Nome de usuário ou senha inválidos.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <h2>Login</h2>
    <?php
    if (isset($error)) : ?>
        <p style="color:red;">
            <?php echo $error; ?>
        </p>
    <?php endif; ?>
    <form method="post">
        <label for="username">Nome de usuário:</label>
        <input type="text" name="username" required><br>
        <label for="password">Senha:</label>
        <input type="password" name="password" required><br>
        <button type="submit">Entrar</button>
    </form>
</body>

</html>