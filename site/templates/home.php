<?php
snippet('head');
  echo '<main>';
	  $stories = page( 'stories' )->children()->visible();
  	echo '<section id="map">';
  		if( $map = $page->map() ) {
					$map = $page->image( $map )->resize( 1700, 1700, 100 )->url();
		  	echo '<div class="map shift" style="background-image:url(' . $map . ')" data-shift="2"></div>';
		  }
		  if( $logo = $page->logo() ) {
					$logo = $page->image( $logo )->resize( 1700, 1700, 100 )->url();
		  	echo '<div class="logo shift" data-shift="-2">';
		  		echo '<img src="' . $logo . '"/>';
		  	echo '</div>';
		  } else {
		  	echo '<div class="shift title" data-shift="-2">';
			  	echo '<h1>';
			  		echo $site->title();
			  	echo '</h1>';
			  echo '</div>';
			}
			$begin_svg = url( 'assets/images/down.svg' );
		  echo '<div id="begin">';
		  	echo '<div>Begin</div>';
		  echo '</div>';
		echo '</section>';
		echo '<section id="stories" class="rows">';
			snippet( 'header', array( 'pageTitle' => 'STORIES' ) );
			echo '<div class="about">';
				echo '<h2>';
					echo $page->brief()->kirbytext();
				echo '</h2>';
			echo '</div>';
			echo '<div class="instruct">';
				echo '<h2>Learn <a href="' . page( 'about' )->url() . '">more</a>.</h2>';
				echo '<h2>Browse the <a href="' . page( 'aid' )->url() . '">finding aid</a>.</h2>';
				echo '<h2>Create a <a href="' . page( 'collection' )->url() . '">collection</a>.</h2>';
			echo '</div>';
			echo '<div class="dash"><div class="solid"></div></div>';
			echo '<div class="rowrap">';
				$index = 0;
				foreach( $stories as $story ) {
					$index++;
					$url = $story->url();
					$thumb = $story->getThumb( 'large' );
					$rotate = mt_rand( -25, 10 )/100;
					$shift = mt_rand( -300, -200 )/100;
			  	echo '<div class="row story ' . ( $index % 2 == 0 ? 'even' : 'odd' ) . '">';
				  	echo '<div class="wrap">';
				  		echo '<div class="image">';
				  			echo '<a href="' . $url . '" class="img rotate shift" style="background-color:' . $story->color() . '" data-rotate="' . $rotate . '" data-shift="' . $shift . '">';
				  				if( $thumb ) {
								  	echo '<img src="' . $thumb->url() . '"/>';
								  }
							  echo '</a>';
						  echo '</div>';
						  echo '<a href="' . $url . '"  class="title" style="color:' . $story->color() . '">';
						  	$rotate = mt_rand( -25, 10 )/100;
								$shift = mt_rand( -100, -50 )/100;
				  			echo '<h1 class="shift rotate" data-shift="' . $shift . '" data-rotate="' . $rotate .'" data-index="' . $index/2 . '">' .  $story->title() . '</h1>';
				  		echo '</a>';
					  echo '</div>';
			  	echo '</div>';
			  }
			  echo '<h3 class="more">More stories coming soon</h3>';
			echo '</div>';
			echo '<div class="dash"><div class="solid"></div></div>';
		echo '</section>';
		if( $field_notes = page( 'field-notes' ) ) {
			$field_notes = $field_notes->children()->visible();
			if( sizeof( $field_notes ) ) {
				echo '<section id="field-notes" class="rows">';
					// echo '<div class="dash"></div>';
				echo '<h4>Field Notes</h4>';
					echo '<div class="rowrap">';
						$index = 0;
						foreach( $field_notes as $field_note ) {
							$index++;
							if( $index % 2 == 0 ) {
								$sign = -1;
							} else {
								$sign = 1;
							}
							$url = $field_note->url();
							$thumb = $field_note->getThumb( 'large' );
							$rotate = mt_rand( -25, 10 )/100;
							$shift = mt_rand( -50, -25 )/100 * $sign;
					  	echo '<div class="row field-note ' . ( $index % 2 == 0 ? 'odd ' : 'even ' ) . ( !$thumb ? ' no-thumb' : '' ) . '">';
						  	echo '<div class="wrap">';
						  	 if( $thumb ) {
							  		echo '<div class="image">';
							  			echo '<a href="' . $url . '" class="img rotate shift" style="background-color:' . $field_note->color() . '" data-shift="' . $shift . '" data-rotate="' . $rotate .'" data-index="' . $index . '">';
							  				if( $thumb ) {
											  	echo '<img src="' . $thumb->url() . '"/>';
											  }
										  echo '</a>';
									  echo '</div>';
									}
								  $rotate = mt_rand( -25, 10 )/100;
									$shift = mt_rand( -50, -25 )/100 * $sign;
					  			echo '<a href="' . $url . '" class="title">';
					  				echo '<h2 class="shift rotate" data-shift="' . $shift . '" data-rotate="' . $rotate .'" data-index="' . $index/2 . '">' .  $field_note->title() . '</h2>';
					  			echo '</a>';
							  echo '</div>';
					  	echo '</div>';
					  }
					 echo '</div>';
				echo '</section>';
			}
		}

		$events = page( 'about' )->events()->toStructure()->flip();
		if( $events ) {
			echo '<section id="events" class="rows">';
				echo '<h4>Upcoming Events</h4>';
				echo '<div class="rowrap center">';
				foreach( $events as $item ) {
					// if( strtotime( '+1 day', $item->date() ) < time() )
					echo '<div class="row event ' . ( $index % 2 == 0 ? 'odd ' : 'even ' ) . '">';
						// echo strtotime( '+10 day', $item->date() ) . '   ' . time();
						$link = $item->link();
						$date = $item->date( 'l, F j' );
						$location = $item->location();
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
	  }


  echo '</main>';
snippet('footer')
?>