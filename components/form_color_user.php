<?php
require '../connection.php';

$connection = new Connection();
$users = $connection->query("SELECT users.id, users.name, user_colors.color_id, colors.name as color 
                             FROM users 
                             INNER JOIN user_colors ON users.id = user_colors.user_id 
                             INNER JOIN colors ON user_colors.color_id = colors.id")
    ->fetchAll(PDO::FETCH_ASSOC);

// pega as cores existente no banco
$colors = $connection->query("SELECT id, name FROM colors")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['user_id'];
    $colorId = $_POST['color_id'];

    // caso o usuario já tenha a cor designada
    $stmtCheck = $connection->getConnection()->prepare("SELECT COUNT(*) AS count FROM user_colors WHERE user_id = :user_id AND color_id = :color_id");
    $stmtCheck->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmtCheck->bindParam(':color_id', $colorId, PDO::PARAM_INT);
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->fetch(PDO::FETCH_ASSOC);

    if ($resultCheck['count'] > 0) {
        echo "Erro: Esta cor já foi atribuída ou este usuário não existe.";
    } else {
        // atribuir a cor ao usuário
        $stmt = $connection->getConnection()->prepare("INSERT INTO user_colors (user_id, color_id) VALUES (:user_id, :color_id)");
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':color_id', $colorId, PDO::PARAM_INT);
        $stmt->execute();

        echo "Cor atribuída com sucesso!";
        header("Location: ../components/form_color_user.php");
    }
}
?>

<link rel="stylesheet" href="/css/style-color-user.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">


<body style="background-color: #8d8d8d; color:#fff">
    <div class="container" style="margin-top:-25px;">
        <form method="post" action="" class="mt-4">
            <div class="form-group">
                <label for="user_id">ID do Usuário:</label>
                <input type="text" id="user_id" name="user_id" class="form-control" required placeholder="Insira a ID do usuário">
            </div>

            <div class="form-group">
                <label for="color_id">Cor:</label>
                <select name="color_id" id="color_id" class="form-control" required>
                    <?php foreach ($colors as $color) : ?>
                        <option value="<?= htmlspecialchars($color['id']) ?>">
                            <?= htmlspecialchars($color['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Atribuir Cor</button>
        </form>

        <!-- Tabela de registros de usuários com cores atribuídas -->
        <h2 style="margin-top:-5px;">Usuários com cores</h2>
        <div class="table-responsive mt-4">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Cor</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user) :
                        $color = $user['color'] ?? 'Nenhuma';
                        $backgroundColor = ($color === 'Usuário sem cor' || $color === 'Nenhuma') ? '' : strtolower($color);
                    ?>
                        <tr>
                            <td><?= htmlspecialchars($user['id']) ?></td>
                            <td><?= htmlspecialchars($user['name']) ?></td>
                            <td class="color-cell" style="background-color: <?= htmlspecialchars($backgroundColor) ?>;">
                            </td>
                            <td>
                                <form method="post" action="/classes/desvincular_color_user.php">
                                    <input type="hidden" name="user_id" value="<?= htmlspecialchars($user['id']) ?>">
                                    <input type="hidden" name="color_id" value="<?= htmlspecialchars($user['color_id']) ?>">
                                    <button type="submit" class="btn btn-danger">Desvincular</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>