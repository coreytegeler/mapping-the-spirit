<?php
snippet('head');
echo '<main>';
	echo '<section id="error">';
		if( $map = page( 'home' )->map() ) {
				$map = page( 'home' )->image( $map )->resize( 1700, 1700, 100 )->url();
	  	echo '<div class="map shift" style="background-image:url(' . $map . ')" data-shift="2"></div>';
	  }
  	echo '<div class="shift title" data-shift="-2">';
  		echo '<div class="text">';
		  	echo '<h1>ERROR</h1>';
		  	echo '<a class="back" href="#">Go back?</a>';
			echo '</div>';  	
	  echo '</div>';
	echo '</section>';
	snippet('footer');
echo '</main>';
?>
