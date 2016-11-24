<?php
$caption = $item->caption();
$bw = $item->bw();
if( $thumb = $item->images()->first() ) {
	echo '<div class="image' . ( $bw == 'true' ? ' bw' : '' ) . '" style="' . ( $bw == 'true' ? 'background-color:' . $color : '' ) . '">';
		echo '<img src="' . $thumb->url() . '"/>';
	echo '</div>';
}
?>