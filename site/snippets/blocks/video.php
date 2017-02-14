<?php
echo '<div class="videoWrap">';
	if( $block->source() == 'vimeo' ) {
		$root = 'player.vimeo.com/video/';
	} else if( $block->source() == 'youtube' ) {
		$root = 'www.youtube.com/embed/';
	}
	echo '<iframe src="https://' . $root . $block->videoid() . '" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
echo '</div>';
echo '<div class="text-wrap">';
	if( $title = $block->title() ) {
		echo '<div class="title">';
	  	echo '<span>' . $title . '</span>';
	  echo '</div>';
	}
	snippet( 'meta', array( 'item' => $block ) );
echo '</div>';
?>