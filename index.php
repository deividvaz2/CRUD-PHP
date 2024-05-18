<?php
require 'connection.php';

$connection = new Connection();

$users = $connection->query("SELECT * FROM users");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style-global.css">
    <link rel="stylesheet" href="/css/style-box-form.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <title>VersoTech</title>
</head>

<body>
    <div class="flex-container">


        <div class="container">
            <h1>Teste de conhecimentos PHP + Banco de dados</h1>

            <!--Modal criar usuarios -->
            <a href="#" id="openModal" class="add-user" alt="Adicionar Usuários">
                <span class="tooltip">Adicionar Usuário</span>
                <img src="/icons/add-button.png" alt="Botão para criar usuários" />
            </a>

            <div id="myModal" class="modal">
                <div class="modal-content">
                    <span class="close">Fechar</span>
                    <iframe src="/components/form_create_user.php"></iframe>
                </div>
            </div>

            <!--tabela para mostrar usuarios -->
            <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                <table>
                    <a style="font-size: 13px; float: right; color:#fff;">Tabela usuários</a>

                    <thead>
                        <tr style="font-size: 16px;">
                            <th scope="row" style="color: #fff;">Id</th>
                            <th scope="row" style="color: #fff;">Nome</th>
                            <th scope="row" style="color: #fff;">E-mail</th>
                            <th scope="row" style="color: #fff;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user) : ?>
                            <tr style="font-size: 13px;">
                                <td><?php echo $user->id; ?></td>
                                <td><?php echo $user->name; ?></td>
                                <td><?php echo $user->email; ?></td>
                                <td>
                                    <a href="/components/form_edit_user.php?id=<?= $user->id; ?>" class="btn btn-success edit-user">Editar</a>
                                    <a href="/classes/delete_user.php?id=<?= $user->id; ?>" class="btn btn-danger">Deletar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Box dos usuarios com cor -->
        <div class="container-form">
            <iframe src="/components/form_color_user.php"></iframe>
        </div>
    </div>

</body>

<script src="/js/modal.js"></script>

</html>