<?php
page::$methods['getSpan'] = function( $page ) {
	$items = $page->children()->visible();
	$years = array();
  foreach( $items as $item ) {
  	$year = $item->year();
    if( !$year->empty() ) {
      $year = $year->int();
      if( !isset( $start ) && !isset( $end ) ) {
        $start = $year;
        $end = $year;
      }
      if( $year > $end ) {
        $end = $year;
      } else if( $year < $start ) {
        $start = $year;
      }
    }
  }
  return $start . '—' . $end;
};

page::$methods['getThumb'] = function( $page, $size ) {
  $thumb = $page->thumb();
  if( $page->file( $thumb ) ) {
    $thumb = $page->file( $thumb );
  } else if( $page->images() ) {
    $thumb = $page->images()->first();
  } else {
    $thumb = null;
  }
  if( $thumb ) {
    if( $size === 'small' ) {
      $thumb = $thumb->resize( 200, 200, 100 );
    } else if( $thumb && $page->size() != 'large' ) {
      $thumb = $thumb->resize( 800, 800, 100 );
    } else {
      $thumb = $thumb->resize( 1500, 1500, 100 );
    }
    return $thumb;
  } else {
    return;
  }
}
?>