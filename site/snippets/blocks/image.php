<?php
$image = $page->image( $block->image() );
if( !isset( $index ) ) {
	$index = mt_rand( 1, 2 );
}
snippet( 'image', array( 'item' => $image, 'image' => $image, 'index' => $index ) );
?>