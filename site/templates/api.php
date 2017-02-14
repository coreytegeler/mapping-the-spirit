<?php
if(!r::ajax()) go(url('error'));
header('Content-type: application/json; charset=utf-8');
$itemSlug = $_GET['item'];
$storySlug = $_GET['story'];
$footer = $_GET['footer'];
$story = $pages->find( 'stories' )->children()->find( $storySlug );
if( !$story ) {return;}
$color = $story->color();
$item = $story->children()->find( $itemSlug );
if( $item ) {
	$type = $item->intendedTemplate();
	if( $type == 'quote' ) {
		$display = 'text';
	} else {
		$display = $item->display();
	}

	if( $display == 'image' ) {
		if( $footer == 'true' ) {
			$thumb = $item->getThumb( 'small' );
		} else {
			$thumb = $item->getThumb( 'medium' );
		}
		if( $thumb ) {
			$content = $thumb->url();
		}
	} else {
		if( $type == 'quote' ) {
			$content = strip_tags( $item->text() );
		} else {
			$excerpt = $item->excerpt();
			$content = strip_tags( $excerpt );
		}
	}
	if( !$content ) {
		return;
	}


	$json = (object) array(
		'title' => (string)$item->title(),
		'slug' => (string)$item->slug(),
	  'url' => (string)$item->url(),
	  'type' => (string)$type,
	  'display' => (string)$display,
	  'content' => (string)$content,
	  'color' => (string)$color,
	  'bw' => (string)$item->bw()
	);
	echo json_encode($json);
} else {
	return;
}

?>