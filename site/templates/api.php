<?php
if(!r::ajax()) go(url('error'));
header('Content-type: application/json; charset=utf-8');
$itemSlug = $_GET['item'];
$storySlug = $_GET['story'];
$story = $pages->find( 'stories' )->children()->find( $storySlug );
$color = $story->color();
if( !$story ) {return;}
$item = $story->children()->find( $itemSlug );
if( $item ) {
	$type = $item->intendedTemplate();
	if( $type == 'quote' ) {
		$display = 'text';
	} else {
		$display = $item->display();
	}

	if( $display == 'image' ) {
		$thumb = $item->getThumb( true );
		$content = $thumb;
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