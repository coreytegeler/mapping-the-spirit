<?php
$type = $item->_fieldset();
$title = $item->title();
$caption = $item->caption()->kirbytext();
$attribution = $item->attribution()->kirbytext();
$location = $item->location();
$month = $item->month();
$day = $item->day();
$year = $item->year();
$date = '';
if( !$month->empty() ) {
	$date = $month;
	if( !$day->empty() ) { $date .= ' ' . $day; }
	if( !$year->empty() ) { $date .= ' ' . $year; }
} else if ( !$year->empty() ) { $date - $year; }
if( $date || !$location->empty() ) {
	echo '<div class="meta">';
		if( $date ) {
			echo '<div class="cell">';
		  	echo $date;
		  echo '</div>';
	  }
		if( !$location->empty() ) {
			echo '<div class="cell">';
		  	echo $location;
	  	echo '</div>';
	  }
	  if( !$attribution->empty() && $type != 'quote' ) {
			echo '<div class="cell">';
		  	echo $attribution;
			echo '</div>';
		}
	echo '</div>';
}
if( !$caption->empty() ) {
	echo '<div class="caption">' . $caption . '</div>';
}
?>