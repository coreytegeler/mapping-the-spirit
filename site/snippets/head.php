<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0">

  <title><?php echo $site->title()->html() ?> &mdash; <?php echo $page->title()->html() ?></title>
  <meta name="description" content="<?php echo $site->description()->html() ?>">
  <meta name="keywords" content="<?php echo $site->keywords()->html() ?>">
  <meta name="viewport" content="width=device-width, height=device-height">
  <?php
  echo js(array(
    'assets/js/jquery.js',
    'assets/js/jquery-ui.js',
    // 'assets/js/touch-punch.js',
    'https://npmcdn.com/imagesloaded@4.1/imagesloaded.pkgd.min.js',
    'assets/js/isotope.js',
    'assets/js/masonry-horizontal.js',
    'assets/js/mousewheel.js',
    'assets/js/transit.js',
    'assets/js/leaflet.js',
    'assets/js/script.js?version=2.2'
  ));
  echo css( '/assets/css/leaflet.css' );
  echo css( '/assets/css/style.css?version=2.2' );

  if( !isset( $bodyClass ) ) {
    $bodyClass = [];
  }

  $template = $page->intendedTemplate();
  $bodyClass[] = $template;
  ?>

</head>
<body class="<?php echo implode( ' ', $bodyClass ) ?>">
<?php
if($page->slug() != 'home') {
  if( $page->intendedTemplate() == 'story' ) {
    $story = $page;
  }
  $headerArray = array();
  if( isset( $story ) ) {
    $headerArray['story'] = $story;
  }
  if( isset( $item ) ) {
    $headerArray['item'] = $item;
  }
  snippet( 'header', $headerArray );
}
?>