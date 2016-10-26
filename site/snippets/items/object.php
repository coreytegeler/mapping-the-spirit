<?php
$caption = $item->caption();
if( $thumb = $item->images()->first() ) {
	echo '<div class="image' . ( $item->bw() == 'true' ? ' bw' : '' ) . '">';
		echo '<img src="' . $thumb->url() . '"/>';
	echo '</div>';
}
?>