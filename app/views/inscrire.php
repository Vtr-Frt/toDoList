<h2>Inscription</h2>


<form action="index.php?action=register" method="POST">
    <div class="form-group">
        <label for="email">E-mail :</label>
        <input type="email" id="email" name="email">
    </div>
    <div class="form-group">
        <label for="username">Pseudo :</label>
        <input type="text" id="username" name="username" minlength="2">
    </div>
    <div class="form-group">
        <label for="password">Mot de Passe :</label>
        <input type="password" id="password" name="password" minlength="4">
    </div>
    <button type="submit" class="btn">Inscrire</button>
</form>
