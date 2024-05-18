<!--como esse CSS é apenas para esse formulario em quest~ao, preferi por deixar nesse codigo -->
<link rel="stylesheet" href="/css/style-form-new-user.css">



<h3 style="text-align: center;">Novo usuário</h3>

<div>
    <form action="/classes/new_user.php" method="post">
        <label for="fname">Nome</label>
        <input type="text" id="fname" name="name" placeholder="nome.." required>

        <label for="lname">Email</label>
        <input type="text" id="lname" name="email" placeholder="email.." required>

        <input type="submit" value="Criar">
    </form>
</div>