<?php
$stories = $pages->find('stories')->children()->visible();
snippet('head');
  echo '<main>';
	  $creators = $page->creators()->kirbytext();
	  $span = $page->span()->kirbytext();
	  $quantity = $page->quantity()->kirbytext();
	  $abstract = $page->abstract()->kirbytext();
	  $history = $page->history()->kirbytext();
	  $scope = $page->scope()->kirbytext();
	  $access = $page->access()->kirbytext();
	  $use = $page->use()->kirbytext();
		echo '<section id="details">';
			echo '<div class="group overview">';
		  	echo '<h3 class="title">Overview</h3>';
		  	echo '<div class="text">';
		  		echo '<div class="subgroup">';
		  			echo '<span class="subtitle">Creators</span>';
				  	echo $creators;
				  echo '</div>';
		  		echo '<div class="subgroup">';
		  			echo '<span class="subtitle">Date Span</span>';
				  	echo $span;
				  echo '</div>';
				  echo '<div class="subgroup">';
		  			echo '<span class="subtitle">Quantity</span>';
				  	echo $quantity;
				  echo '</div>';
		  		echo '<div class="subgroup">';
		  			echo '<span class="subtitle">Abstract</span>';
				  	echo $abstract;
				  echo '</div>';
		  	echo '</div>';
		  echo '</div>';
		  echo '<div class="group history">';
		  	echo '<h3 class="title">Historical Note</h3>';
		  	echo '<div class="text">';
		  		echo $history;
		  	echo '</div>';
		  echo '</div>';
			echo '<div class="group scope">';
		  	echo '<h3 class="title">Scope & Content</h3>';
		  	echo '<div class="text">';
		  		echo $scope;
		  	echo '</div>';
		  echo '</div>';
		  echo '<div class="group scope">';
			  echo '<h3 class="title">Restrictions</h3>';
		  	echo '<div class="text">';
		  		echo '<div class="subgroup">';
		  			echo '<span class="subtitle">Access</span>';
				  	echo $access;
				  echo '</div>';
			  	echo '<div class="subgroup">';
			  		echo '<span class="subtitle">Use</span>';
				  	echo $use;
				  echo '</div>';
				 echo '</div>';
		  echo '</div>';
		echo '</section>';
  	echo '<section id="list">';
	  	$storyInt = 1;
			foreach( $stories as $storySlug => $story ) {
				$url = $story->url();
				$thumb = $story->images()->first();
				$map = $story->image( $story->map() );
				$color = $story->color();
		  	echo '<div class="group story">';
			  	echo '<h3 class="story title">';
			  		echo '<a href="' . $url . '" style="color:' . $color . '">' .  $story->title() . '</a>';
			  	echo '</h3>';
		  		$items = $story->children()->visible();
		  		echo '<div class="wrap items">';
		  			$itemInt = 0;
						foreach( $items as $itemSlug => $item ) {
							$images = $item->images();
							$imagesCount = sizeof( $images );
							echo '<div class="wrap item">';
								echo '<div class="item title">';
						  		echo '<a href="' . $item->url() . '" style="color:' . $color . '">';
						  			echo $storyInt . '.' . $itemInt . ' ' . $item->title();
						  			echo '<div class="meta">';
							  			echo '<span class="type">' . $item->intendedTemplate() . '</span>';
							  			echo '<span class="images">' . sizeof( $images );
							  				if( $imagesCount == 1 ) {
							  					echo ' Image';
							  				} else {
							  					echo ' Images';
							  				}
							  			echo '</span>';
							  			if( !$item->text()->kirbytext()->empty() ) {
								  			echo '<span class="text">Includes text</span>';
								  		}
							  			// echo '<span class="date">' . strftime('%d/%m/%Y', $item->date(null, 'createdAt')) . '</span>';
							  		echo '</div>';
						  		echo '</a>';
						  		if( $imagesCount ) {
						  			$imageInt = 0;
						  			echo '<ul class="images">';
							  		foreach( $images as $imageSlug => $image ) {
							  			$imageTitle = $image->title();
							  			echo '<li>';
								  			echo $storyInt . '.' . $itemInt . '.' . $imageInt . ' ';
							  				if( !$imageTitle->empty() ) {
							  					echo '<em>' . $imageTitle . '</em>';
							  				} else {
							  					echo '<em>Untitled image</em>';
							  				}
							  			echo '</li>';
							  			$imageInt++;
							  		}
							  		echo '</ul>';
							  	}
						  	echo '</div>';
							echo '</div>';
							$itemInt++;
						}
					echo '</div>';
		  	echo '</div>';
		  	$storyInt++;
		  }
		echo '</section>';
		snippet('footer');
  echo '</main>';
?>