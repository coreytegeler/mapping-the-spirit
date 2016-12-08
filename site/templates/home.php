<?php
snippet('head');
  echo '<main>';
  	echo '<section id="map">';
	  	echo '<div class="map shift" data-shift="2"></div>';
	  	echo '<div class="shift title" data-shift="-2">';
		  	echo '<h1>';
		  		echo $site->title();
		  	echo '</h1>';
		  echo '</div>';
		echo '</section>';
		echo '<section id="stories">';
			snippet( 'header', array( 'pageTitle' => 'STORIES' ) );
			echo '<div class="about">';
				echo $site->description();
			echo '</div>';
			echo '<div class="dash"></div>';
			$stories = $pages->find('stories')->children()->visible();
			foreach( $stories as $index => $story ) {
				$url = $story->url();
				$thumb = $story->images()->first();
		  	echo '<div class="story">';
			  	echo '<a href="' . $url . '" style="color:' . $story->color() . '">';
			  		echo '<h1 class="title">' .  $story->title() . '</h1>';
			  		echo '<div class="image" style="background-color:' . $story->color() . '">';
			  			if( $thumb ) {
						  	echo '<img src="' . $thumb->url() . '"/>';
			  			}
				  	echo '</div>';
				  echo '</a>';
		  	echo '</div>';
		  }
		  echo '<div class="dash"></div>';
		echo '</section>';
  echo '</main>';
snippet('footer')
?>