<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0">

  <title><?php echo $site->title()->html() ?> | <?php echo $page->title()->html() ?></title>
  <meta name="description" content="<?php echo $site->description()->html() ?>">
  <meta name="keywords" content="<?php echo $site->keywords()->html() ?>">

  <?php
  echo js(array(
    'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js',
    'https://npmcdn.com/imagesloaded@4.1/imagesloaded.pkgd.min.js',
    'https://cdnjs.cloudflare.com/ajax/libs/masonry/4.1.1/masonry.pkgd.min.js',
    'assets/js/script.js',
  ));
  echo css( '/assets/css/styles.css' );
  ?>

</head>
<body class="<?php echo $page->intendedTemplate() ?>">

  <header role="header">
    <?php snippet('menu') ?>
  </header>