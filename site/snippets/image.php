<?php
if( $item ) {
	if( !isset( $image ) ) {
		$image = $item->image();
	}
	if( !isset( $index ) ) {
		$index = mt_rand( 1, 2 );
	}
	if( $index % 2 == 0 ) {
		$rotate = mt_rand( -25, 0 )/100;
		$shift = mt_rand( -200, -100 )/100;
	} else {
		$rotate = mt_rand( 0, 25 )/100;
		$shift = mt_rand( 100, 200 )/100;
	}
	$full = $image->url();
	if( $detail = $image->detail() ) {
		if( $page->image( $detail ) ) {
			$full = $page->image( $detail )->url();
		}
	}
	if( $image ) {
		echo '<div class="item">';
			echo '<img class="rotate shift load" data-full="' . $full . '" data-shift="' . $shift . '" data-rotate="' . $rotate . '" data-src="' . $image->resize(1500, 1500, 100)->url() . '" data-width="' . $image->width() . '" data-height="' . $image->height() . '"/>';
		echo '</div>';
		if( !isset( $noText ) ) {
			echo '<div class="text-wrap">';
				if( $image->title() && !$image->title()->empty() ) {
					$title = $image->title();
				} else if( $item->intendedTemplate() == 'object' ) {
					$title = $item->title();
				}
				if( $title && !$title->empty() ) {
					echo '<div class="title">';
				  	echo '<span>' . $title . '</span>';
				  echo '</div>';
				}
				snippet( 'meta', array( 'item' => $item ) );
			echo '</div>';
		}
	}
}
?>