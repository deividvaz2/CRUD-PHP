<?php

require '../connection.php';

class User
{
    // propriedades com base na tabela
    private $name;
    private $email;
    private $connection;


    public function __construct($name, $email, $connection)
    {
        // implementando os valores
        $this->name = $name;
        $this->email = $email;
        $this->connection = $connection->getConnection();
    }

    public function createUser()
    {
        // consulta para criar um novo usuario
        $stmt = $this->connection->prepare("INSERT INTO users (name, email) VALUES (:name, :email)");
        $stmt->execute([':name' => $this->name, ':email' => $this->email]);

        echo "Usuário criado com sucesso!";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['name']) && !empty($_POST['email'])) {
        $connection = new Connection();
        $user = new User($_POST['name'], $_POST['email'], $connection);
        $user->createUser();
    } else {
        echo "Todos os campos são obrigatórios!";
    }
} else {
    echo "Ocorreu um erro ao processar o formulário!";
}
