<?php
require '../connection.php';

// classe para deletar um usuario
class UserDeletion
{
    private $connection;

    public function __construct()
    {
        $this->connection = new Connection();
    }

    public function deleteUser($userId)
    {
        try {
            $conn = $this->connection->getConnection();
            $conn->beginTransaction();

            // exclui o usuário pela id
            $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
            $stmt->execute([$userId]);

            $conn->commit();

            header('Location: /index.php');
            exit();
        } catch (PDOException $e) {
            echo "Erro ao excluir usuário: " . $e->getMessage();
        }
    }
}

// Verifica se o ID do usuário foi passado via GET
if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    $userDeletion = new UserDeletion();
    $userDeletion->deleteUser($userId);
} else {
    echo "ID do usuário não fornecido!";
}
