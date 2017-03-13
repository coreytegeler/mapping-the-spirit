<?php
if(!r::ajax()) go(url('error'));
header('Content-type: application/json; charset=utf-8');
$itemSlug = $_GET['item'];
$storySlug = $_GET['story'];
$index = $_GET['index'];
$footer = $_GET['footer'];
$story = $pages->find( 'stories' )->children()->find( $storySlug );
if( !$story ) {return;}
$item = $story->children()->find( $itemSlug );
if( !$item ) {return;}
if( isset( $footer ) ) {
	$size = 'small';
} else {
	$size = 'medium';
}
snippet( 'item', array( 'item' => $item, 'story' => $story, 'index' => $index, 'size' => $size ) );
?>