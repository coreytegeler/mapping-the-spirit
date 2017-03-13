<?php
$bw = $item->bw();
$excerpt = $item->excerpt()->kirbytext();
if( $display == 'image' ) {	
	$thumb = $item->getThumb( $size );
	echo '<div class="image' . ( $bw == 'true' ? ' bw' : '' ) . '" style="' . ( $bw == 'true' ? 'background-color:' . $color : '' ) . '">';
		echo '<img class="load" data-width="' . $thumb->width() . '" data-height="' . $thumb->height() . '" data-src="' . $thumb->url() . '"/>';
	echo '</div>';
} else {
	if( $excerpt->empty() ) {
		$excerpt = $item->title();
	}
	echo '<div class="text">';
		echo strip_tags( $excerpt );
	echo '</div>';
	echo '<div class="shadow"></div>';
}
?>