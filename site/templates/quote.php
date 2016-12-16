<?php
$item = $page;
if(!kirby()->request()->ajax()) {
	$story = $item->parent();
	snippet( 'head', array( 
		'bodyClass' => array ( 'looking', 'story' ),
		'story' => $story,
		'item' => $item
	) );
	echo '<main>';
	snippet( 'table', array( 'story' => $story ) );
	snippet( 'footnotes' );
	echo '<div id="single" class="show open quote" data-item="' . $item->slug() . '" data-title="' . $item->title() . '" data-url="' . $item->url() . '" data-type="quote">';
} else {
	echo '<div class="data" data-item="' . $item->slug() . '" data-title="' . $item->title() . '" data-url="' . $item->url() . '" data-type="quote"></div>';
}
$size = $item->size();
echo '<section class="' . $item->size() . '">';
	echo '<div class="closeSingle"></div>';
	echo '<div class="scroll">';
		echo '<div class="inner">';
			echo '<div class="vert">';
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
echo '</section>';
if(!kirby()->request()->ajax()) {
	echo '</div>';
	echo '</main>';
	snippet('footer');
}
?>