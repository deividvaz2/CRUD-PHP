<?php
require '../connection.php';

// abre a conexão
$connection = new Connection();
$pdo = $connection->getConnection();

$usuario = [];
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($id) {
    $sql = $pdo->prepare("SELECT id, name, email FROM users WHERE id = :id");
    $sql->bindValue(':id', $id, PDO::PARAM_INT);
    $sql->execute();

    if ($sql->rowCount() > 0) {
        header("Location: ../index.php");
        exit;
    } else {
        $usuario = $sql->fetch(PDO::FETCH_ASSOC);
    }
} else {
    header("Location: ../index.php");
    exit;
}
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="text-center">Editar</h1>
            <form action="/classes/edit_user.php" method="POST">
                <input type="hidden" name="id" value="<?= $usuario['id']; ?>" />
                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" class="form-control" id="nome" name="nome" value="<?= $usuario['name']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= $usuario['email']; ?>" required>
                </div>

                <button type="submit" class="btn btn-primary">Enviar</button>
            </form>
        </div>
    </div>
</div>