<?php
if(!r::ajax()) go(url('error'));
header('Content-type: application/json; charset=utf-8');

if( isset( $_GET['story'] ) ) {
	$storySlug = $_GET['story'];	
	$story = $pages->find( 'stories' )->children()->find( $storySlug );
	if( !$story ) {return;}
} else { return; }

if( isset( $_GET['item'] ) ) {
	$itemSlug = $_GET['item'];
	$item = $story->children()->find( $itemSlug );
	if( !$item ) {return;}
} else { return; }

if( isset( $_GET['index'] ) ) {
	$index = $_GET['index'];	
} else {
	$index = 0;
}
if( isset( $_GET['footer'] ) ) {
	$footer = $_GET['footer'];	
	$size = 'small';
} else {
	$size = 'medium';
}
snippet( 'item', array( 'item' => $item, 'story' => $story, 'index' => $index, 'size' => $size ) );
?>