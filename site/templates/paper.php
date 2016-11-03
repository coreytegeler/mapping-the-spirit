<?php
if(!kirby()->request()->ajax()) {
	$story = $page->parent();
	snippet( 'head', array( 'bodyClass' => array ( 'looking', 'story' ), 'story' => $story ) );
	echo '<main>';
	snippet( 'table', array( 'story' => $story ) );
	snippet( 'footnotes' );
	echo '<div id="single" class="show paper open" data-item="' . $page->slug() . '">';
}
echo '<section>';
	echo '<div class="scroll">';
		echo '<div class="inner">';
			echo $page->text()->kirbytext();
		echo '</div>';
	echo '</div>';
echo '</section>';
if(!kirby()->request()->ajax()) {
	echo '</div>';
	echo '</main>';
	snippet('footer');
}
?>