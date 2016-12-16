<?php
$location = $item->location();
$month = $item->month();
$day = $item->day();
$year = $item->year();
$date = '';
if( !$month->empty() ) {
	$date = $month;
	if( !$day->empty() ) { $date .= ', ' . $day; }
	if( !$year->empty() ) { $date .= ' ' . $year; }
} else if ( !$year->empty() ) { $date - $year; }

echo '<div class="meta">';
	echo '<div class="row">';
	  if( !$date ) {
	  	echo 'Unknown date';
	  } else {
	  	echo $date;
	  }
	echo '</div>';
	echo '<div class="row">';
	  if( $location->empty() ) {
	  	echo 'Unknown location';
	  } else {
	  	echo $location;
	  }
	echo '</div>';
echo '</div>';
?>