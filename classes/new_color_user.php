<?php

require '../connection.php';

class UserColor
{
    // propriedade da classe
    private $userId;
    private $colorId;
    private $connection;

    public function __construct($userId, $colorId, $connection)
    {
        // implmentando os valores
        $this->userId = $userId;
        $this->colorId = $colorId;
        $this->connection = $connection->getConnection();
    }

    // funcao para atribuir a cor ao usuario
    public function assignColor()
    {
        // caso ele ja tenha a cor atribuida, criei um metodo para identificar a traves do id color_id
        $stmtCheck = $this->connection->prepare("SELECT COUNT(*) AS count FROM user_colors WHERE user_id = :user_id AND color_id = :color_id");
        $stmtCheck->bindParam(':user_id', $this->userId, PDO::PARAM_INT);
        $stmtCheck->bindParam(':color_id', $this->colorId, PDO::PARAM_INT);
        $stmtCheck->execute();
        $resultCheck = $stmtCheck->fetch(PDO::FETCH_ASSOC);

        if ($resultCheck['count'] > 0) {
            echo "Erro: Esta cor já foi atribuída a este usuário.";
        } else {
            // se tudo estiver de acordo, metodo para designar a cor ao usuario
            $stmt = $this->connection->prepare("INSERT INTO user_colors (user_id, color_id) VALUES (:user_id, :color_id)");
            $stmt->bindParam(':user_id', $this->userId, PDO::PARAM_INT);
            $stmt->bindParam(':color_id', $this->colorId, PDO::PARAM_INT);
            $stmt->execute();

            echo "Cor atribuída com sucesso!";
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!empty($_POST['user_id']) && !empty($_POST['color_id'])) {
        $connection = new Connection();
        $userColor = new UserColor($_POST['user_id'], $_POST['color_id'], $connection);
        $userColor->assignColor();
    } else {
        echo "Os campos 'user_id' e 'color_id' são obrigatórios!";
    }
} else {
    echo "Ocorreu um erro ao processar o formulário!";
}
