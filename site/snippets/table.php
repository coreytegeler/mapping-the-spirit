<?php
$title = $story->title();
$text = $story->text();
$map = $story->image ( $story->map() )->url();
$color = $story->color();
echo '<div id="table" class="horzScroll">';
	echo '<div id="title" class="title">';
	  echo '<div class="horz">';
	 		echo '<div class="vert">';
			  echo '<h1>' . $title . '</h1>';
			  echo '<div class="text">' . $text . '</div>';
		  echo '</div>';
		echo '</div>';
	echo '</div>';
	echo '<div id="map">';
	  echo '<img src="' . $map . '" class="horz"/>';
	echo '</div>';
  echo '<div class="grid">';
	  $items = $story->children()->visible();
	  foreach( $items as $index => $item ) {
	  	$type = $item->intendedTemplate();
	  	echo '<div class="click item droppable ' . $type . ' ' . $item->size() . '" data-index="' . $index . '" data-story="' . $story->slug() . '" data-slug="' . $item->slug() . '" data-type="' . $type . '" data-url="' . $item->url() . '" style="color:' . $color . '" data-title="' . $item->title() . '">';
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