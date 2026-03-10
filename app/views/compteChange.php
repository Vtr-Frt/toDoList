<form action="index.php?action=updatePseudo" method="POST">
    <div class="form-group">
        <label for="newName">Changer pseudo :</label>
        <input type="text" id="newName" name="newName">
        <button class="btn" type="submit" >Modifier</button>
    </div>
</form>
<form action="index.php?action=updatePassword" method="POST">
    <div class="form-group">
        <label for="newPassword">Changer mot de passe :</label>
        <input type="password" id="newPassword" name="newPassword">
        <button class="btn" type="submit" >Modifier</button>
    </div>
</form>
<form action="index.php?action=updatePP" method="POST">
    <div class="form-group">
        <label for="newPP">Changer photo de profile (300x300) :</label>
        <input type="file" id="newPP" name="newPP">
        <button class="btn" type="submit" >Modifier</button>
    </div>
</form>
    <?php if(!isset($_SESSION['groupId'])): ?>
<form action="index.php?action=joinGroup" method="POST">
    <div class="form-group">
        <label for="joinGroup">Rejoindre groupe :</label>
        <input type="text" id="joinGroup" name="joinGroup">
        <button class="btn" type="submit">Rejoindre</button>
    </div>
</form>
    <?php else: ?>
<form action="index.php?action=quitGroup" method="POST">
    <div class="form-group">
        <a class="btn">Quitter Groupe</a>
    </div>
</form>
<form action="index.php?action=joinGroup" method="POST">
    <div class="form-group">
        <label for="changeGroup">Changer groupe :</label>
        <input type="text" id="changeGroup" name="changeGroup">
        <button class="btn" type="submit" >Changer</button>
    </div>
</form>
    <?php endif; ?>
