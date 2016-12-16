<?php
if ( !$data->image()->empty() ) {
	echo '<img style="max-width:100%;display:table;margin:auto;" src="' . $page->image( $data->image() )->url() . '"/>';
}
?>