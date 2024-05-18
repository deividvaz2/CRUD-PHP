<?php
require '../connection.php';

// classe para desvincular a cor do usuario
class ColorBinding
{
    // propriedade da conexao
    private $connection;

    // aqui constroi a classe e inicia a conexao
    public function __construct($connection)
    {
        $this->connection = $connection->getConnection();
    }

    // aqui vai desvincular (deletar) o vinculo do usuario com a cor
    public function deleteColorBinding($userId, $colorId)
    {
        $query = "DELETE FROM user_colors WHERE user_id = :user_id AND color_id = :color_id";
        $statement = $this->connection->prepare($query);
        $statement->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $statement->bindParam(':color_id', $colorId, PDO::PARAM_INT);
        $statement->execute();
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['user_id'];
    $colorId = $_POST['color_id'];

    $colorBinding = new ColorBinding(new Connection());
    $colorBinding->deleteColorBinding($userId, $colorId);

    header("Location: ../components/form_color_user.php");
    exit();
} else {
    echo "Ocorreu um erro ao processar a requisição!";
}
