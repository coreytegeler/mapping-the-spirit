<!DOCTYPE html>
<?php
echo '<html lang="en">';
echo '<head>';

  echo '<meta charset="utf-8" />';
  echo '<meta name="viewport" content="width=device-width,initial-scale=1.0">';
  $siteTitle = $site->title()->html();
  $pageTitle = $page->title()->html();
  if($pageTitle && $pageTitle != 'Home') {
    $siteTitle .= '&mdash;' . $page->title()->html();
  }
  echo '<title>' . $siteTitle . '</title>';
  echo '<meta name="description" content="' . $site->description()->html() . '"/>';
  echo '<meta name="keywords" content="' . $site->keywords()->html() . '"/>';
  echo '<meta name="viewport" content="width=device-width, height=device-height"/>';
  echo '<meta property="og:url" content="' . $page->url() . '"/>';
  echo '<meta property="og:title" content="' . $siteTitle . '"/>';
  echo '<meta property="og:description" content="' . $site->description() . '" />';
  if( $thumb = $page->getThumb( 'large' ) ) {
    echo '<meta property="og:image" content="' . $thumb->url() . '" />';
  }

$assets = $kirby->urls()->assets();
echo '<link rel="apple-touch-icon" sizes="180x180" href="' . $assets . '/images/icon/apple-touch-icon.png">';
echo '<link rel="icon" type="image/png" sizes="32x32" href="' . $assets . '/images/icon/favicon-32x32.png">';
echo '<link rel="icon" type="image/png" sizes="16x16" href="' . $assets . '/images/icon/favicon-16x16.png">';
echo '<link rel="manifest" href="' . $assets . '/images/icon/manifest.json">';
echo '<link rel="mask-icon" href="' . $assets . '/images/icon/safari-pinned-tab.svg" color="#000000">';
echo '<link rel="shortcut icon" href="' . $assets . '/images/icon/favicon.ico">';
echo '<meta name="msapplication-config" content="' . $assets . '/images/icon/browserconfig.xml">';
echo '<meta name="theme-color" content="#ffffff">';
  
  echo '<script>(function(i,s,o,g,r,a,m){i["GoogleAnalyticsObject"]=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,"script","https://www.google-analytics.com/analytics.js","ga");
    ga("create", "UA-55531055-3", "auto");
    ga("send", "pageview")</script>';

  $version = 2.5;
  echo js(array(
    'assets/js/jquery.js',
    'assets/js/jquery-ui.js',
    'https://npmcdn.com/imagesloaded@4.1/imagesloaded.pkgd.min.js',
    'assets/js/isotope.js',
    'assets/js/masonry-horizontal.js',
    'assets/js/mousewheel.js',
    'assets/js/transit.js',
    'assets/js/leaflet.js',
    'assets/js/clipboard.min.js',
    'assets/js/script.js?version=' . $version
  ));

  echo css( '/assets/css/leaflet.css' );
  echo css( '/assets/css/style.css?version=' . $version );

  if( !isset( $bodyClass ) ) {
    $bodyClass = [];
  }

  $template = $page->intendedTemplate();
  $bodyClass[] = $template;


echo '</head>';
echo '<body class="' . implode( ' ', $bodyClass ) . '">';
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