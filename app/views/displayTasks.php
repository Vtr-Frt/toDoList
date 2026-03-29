<h2>Taches disponibles : </h2>
<div class="grid">
<?php foreach ($tasks as $t): ?>
  <div class="card">
    <h3><?= htmlspecialchars($t->getTitle()) ?></h3>
    <p><strong><?= htmlspecialchars($t->getDateLimite()) ?></strong></p>
    <sub><?= htmlspecialchars($t->getDescription()) ?></sub>
    <a class="btn" href="index.php?action=taskDone&id=<?= (int)$t->getId() ?>">Fait</a>
    <?php if($t->getIdProprio() == $_SESSION['userId']): ?>
      <a class="btn" href="index.php?action=taskCancel&id=<?= (int)$t->getId() ?>">Annuler</a>
    <?php endif; ?>
  </div>
<?php endforeach; ?>
</div>
<?php if($groupTask !== null): ?>
  <h2>Taches du groupe : </h2>
  <div class="grid">
    <?php foreach ($groupTask as $t): ?>
      <div class="card">
        <h3><?= htmlspecialchars($t->getTitle()) ?></h3>
        <p><strong><?= htmlspecialchars($t->getDateLimite()) ?></strong></p>
        <sub><?= htmlspecialchars($t->getDescription()) ?></sub>
        <a class="btn" href="index.php?action=taskDone&id=<?= (int)$t->getId() ?>">Fait</a>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>
