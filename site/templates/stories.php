<?php
snippet('head');
  echo '<main>';
	  $stories = page( 'stories' )->children()->visible();
		echo '<section id="stories" class="rows">';
			echo '<div class="center">';
				echo '<h2 class="title">Stories</h2>';
				if( !$page->text()->empty() ) {
					echo '<div class="about">';
						echo $page->text()->kirbytext();
					echo '</div>';
				}
			echo '</div>';
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
				  			echo '<a href="' . $url . '" class="img rotate shift" style="background-color:' . $story->color() . '">';
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
			 echo '</div>';
			 echo '<h3 class="more">More stories coming soon</h3>';
		echo '</section>';
		snippet('footer');
  echo '</main>';
snippet('foot');
?>