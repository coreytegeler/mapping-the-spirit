<?php
if( isset( $story ) ) {
	$title = $story->title();
	$slug = $story->slug();
	$thumb = $story->getThumb('large');
	$historical = $story->historical()->kirbytext();
	if( $story->map() && $story->image ( $story->map() ) ) {
		$map = $story->image ( $story->map() )->url();
	}
	$color = $story->color();
	$collaborators = $story->collaborators()->kirbytext();
	$span = $story->getSpan();
	$quantity = 0;
	$links = $story->links()->toStructure();
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
}
if( $page->intendedTemplate() == 'story' || $page->intendedTemplate() == 'collection' ) {
	$url = $page->url();
} else {
	$url = $story->url();
}
echo '<div id="table" class="horzScroll"' . ( $slug ? ' data-story="' . $slug . '"' : '' ) . ' data-url="' . $url . '">';
	$index = $pages->indexOf( $slug ) + 1;
	if( isset( $story ) ) {
		echo '<div id="title" class="card full ' . ( $index % 2 == 0 ? 'even' : 'odd' ) . '">';
			echo '<div class="mask">';
				echo '<div class="titleWrap">';
					$rotate = mt_rand( -25, 0 )/100;
					$shift = mt_rand( -200, -100 )/100;
					echo '<div class="image">';
		  			echo '<div class="img rotate shift" style="background-color:' . $story->color() . '" data-rotate="' . $rotate .'" data-shift="' . $shift . '">';
		  				if( $thumb ) {
						  	echo '<img src="' . $thumb->url() . '"/>';
						  }
					  echo '</div>';
				  echo '</div>';
				  $rotate = mt_rand( 0, 25 )/100;
					$shift = mt_rand( 100, 200 )/100;
					echo '<h1 class="title" style="color:' . $story->color() . '"><div class="rotate shift" data-rotate="' . $rotate . '" data-shift="' . $shift . '">' .  $story->title() . '</div></h1>';
				echo '</div>';
			echo '</div>';
		echo '</div>';
		echo '<div id="info" class="card full">';
	 		echo '<div class="vert">';
	 			echo '<h3>Overview</h3>';
	 			echo '<div class="details">';
			  	echo '<div class="row"><label>Collaborators</label>' . $collaborators . '</div>';
			  	echo '<div class="row"><label>Date Span</label>' . $span . '</div>';
			  	echo '<div class="row"><label>Quantity</label>' . $quantity . '</div>';
			  echo '</div>';
		  	echo '<h3>Historical Note</h3>';
		  	echo '<div class="historical">' . $historical . '</div>';
		  	echo '<div class="aid">Read more on the <a href="' . page( 'aid' )->url() . '#' . $slug . '" style="color:' . $story->color() . '">Finding Aid</a></div>';
			echo '</div>';
		echo '</div>';
	} else {
		echo '<div class="card half">';
			echo '<div class="horz">';
				echo '<div class="vert">';
					$rotate = mt_rand( -25, 0 )/100;
					$shift = mt_rand( -100, -50 )/100;
					echo '<h1 class="title"><div class="rotate shift" data-rotate="' . $rotate . '" data-shift="' . $shift . '">Collection</div></h1>';
					echo '<div  class="text">';
						echo $page->text();
					echo '</div>';
				echo '</div>';
			echo '</div>';
		echo '</div>';
	}
	if( $map ) {
		$rotate = mt_rand( 0, 25 )/100;
		$shift = mt_rand( 100, 200 )/100;
		echo '<div id="map" class="card full rotate shift" data-index="0" data-shift="' . $shift . '" data-rotate="' . $rotate . '">';
		  echo '<img src="' . $map . '" class="horz"/>';
		echo '</div>';
	}
  echo '<div id="grid">';
  	if( $items ) {
		  $index = 0;
		  foreach( $items as $slug => $item ) {
		  	snippet( 'item', array( 'item' => $item, 'story' => $story, 'index' => $index ) );
				$index++;
			}
		}
		echo '<div class="sizer"></div>';
		echo '<div class="gutter"></div>';
	echo '</div>';

	if( isset( $links ) ) {
		echo '<div class="card full end">';
		  echo '<div class="horz">';
		 		echo '<div class="vert">';
		 			echo '<div class="inner">';
			 			echo '<div class="column">';
				 			echo '<ul>';
				 				echo '<li><h3>External Resources</h3></li>';
							  foreach( $links as $index => $link ) {
							  	echo '<li>';
								  	echo '<a href="' . $link->url() . '" target="_bank" style="color:' . $color . '">';
								  	  echo $link->title();
								  	  echo '<div class="tags">';
									  	  $tagdex = 0;
									  	  $tags = $link->tags()->split();
									  	  $count = sizeof( $tags );
									  	  foreach( $tags as $tag ) {
									  	  	echo $tag;
									  	  	if( $count > 1 && $tagdex < $count - 1 ) {
									  	  		echo ', ';
									  	  	}
									  	  	$tagdex++;
									  	  }
											echo '</div>';
								  	echo '</a>';
								  echo '</li>';
							  }
							echo '</ul>';
						echo '</div>';
					echo '</div>';
				echo '</div>';
			echo '</div>';
		echo '</div>';
	}

	echo '<div class="card half end">';
	  echo '<div class="horz">';
	  	echo '<div class="vert">';
				snippet( 'footer', array( 'card' => true ) );
			echo '</div>';
		echo '</div>';
	echo '</div>';

echo '</div>';
if( $story ) {
	snippet( 'collection' );
}
?>