<?php
$item = $page;
if( !kirby()->request()->ajax() ) {
	$story = $item->parent();
	snippet( 'head', array( 
		'bodyClass' => array ( 'looking', 'story' ),
		'story' => $story,
		'item' => $item
	) );
	echo '<main data-title="' . $story->title() . '">';
	snippet( 'table', array( 'story' => $story ) );
	snippet( 'footnotes' );
	echo '<div class="single open object" data-slug="' . $item->slug() . '" data-title="' . $item->title() . '" data-url="' . $item->url() . '" data-type="object">';
} else {
	if( $thumb = $item->getThumb( 'large' ) ) {
		$thumb = $thumb->url();
	}
	echo '<div class="data" data-slug="' . $item->slug() . '" data-title="' . $item->title() . '" data-url="' . $item->url() . '" data-thumb="' . $thumb . '" data-type="object"></div>';
}
$image = $item->thumb();
$type = $item->type();
echo '<section>';
	snippet( 'buttons' );
	echo '<div class="scroll">';
		echo '<div class="inner">';
			echo '<div class="vert">';
				if( $type == 'video' ) {
					echo '<div class="block video">';
					  snippet( 'blocks/video', array( 'block' => $item ) );
					echo '</div>';
				} else {
					if( !$image->empty() ) {
						$image = $item->image( $image );
					} else {
						$image = $item->image();
					}
					echo '<div class="block image">';
						snippet( 'image', array( 'item' => $item, 'image' => $image ) );
					echo '</div>';
				}
			echo '</div>';
		echo '</div>';
	echo '</div>';
echo '</section>';
snippet( 'pagination', array( 'item' => $item ) );
if( !kirby()->request()->ajax() ) {
	echo '</div>';
	echo '</main>';
	echo '<footer>';
		snippet('collection');
	echo '</footer>';
	echo '</body>';
	echo '</html>';
}
?>