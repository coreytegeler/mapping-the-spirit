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
	echo '<div class="single open quote" data-slug="' . $item->slug() . '" data-title="' . $item->title() . '" data-url="' . $item->url() . '" data-type="quote">';
} else {
	if( $thumb = $item->getThumb( 'large' ) ) {
		$thumb = $thumb->url();
	}
	echo '<div class="data" data-slug="' . $item->slug() . '" data-title="' . $item->title() . '" data-url="' . $item->url() . '" data-thumb="' . $thumb . '" data-type="quote"></div>';
}
$size = $item->size();
echo '<section class="' . $item->size() . '">';
	snippet( 'buttons' );
	echo '<div class="scroll">';
		echo '<div class="inner">';
			echo '<div class="vert">';
				echo '<div class="block quote">';
					echo '<div class="text">';
						echo $item->text()->kirbytext();
					echo '</div>';
					echo '<div class="attribution">';
						echo $item->attribution();
					echo '</div>';
					snippet( 'meta', array( 'item' => $item ) );
				echo '</div>';
			echo '</div>';
		echo '</div>';
	echo '</div>';
echo '</section>';
snippet( 'pagination', array( 'item' => $item ) );
if( !kirby()->request()->ajax() ) {
	echo '</div>';
	echo '</main>';
	echo '</body>';
	echo '</html>';
}
?>