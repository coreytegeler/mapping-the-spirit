<?php
$caption = $item->caption();
$thumb = $item->thumb();
$bw = $item->bw();
if( $thumb = $item->file( $thumb ) ) {
	echo '<div class="image' . ( $bw == 'true' ? ' bw' : '' ) . '" style="' . ( $bw == 'true' ? 'background-color:' . $color : '' ) . '">';
		echo '<img src="' . $thumb->url() . '"/>';
	echo '</div>';
}
?>