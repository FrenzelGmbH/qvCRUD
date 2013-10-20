<?php

use yii\helpers\Html;

?>

<?php foreach($menuItems AS $menuEntry): ?>

<p>
  <a href="<?= $menuEntry['link']; ?>" class="btn btn-primary btn-lg full-width"><i class="<?= $menuEntry['icon']; ?>"></i> <?= $menuEntry['label']; ?></a>
</p>

<?php endforeach; ?>
