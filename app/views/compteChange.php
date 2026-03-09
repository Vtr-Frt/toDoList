<form action="" method="POST">
    <div class="form-group">
        <label for="newName">Changer pseudo :</label>
        <input type="text" id="newName" name="newName">
    </div>
    <div class="form-group">
        <label for="newPassword">Changer mot de passe :</label>
        <input type="password" id="newPassword" name="newPassword">
    </div>
    <div class="form-group">
        <label for="newPP">Changer photo de profile :</label>
        <input type="file" id="newPP" name="newPP">
    </div>
    <?php if(isset($_SESSION['groupId'])): ?>
    <div class="form-group">
        <label for="joinGroup">Rejoindre groupe :</label>
        <input type="text" id="joinGroup" name="joinGroup">
    </div>
    <?php else: ?>
    <div class="form-group">
        <a class="btn">Quitter Groupe</a>
    </div>
    <div class="form-group">
        <label for="changeGroup">Changer groupe :</label>
        <input type="text" id="changeGroup" name="changeGroup">
    </div>
    <?php endif; ?>
</form>