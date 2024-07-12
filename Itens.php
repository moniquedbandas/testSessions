<?php
session_start();
include_once 'Conexao.php';

$conex = new Conexao();
$conex->fazConexao();
//verifica se o user esta logado 
if (!isset($_SESSION['user_id'])) {
    //se nao estiver, redireciona para o login
    header('Location: Login.php');
    //encerra o script para redirecionar logo para o login
    exit();
}

$stmt = $conex->conn->query("SELECT * FROM items");
$items = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listagem de itens</title>
</head>

<body>
    <h2>Bem vindo, <?php echo htmlspecialchars($_SESSION['username']); ?>!
    </h2>
    <a href="Logout.php">Sair</a>

    <h2>Itens</h2>
    <ul>
        <?php foreach ($items as $item) : ?>
            <li style="list-style-type: none;">
                <?php
                echo htmlspecialchars($item['name']);
                ": "
                    . htmlspecialchars($item['description']); ?>
            </li>
        <?php endforeach; ?>
    </ul>
</body>

</html>