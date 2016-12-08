<?php
$caption = $item->caption();
$thumb = $item->thumb();
$bw = $item->bw();
if( $thumb = $item->file( $thumb ) ) {
	$thumb = $thumb->resize(800, 800, 100);
	echo '<div class="image' . ( $bw == 'true' ? ' bw' : '' ) . '" style="' . ( $bw == 'true' ? 'background-color:' . $color : '' ) . '">';
		echo '<img src="' . $thumb->url() . '"/>';
	echo '</div>';
}
?>