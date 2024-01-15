<?php $id = str_replace(' ', '_', strtolower($name)); ?>
<label for="<?= $id ?>"><?= $name ?></label>
<textarea name="<?= $id ?>" id="<?= $id ?>"><?= $value ?></textarea>
