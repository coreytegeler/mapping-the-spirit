<?php
snippet('head');
  echo '<main>';
  	echo '<section class="map">';
	  	echo '<div class="title">';
		  	echo '<h1>';
		  		echo $site->title();
		  	echo '</h1>';
		  echo '</div>';
		echo '</section>';
		echo '<section class="stories">';
			snippet( 'header', array( 'subtitle' => 'STORIES' ) );
			echo '<div class="about">';
				echo 'Mapping the Spirit documents the texture of spiritual life amongst people of African descent in America by amplifying these voices to create more nuanced history.';
			echo '</div>';
			echo '<div class="dash"></div>';
			$stories = $pages->find('stories')->children()->visible();
			foreach( $stories as $index => $story ) {
				$url = $story->url();
				$thumb = $story->images()->first();
				$map = $story->image( $story->map() )->url();
		  	echo '<div class="story">';
			  	echo '<a href="' . $url . '">';
			  		echo '<h1 class="title">' .  $story->title() . '</h1>';
			  		echo '<div class="image">';
					  	echo '<img src="' . $thumb->url() . '"/>';
				  	echo '</div>';
				  echo '</a>';
		  	echo '</div>';
		  	#snippet( 'dashed' );
		  }
		echo '</section>';
  echo '</main>';
snippet('footer')
?>