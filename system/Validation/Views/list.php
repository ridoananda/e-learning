<?php if (!empty($errors)) : ?>
	<?php foreach ($errors as $error) : ?>
		<p class="m-0"><?= esc($error) ?></p>
	<?php endforeach ?>
<?php endif ?>