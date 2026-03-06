<h2>Historique des taches accomplient : </h2>
<div class="grid">
<?php foreach ($tasks as $t): ?>
  <div class="card">
    <h3><?= htmlspecialchars($t->getTitle()) ?></h3>
    <p><strong>Fait le <?= htmlspecialchars($t->getDateDone()) ?></strong></p>
    <sub><?= htmlspecialchars($t->getDescription()) ?></sub>
  </div>
<?php endforeach; ?>
</div>