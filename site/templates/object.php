<?php
if(!kirby()->request()->ajax()) {
	$story = $page->parent();
	snippet( 'header', array( 'bodyClass' => array ( 'looking', 'story' ), 'story' => $story ) );
	echo '<main>';
	snippet( 'table', array( 'story' => $story ) );
	snippet( 'footnotes' );
	echo '<div id="single" class="show loaded object" data-item="' . $page->slug() . '">';
}
$image = $page->images()->first();
echo '<section>';
	echo '<div class="scroll">';
		echo '<div class="inner">';
			echo '<div class="vert">';
				echo '<img src="' . $image->url() . '"/>';
				echo '<div class="caption text">';
					echo $page->caption()->kirbytext();
				echo '</div>';
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