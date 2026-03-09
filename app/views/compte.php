<h1>Compte</h1>

<img src="" alt="Image de profil">

<h2><?=  $_SESSION['username'] ?></h2>
<p>Id groupe : <?= htmlspecialchars() ?> </p>
<a class="btn" href="index.php?action=updateProfil">Modifier profil</a>