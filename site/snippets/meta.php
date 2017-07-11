<?php
$type = $item->_fieldset();
$title = $item->title();
$caption = $item->caption()->kirbytext();
$attribution = $item->attribution()->kirbytext();
$location = $item->location();
$month = $item->month();
$day = $item->day();
$year = $item->year();
$citation = $item->citation();
$date = '';
if( !$month->empty() ) {
	$date = $month;
	if( !$day->empty() ) { $date .= ' ' . $day; }
	if( !$year->empty() ) { $date .= ' ' . $year; }
} else if ( !$year->empty() ) {
	$date = $year;
}

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
  if( !$attribution->empty() ) {
		echo '<div class="cell">';
			
			$attribution = preg_replace('~<p>(.*?)</p>~is', '$1', $attribution, 1);
	  	echo $attribution;
		echo '</div>';
	}
	if ( !$citation->empty() ) {
		echo '<div class="cell show cite">';
	  	echo 'Show citation';
		echo '</div>';	
	}
	if ( !$citation->empty() ) {
		echo '<div class="cell copy cite" data-clipboard-text="' . strip_tags( $citation->kirbytext() ) . '">';
	  	echo 'Copy citation';
		echo '</div>';	
	}
echo '</div>';
if( !$caption->empty() ) {
	echo '<div class="caption">' . $caption . '</div>';
}
if ( !$citation->empty() ) {
	echo '<div class="citation">';
		echo $citation->kirbytext();
	echo '</div>';
}
?>