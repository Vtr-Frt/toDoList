<div class="grid">
<?php foreach ($tasks as $t): ?>
  <div class="card">
    <h3><?= htmlspecialchars($t->getTitle()) ?></h3>
    <p><strong><?= htmlspecialchars($t->getDateLimite()) ?></strong></p>
    <sub><?= htmlspecialchars($t->getDescription()) ?></sub>
  </div>
<?php endforeach; ?>
</div>