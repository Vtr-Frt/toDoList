<h1>Compte</h1>

<img class="icon" src="<?= htmlspecialchars($_SESSION['profilPicture'])?>" alt="Image de profil">

<h2><?= htmlspecialchars($_SESSION['username']) ?></h2>
<?php if(isset($_SESSION['groupId'])): ?>
<p>Id groupe : <?= $_SESSION['groupId']; ?></p>
<?php endif; ?>
<a class="btn" href="index.php?action=updateProfil">Modifier profil</a>