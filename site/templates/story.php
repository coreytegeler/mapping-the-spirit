<?php
snippet('header');
echo '<main>';
	if( isset( $story ) ) {
		$story = $page->find( 'stories' )->children()->find( $story );
	} else {
		$story = $page;
		echo '<div id="single"></div>';
	}
	snippet( 'table', array( 'story' => $story ) );
echo '</main>';
snippet('footer');