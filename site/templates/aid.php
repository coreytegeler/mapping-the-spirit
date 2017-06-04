<?php
$stories = $pages->find( 'stories' )->children()->visible();
$abstract = $page->abstract()->kirbytext();
$access = $page->access()->kirbytext();
$use = $page->use()->kirbytext();
snippet('head');
  echo '<main>';
		echo '<section id="aid" class="list">';
			echo '<div class="center">';
				echo '<h2 class="title">Finding Aid</h2>';
				echo '<div class="group details overview">';
			  	echo '<div class="text">';
			  		// echo '<div class="subgroup">';
			  		// 	echo '<span class="subtitle">Abstract</span>';
					  // 	echo $abstract;
					  // echo '</div>';
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
		  	$storyInt = 1;
				foreach( $stories as $story ) {
					$url = $story->url();
					$slug = $story->slug();
					$thumb = $story->images()->first();
					$map = $story->image( $story->map() );
					$color = $story->color();
					$items = $story->children()->visible();
					$quantity = 0;
					foreach ($items as $item) {
						if( $item->intendedTemplate() == 'folder' ) {
							foreach ($item->images()->filterBy( 'left', '==', 'true' ) as $image) {
								$quantity++;
							}
						}
						if( $item->intendedTemplate() == 'folder' || $item->intendedTemplate() == 'stack' ) {
							foreach( $item->blocks()->toStructure() as $index => $block ) {
								if( $block->_fieldset() == 'image' || $block->_fieldset() == 'video' ) {
									$quantity++;
								}
							}
						} else {
							$quantity++;
						}
					}
					$collaborators = $story->collaborators()->kirbytext();
				  $span = $story->getSpan();
				  $historical = $story->historical()->kirbytext();
				  $scope = $story->scope()->kirbytext();

				  echo '<div id="' . $slug . '" class="story">';
					  echo '<h2>';
				  		echo '<a href="' . $url . '" style="color:' . $color . '">' .  $story->title() . '</a>';
				  	echo '</h2>';
				  	echo '<div class="collapsable">';
							echo '<div class="group details overview">';
						  	echo '<h3>Overview</h3>';
						  	echo '<div class="text">';
						  		echo '<div class="subgroup">';
						  			echo '<span class="subtitle">Collaborators</span>';
								  	echo $collaborators;
								  echo '</div>';
						  		echo '<div class="subgroup">';
						  			echo '<span class="subtitle">Date Span</span>';
								  	echo $span;
								  echo '</div>';
								  echo '<div class="subgroup">';
						  			echo '<span class="subtitle">Quantity</span>';
								  	echo $quantity;
								  echo '</div>';
						  	echo '</div>';
						  echo '</div>';
						  echo '<div class="group details history">';
						  	echo '<h3>Historical Note</h3>';
						  	echo '<div class="text">';
						  		echo $historical;
						  	echo '</div>';
						  echo '</div>';
							echo '<div class="group details scope">';
						  	echo '<h3>Scope & Content</h3>';
						  	echo '<div class="text">';
						  		echo $scope;
						  	echo '</div>';
						  echo '</div>';

					  	echo '<div class="group list">';
						  	if( $quantity ) {
						  		echo '<h3>Items</h3>';
						  	}
					  		echo '<div class="wrap items">';
					  			$itemInt = 0;
					  			if( !$quantity ) {
					  				echo '<div class="empty">No items in this story</div>';
					  			}
									foreach( $items as $itemSlug => $item ) {
										$videos = new ArrayObject();
										if( $item->intendedTemplate() == 'folder' ) {
											$images = $item->images()->filterBy( 'left', '==', 'true' );
										} else {
											$images = array();
										}
										if( $item->intendedTemplate() == 'folder' || $item->intendedTemplate() == 'stack' ) {
											foreach( $item->blocks()->toStructure() as $index => $block ) {
												if( $block->_fieldset() == 'image' ) {
													if( $image = $item->image( $block->image() ) ) {
														if( is_array( $images ) ) {
															$images[] = $image;
														} else {
															$images->prepend( $index, $image );
														}
													}
												} else {
													if( $block->_fieldset() == 'video' ) {
														if( !$block->title()->empty() ) {
															$title = $block->title();
														} else {
															$title = 'Untitled video';
														}
														$videos->append( $title );
													}
												}
											}
										}
										$imagesCount = sizeof( $images );
										$videosCount = sizeof( $videos );
										$type = $item->intendedTemplate();
										echo '<div class="wrap item" data-slug="' . $item->slug() . '">';
								  		echo '<a href="' . $item->url() . '" style="color:' . $color . '">';
								  			echo '<div class="title">';
								  				echo $storyInt . '.' . $itemInt . ' ' . $item->title();
								  			echo '</div>';
								  		echo '</a>';
							  			echo '<div class="meta">';
								  			echo '<span class="type">';
									  			if( $type == 'object' ) {
									  				echo 'Object';
									  			} else {
									  				if( $imagesCount || $videosCount ) {
										  				echo 'Collection';
									  				} else {
									  					echo 'Text';
									  				}
									  			}
								  			echo'</span>';
								  			if( $blocks = $item->blocks() ) {
								  				$blocks = $item->blocks();
							  					foreach( $blocks->toStructure() as $block ) {
							  						$fieldset = $block->_fieldset();
							  						$text = '';
							  						if( $fieldset == 'text' || $fieldset == 'quote' ) {
							  							$text .= $block->text();
							  						}
							  					}
							  					if( $wordCount = str_word_count( $text ) ) {
							  						echo '<span class="words">';
									  					echo $wordCount . ' Words';
								  					echo'</span>';
							  					}
									  		}
								  			if( $imagesCount ) {
									  			echo '<span class="count">' . $imagesCount;
									  				if( $imagesCount == 1 ) {
									  					echo ' Image';
									  				} else {
									  					echo ' Images';
									  				}
									  			echo '</span>';
									  		}
									  		if( $videosCount ) {
									  			echo '<span class="count">' . $videosCount;
									  				if( $videosCount == 1 ) {
									  					echo ' Video';
									  				} else {
									  					echo ' Videos';
									  				}
									  			echo '</span>';
									  		}
								  			// echo '<span class="date">' . strftime('%d/%m/%Y', $item->date(null, 'createdAt')) . '</span>';
								  		echo '</div>';
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
									  		foreach( $videos as $video ) {
									  			echo '<li>';
										  			echo $storyInt . '.' . $itemInt . '.' . $imageInt . ' ';
										  			echo '<em>' . $video . '</em>';
										  		echo '</li>';
									  			$imageInt++;
									  		}
									  		echo '</ul>';
									  	}
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
		echo '</section>';
		snippet('footer');
  echo '</main>';
?>