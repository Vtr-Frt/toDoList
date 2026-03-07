<h2>Ajout de tâches</h2>

<form action="index.php?action=addTask" method="POST">
    <div class="form-group">
        <label for="title">Titre :</label>
        <input id="title" name="title">
    </div>
    <div class="form-group">
        <label for="description">Description :</label>
        <input type="text" id="description" name="description">
    </div>
    <div class="form-group">
        <label for="dateLimite">Date Limite :</label>
        <input type="date" id="dateLimite" name="dateLimite" min="<?= date('Y-m-d') ?>">
    </div>
    <button type="submit" class="btn">Ajouter</button>
</form>