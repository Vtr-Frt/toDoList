<!DOCTYPE html>
<html lang="fr">
    <head>
        <link href="assets/style.css" rel="stylesheet">
        <title>ToDoList</title>
        <meta charset="UTF-8">
    </head>
    <body>
    <div class="app-layout">
        <aside class="sidebar">
            <h1><?= htmlspecialchars(APP_NAME) ?></h1>
            <nav class="sidebar-nav">
                <?php if(isset($_SESSION['email'])): ?>
                    <p>Bienvenue <?= htmlspecialchars($_SESSION['username']) ?></p>
                    <a href="index.php?action=showProfil" class="nav-link">Profile</a>
                    <a href="index.php" class="nav-link">Home</a>
                    <a href="index.php?action=displayTask" class="nav-link">Taches Disponibles</a>
                    <a href="index.php?action=addTask" class="nav-link">Ajout tache</a>
                    <a href="index.php?action=showHistorique" class="nav-link">Historique</a>
                    <a href="index.php?action=disconnect" class="nav-link">Déconnexion</a>
                <?php else: ?>
                    <a href="index.php" class="nav-link">Home</a>
                    <a href="index.php?action=connexion" class="nav-link">Connexion</a>
                    <a href="index.php?action=register" class="nav-link">Inscrire</a>
                <?php endif ?>
                
            </nav>
            <div class="sidebar-footer">
                <p>&copy; <?= date('Y') ?> <?= htmlspecialchars(APP_NAME) ?></p>
            </div>
        </aside>
        <main class="main-content">
            <?php $flash = get_flash(); ?>
            <?php if ($flash): ?>
                <div class="alert <?= htmlspecialchars($flash['type']) ?>">
                    <?= htmlspecialchars($flash['message']) ?>
                </div>
            <?php endif; ?>
