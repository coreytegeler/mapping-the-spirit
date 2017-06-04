<?php
$statement = $page->statement()->kirbytext();
if( $page->lead()->isNotEmpty() ) {
	$lead = $page->image( $page->lead() )->resize( 1000, 1000, 100 );
}
snippet('head');
  echo '<main>';
		echo '<section id="about">';
			echo '<div class="inner">';
				echo '<div class="center">';
			  	echo '<div class="block text">';
			  		echo '<h2 class="title">About</h2>';
		  		echo '</div>';
		  	echo '</div>';
	  		echo '<div class="block text statement">';
		  		echo '<h2>' . $statement . '</h2>';
		  	echo '</div>';
	  		echo '<div class="block image">';
					echo '<div class="img">';
						$rotate = mt_rand( -25, 0 )/100;
						$shift = mt_rand( -200, -100 )/100;
						if( isset( $lead ) ) {
							echo '<img class="shift rotate" data-shift="' . $shift . '" data-rotate="' . $rotate .'" src="' . $lead->url() . '"/>';
						}
				  echo '</div>';
		  	echo '</div>';
		  	echo '<div class="center">';
				  echo '<div class="block text">';
		  			$credits = $page->credits()->toStructure();
		  			echo '<ul class="credits">';
		  				echo '<li><h3>Credits</h3></li>';
			  			foreach( $credits as $credit ) {
				  			echo '<li class="credit">';
				  				echo '<div class="label">' . $credit->label() . '</div>';
				  				echo '<div class="name">';
					  				if( $link = $credit->link() ) {
					  					echo '<a href="' . $link . '" target="_blank">' . $credit->name() . '</a>';
					  				} else {
					  					echo $credit->name();
					  				}
					  			echo '</div>';
				  			echo '</li>';
				  		}
				  	echo '</ul>';
				  	$press = $page->press()->toStructure()->flip();
				  	echo '<ul class="press">';
				  		echo '<li><h3>Press</h3></li>';
			  			foreach( $press as $item ) {
				  			echo '<li class="press">';
					  			echo '<div class="source">' . $item->source() . '</div>';
				  				echo '<div class="title">';
				  					if( $link = $item->link() ) {
					  					echo '<a href="' . $link . '" target="_blank">' . $item->title() . '</a>';
					  				} else {
					  					echo $item->title();
					  				}
					  			echo '</div>';
				  			echo '</li>';
				  		}
				  	echo '</ul>';
				  echo '</div>';
		  	echo '</div>';
		  echo '</div>';
		echo '</section>';
		snippet('footer');
  echo '</main>';
?>