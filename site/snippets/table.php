<?php
$title = $story->title();
$text = $story->text();
if( $story->map() && $story->image ( $story->map() ) ) {
	$map = $story->image ( $story->map() )->url();
}
$color = $story->color();
$collaborators = $story->collaborators()->kirbytext();
$span = $story->span()->kirbytext();
$quantity = 0;
$items = $story->children()->visible();
foreach ($items as $item) {
	if( $item->intendedTemplate() == 'folder' ) {
		foreach ($item->images() as $image) {
			$quantity++;
		}
	} else {
		$quantity++;
	}
}
echo '<div id="table" class="horzScroll" data-story="' . $story->slug() . '">';
	echo '<div id="title" class="title">';
	  echo '<div class="horz">';
	 		echo '<div class="vert">';
			  echo '<h1>' . $title . '</h1>';
			  echo '<div class="columns">';
				  echo '<div class="details">';
				  	echo '<div class="row"><label>Collaborators</label>' . $collaborators . '</div>';
				  	echo '<div class="row"><label>Span</label>' . $span . '</div>';
				  	echo '<div class="row"><label>Quantity</label>' . $quantity . '</div>';
					  echo '<div class="row"><a href="' . page( 'aid' )->url() . '" style="color:' . $story->color() . '">View Finding Aid</a></div>';
				 	echo '</div>';
				 	echo '<div class="text">' . $text . '</div>';
			  echo '</div>';
		  echo '</div>';
		echo '</div>';
	echo '</div>';
	echo '<div id="map" class="rotate shift" data-index="0" data-shift="' . rand(-2, 2) . '" data-rotate="' . rand(-1, 1) . '" >';
	  echo '<img src="' . $map . '" class="horz"/>';
	echo '</div>';
  echo '<div class="grid">';	  
	  $index = 0;
	  foreach( $items as $slug => $item ) {
	  	$type = $item->intendedTemplate();

	  	if( $type == 'quote' ) {
	  		$display = 'text';
	  	} else if( $type == 'object' ) {
	  		$display = 'image';
	  	} else {
	  		$display = $item->display();
	  	}

	  	$index++;
	  	echo '<div class="click item rotate shift droppable ' . $type . ' ' . $item->size() . ' ' . $display . '" data-shift="' . rand(2, 3) . '" data-rotate="' . rand(-1, 1) . '" data-story="' . $story->slug() . '" data-slug="' . $item->slug() . '" data-type="' . $type . '" data-url="' . $item->url() . '" style="color:' . $color . '" data-title="' . $item->title() . '" data-index="' . $index . '">';
	  		echo '<div class="inner">';
				  snippet( 'items/' . $type, array( 'item' => $item, 'color' => $color ) );
				echo '</div>';
			echo '</div>';
		}
		echo '<div class="sizer"></div>';
		echo '<div class="gutter"></div>';
	echo '</div>';
echo '</div>';
snippet( 'collection' );
?>