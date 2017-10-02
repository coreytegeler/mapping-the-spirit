<?php
$about_project = $page->about_project()->kirbytext();
$about_kameelah = $page->about_kameelah()->kirbytext();
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
	  		echo '<div class="block image">';
	  			$rotate = mt_rand( -25, 0 )/100;
					$shift = mt_rand( -200, -100 )/100;
	  			echo '<div class="text shift rotate" data-shift="' . $shift . '" data-rotate="' . $rotate .'">';
			  		echo '<h2>' . $about_project . '</h2>';
			  	echo '</div>';
					echo '<div class="img">';
						if( isset( $lead ) ) {
							echo '<img class="shift rotate" data-shift="' . -$shift . '" data-rotate="' . -$rotate .'" src="' . $lead->url() . '"/>';
						}
				  echo '</div>';
		  	echo '</div>';

		  	$events = $page->events()->toStructure()->flip();
		  	echo '<div class="block" id="events">';
		  		echo '<h3>Upcoming Events</h3>';
	  			foreach( $events as $item ) {
	  				// echo strtotime( '+10 day', $item->date() ) . '   ' . time();
	  				$status = ( strtotime( '+1 day', $item->date() ) < time() ? 'old' : 'new' );
	  				$link = $item->link();
	  				$date = $item->date( 'l, F j' );
	  				$location = $item->location();
		  			echo '<div class="event ' . $status . '">';
	  					if( $link->isNotEmpty() ) {
		  					echo '<a href="' . $link . '" target="_blank">';
	  					}
	  					echo '<h2>';

	  					echo '<span class="name">' . $item->title() . '</span>';

	  					if( $date ) {
	  						echo ' on ' . $date;
	  					}

	  					if( $location->isNotEmpty() ) {
	  						echo  sizeof( $location );
	  						echo ' at ' . $location;
	  					}
	  					echo '</h2>';

	  					if( $link->isNotEmpty() ) {
		  					echo '</a>';
		  				}
		  			echo '</div>';
		  		}
		  	echo '</div>';

		  	echo '<div class="block text columns">';
		  		echo $about_kameelah;
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