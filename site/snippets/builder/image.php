<section class="image" 
<?php if ($data->image()->isNotEmpty()): ?>
  style="background-image: url(<?= $page->image($data->image())->url() ?>)"
<?php endif ?>
>
  <h2 class="caption">
    <?= $data->caption() ?>
  </h2>
</section>