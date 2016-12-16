<?php
if(!r::ajax()) go(url('error'));
header('Content-type: application/json; charset=utf-8');
$itemSlug = $_GET['item'];
$storySlug = $_GET['story'];
$story = $pages->find( 'stories' )->children()->find( $storySlug );
if( !$story ) {return;}
$item = $story->children()->find( $itemSlug );
if( $item ) {
	$type = $item->intendedTemplate();
	$display = $item->display();

	if( $type == 'quote' ) {
		$display = 'text';
	} else if( $type == 'object' ) {
		$display = 'image';
	} else {
		$display = $item->display();
	}

	if( $display == 'image' ) {
		if( $item->file( $item->thumb() ) ) {
			$thumb = $item->file( $item->thumb() );
		} else {
			$thumb = $item->images()->first();
		}
		if( $thumb ) {
			$thumb = $thumb->resize(800, 800, 100);
			$content = $thumb->url();
		}
	} else {
		if( $type == 'quote' ) {
			$content = strip_tags( $item->text() );
		} else {
			$excerpt = $item->excerpt();
			if( $excerpt->empty() ) {	
				$excerpt = str::short( $item->text()->kirbytext(), 200, '...' );
			}
			$content = strip_tags( $excerpt );
		}
	}

	$json = (object) array(
		'title' => (string)$item->title(),
		'slug' => (string)$item->slug(),
	  'url' => (string)$item->url(),
	  'type' => (string)$type,
	  'display' => (string)$display,
	  'content' => (string)$content
	);

	

}
echo json_encode($json);
?>