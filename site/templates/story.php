<?php
snippet('head');
if( isset( $story ) ) {
	$story = $page->find( 'story' )->children()->find( $story );
} else {
	$story = $page;
}
echo '<main data-title="' . $story->title() . '">';
	snippet( 'table', array( 'story' => $story ) );
echo '</main>';
echo '</body>';
echo '</html>';