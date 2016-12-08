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
	echo '<div id="single" class="show paper open" data-item="' . $item->slug() . '" data-title="' . $item->title() . '" data-url="' . $item->url() . '" data-type="paper">';
} else {
	echo '<div class="data" data-item="' . $item->slug() . '" data-title="' . $item->title() . '" data-url="' . $item->url() . '" data-type="paper"></div>';
}
echo '<section>';
	echo '<div class="scroll">';
		echo '<div class="inner">';
			echo '<div class="text textWrap">';
				echo $item->text()->kirbytext();
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