<?php

require '../connection.php';

class User
{
    private $id;
    private $name;
    private $email;
    private $connection;

    // construindo a classe
    public function __construct($id, $name, $email, $connection)
    {
        // colocando seus valores
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->connection = $connection->getConnection();
    }

    // classe no qual vai editar um usuário
    public function editUser()
    {
        try {
            $this->connection->beginTransaction();

            // consulta em sql que vai atualizar o nome e o email do usuário na tabela users
            $stmt = $this->connection->prepare("UPDATE users SET name = :name, email = :email WHERE id = :id");
            $stmt->execute([':name' => $this->name, ':email' => $this->email, ':id' => $this->id]);

            $this->connection->commit();

            // deu certo!
            header('Location: ../index.php');
            exit;
        } catch (Exception $e) {
            $this->connection->rollBack();
            echo "Erro ao atualizar o usuário: " . $e->getMessage();
        }
    }
}

// requisição do método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['id']) && !empty($_POST['nome']) && !empty($_POST['email'])) {
        $connection = new Connection();
        $user = new User($_POST['id'], $_POST['nome'], $_POST['email'], $connection);
        $user->editUser();
    } else {
        echo "Todos os campos são obrigatórios!";
    }
} else {
    echo "Ocorreu um erro ao processar o formulário!";
}
