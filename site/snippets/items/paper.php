<?php
$bw = $item->bw();
$excerpt = $item->excerpt();
if( $item->display() == 'image' ) {
	$thumb = $item->getThumb();
	echo '<div class="image' . ( $bw == 'true' ? ' bw' : '' ) . '" style="' . ( $bw == 'true' ? 'background-color:' . $color : '' ) . '">';
		echo '<img src="' . $thumb->url() . '"/>';
	echo '</div>';
} else {
	echo '<div class="text">';
		echo strip_tags( $excerpt );
	echo '</div>';
}
?>