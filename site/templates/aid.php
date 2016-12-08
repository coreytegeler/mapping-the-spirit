<?php
$stories = $pages->find('stories')->children()->visible();
snippet('head');
  echo '<main>';
		echo '<section id="aid">';
			echo '<div class="margin"></div>';
			echo '<div class="inner">';
		  	$storyInt = 1;
				foreach( $stories as $storySlug => $story ) {
					$url = $story->url();
					$thumb = $story->images()->first();
					$map = $story->image( $story->map() );
					$color = $story->color();
					$items = $story->children()->visible();
					// $quantity = sizeof( $items );
					$quantity = 0;
					foreach ($items as $item) {
						if( $item->intendedTemplate() == 'folder' ) {
							foreach ($item->images() as $image) {
								$quantity++;
							}
						} else {
							$quantity++;
						}
					}

					$creators = $story->creators()->kirbytext();
				  $span = $story->span()->kirbytext();
				  $abstract = $story->abstract()->kirbytext();
				  $history = $story->history()->kirbytext();
				  $scope = $story->scope()->kirbytext();
				  $access = $story->access()->kirbytext();
				  $use = $story->use()->kirbytext();

				  echo '<div class="story">';
					  echo '<h2 class="title">';
				  		echo '<a href="' . $url . '" style="color:' . $color . '">' .  $story->title() . '</a>';
				  	echo '</h2>';
				  	echo '<div class="collapsable">';
							echo '<div class="group details overview">';
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
						  echo '<div class="group details history">';
						  	echo '<h3 class="title">Historical Note</h3>';
						  	echo '<div class="text">';
						  		echo $history;
						  	echo '</div>';
						  echo '</div>';
							echo '<div class="group details scope">';
						  	echo '<h3 class="title">Scope & Content</h3>';
						  	echo '<div class="text">';
						  		echo $scope;
						  	echo '</div>';
						  echo '</div>';
						  echo '<div class="group details scope">';
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

					  	echo '<div class="group list">';
					  		echo '<h3 class="title">Items</h3>';
					  		echo '<div class="wrap items">';
					  			$itemInt = 0;
					  			if( !$quantity ) {
					  				echo '<div class="empty">No items in this collection</div>';
					  			}
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
					  echo '</div>';
				  	$storyInt++;
				  echo '</div>';
			  }
			echo '</div>';
			echo '<div class="margin"></div>';
		echo '</section>';
		snippet('footer');
  echo '</main>';
?>