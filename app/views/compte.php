<h1>Compte</h1>

<img src="uploads/avatars/<?= htmlspecialchars(User::getProfilPicture($db, $_SESSION['userId'])) ?>" alt="Image de profil">

<h2><?=  $_SESSION['username'] ?></h2>
<p>Id groupe : <?= $_SESSION['groupId'] ?></p>
<a class="btn" href="index.php?action=updateProfil">Modifier profil</a>