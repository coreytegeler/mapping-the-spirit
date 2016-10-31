<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0">

  <title><?php echo $site->title()->html() ?> &mdash; <?php echo $page->title()->html() ?></title>
  <meta name="description" content="<?php echo $site->description()->html() ?>">
  <meta name="keywords" content="<?php echo $site->keywords()->html() ?>">

  <?php
  echo js(array(
    'assets/js/jquery.js',
    'assets/js/jquery-ui.js',
    'https://npmcdn.com/imagesloaded@4.1/imagesloaded.pkgd.min.js',
    'assets/js/isotope.js',
    'assets/js/masonry-horizontal.js',
    'assets/js/mousewheel.js',
    'assets/js/transit.js',
    'assets/js/script.js',
  ));
  echo css( '/assets/css/style.css' );

  if( !isset( $bodyClass ) ) {
    $bodyClass = [];
  }

  $template = $page->intendedTemplate();
  $bodyClass[] = $template;
  ?>

</head>
<body class="<?php echo implode( ' ', $bodyClass ) ?>">
  <header>
    <div class="inner">
      <div class="title">
        <span>
          Mapping The Spirit
        </span>
      </div>
      <div class="tools">
        <div class="tool close">×</div>
      </div>
      <div class="subtitle">
        <span>
          <?php
          if( isset( $story ) ) {
            echo $story->title();
          } else {
            echo $page->title();
          }
          ?>
        </span>
      </div>
    </div>
  </header>