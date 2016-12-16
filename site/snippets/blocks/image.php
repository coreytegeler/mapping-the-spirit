<?php
if( $block->image() ) {
	echo '<img src="' . $page->image( $block->image() )->url() . '"/>';
}
?>