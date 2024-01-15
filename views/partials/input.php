<?php $id = str_replace(' ', '_', strtolower($name)); ?>
<?php if ($type !== 'hidden') : ?>
<label for="<?= $id ?>"><?= $name ?></label>
<?php endif ?>
<input type="<?= $type ?>" value="<?= $value ?>" name="<?= $id ?>" id="<?= $id ?>">