<?php
$thumb = $item->thumb();
$excerpt = $item->excerpt();
$bw = $item->bw();
if( $thumb = $item->file( $thumb ) ) {
	$thumb = $thumb->resize(800, 800, 100);
	echo '<div class="image' . ( $bw == 'true' ? ' bw' : '' ) . '" style="' . ( $bw == 'true' ? 'background-color:' . $color : '' ) . '">';
		echo '<img src="' . $thumb->url() . '"/>';
	echo '</div>';
} else {
	if( $excerpt->empty() ) {	
		$excerpt = str::short( $item->text()->kirbytext(), 200, '...' );
	}
	echo '<div class="text">';
		echo strip_tags( $excerpt );
	echo '</div>';
}
?>