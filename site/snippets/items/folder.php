<?php
$caption = $item->caption();
$thumb = $item->thumb();
if( $thumb = $item->file( $thumb ) ) {
	echo '<div class="image' . ( $item->bw() == 'true' ? ' bw' : '' ) . '">';
		echo '<img src="' . $thumb->url() . '"/>';
	echo '</div>';
}
?>