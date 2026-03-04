<html lang="fr">
    <head>
        <link href="assets/style.css" rel="stylesheet">
        <title>ToDoList</title>
        <meta charset="UTF-8">
    </head>
    <body>
    <div class="app-layout">
        <aside class="sidebar">
            <h1>To Do List</h1>
            <nav class="sidebar-nav">
                <a href="index.php" class="nav-link">Home</a>
                <a href="index.php?action=connexion" class="nav-link">Connexion</a>
                <a href="index.php?action=register" class="nav-link">Inscrire</a>
            </nav>  
            <div class="sidebar-footer">
                <p>&copy; <?= date('Y') ?> <?= htmlspecialchars(APP_NAME) ?></p>
            </div>
        </aside>
        <main class="main-content">