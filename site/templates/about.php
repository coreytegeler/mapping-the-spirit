<?php
$statement = $page->statement()->kirbytext();
$bio = $page->bio()->kirbytext();
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
			  		echo '<h2>' . $statement . '</h2>';
			  	echo '</div>';
					echo '<div class="img">';
						if( isset( $lead ) ) {
							echo '<img class="shift rotate" data-shift="' . -$shift . '" data-rotate="' . -$rotate .'" src="' . $lead->url() . '"/>';
						}
				  echo '</div>';
		  	echo '</div>';
		  	echo '<div class="block text columns">';
		  		echo $bio;
		  	echo '</div>';
			  echo '<div class="block full">';
				  $events = $page->events()->toStructure();
			  	if( sizeof( $events ) ) {
						echo '<ul>';
							echo '<li><h3>Events</h3></li>';
							foreach( $events->sortBy( 'date', 'DESC' ) as $item ) {
								// echo strtotime( '+10 day', $item->date() ) . '   ' . time();
								$status = ( strtotime( '+1 day', $item->date() ) < time() ? 'old' : 'new' );
								$title = $item->title();
								$link = $item->link();
								$date = $item->date( 'l, F j, Y' );
								$location = $item->location();
								echo '<li class="event ' . $status . '">';
									echo '<div class="label">';
										if( $date ) {
											echo '<span class="date">' . $date . '</span>';
										}
										if( $location->isNotEmpty() ) {
											echo 'at <span class="location">' . $location . '</span>';
										}
									echo '</div>';
									echo '<div class="name">';
										if( $link->isNotEmpty() ) {
											echo '<a href="' . $link . '" target="_blank">' . $title . '</a>';
										} else {
											echo $title;
										}
									echo '</div>';
								echo '</li>';
							}
						echo '</ul>';
					}
			  	$press = $page->press()->toStructure();
			  	if( sizeof( $press ) ) {
				  	echo '<ul class="press">';
				  		echo '<li><h3>Press</h3></li>';
			  			foreach( $press as $item ) {
				  			echo '<li class="press">';
					  			echo '<div class="source">' . $item->source() . '</div>';
				  				echo '<div class="title">';
					  				$link = $item->link();
				  					$title = $item->title();
				  					if( $link->isNotEmpty() ) {
					  					echo '<a href="' . $link . '" target="_blank">' . $title . '</a>';
					  				} else {
					  					echo $title;
					  				}
					  			echo '</div>';
				  			echo '</li>';
				  		}
				  	echo '</ul>';
				  }
			  	$credits = $page->credits()->toStructure();
			  	if( sizeof( $credits ) ) {
		  			echo '<ul class="credits">';
		  				echo '<li><h3>Credits</h3></li>';
			  			foreach( $credits as $credit ) {
				  			echo '<li class="credit">';
				  				echo '<div class="label">' . $credit->label() . '</div>';
				  				echo '<div class="name">';
					  				$link = $credit->link();
					  				$name = $credit->name();
					  				if( $link->isNotEmpty() ) {
					  					echo '<a href="' . $link . '" target="_blank">' . $name . '</a>';
					  				} else {
					  					echo $name;
					  				}
					  			echo '</div>';
				  			echo '</li>';
				  		}
				  	echo '</ul>';
				  }
			  echo '</div>';
		  echo '</div>';
		echo '</section>';
		snippet('footer');
  echo '</main>';
?>