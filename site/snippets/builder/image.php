<?php
$image = $data->image();
if ( !$image->empty() ) {
	$image = $page->image( $image );
	if( $image ) {
		echo '<img style="max-width:100%;display:table;margin:auto;" src="' . $image->url() . '"/>';
	}
}
?>