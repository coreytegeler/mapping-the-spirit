<?php
if( isset( $item ) ) {
	$type = $item->intendedTemplate();
	$size = $item->size();
	if( $size->empty() ) {
		$size = 'small';
	}
	if( $type == 'quote' ) {
		$display = 'text';
	} else {
		$display = $item->display();
	}
	// $imgCheck = $display == 'image' && $item->getThumb( null );
	// $textCheck = $display == 'text' && $item->excerpt();
	if($index % 2 == 0) {
		$rotate = mt_rand( -25, 0 )/100;
		$shift = mt_rand( -200, -100 )/100;
	} else {
		$rotate = mt_rand( 0, 25 )/100;
		$shift = mt_rand( 100, 200 )/100;
	}
	$thumb = $item->getThumb( 'small' );
	if( $display == 'image' && !$item->getThumb( null ) ) {
		$display = 'text';
	}
	$attrs = ' ' . $type . ' ' . $size . ' ' . $display . ' ' . $item->textSize() . '" data-shift="' . $shift . '" data-rotate="' . $rotate . '" data-story="' . $story->slug() . '" data-slug="' . $item->slug() . '" data-type="' . $type . '" data-url="' . $item->url() . '" data-title="' . $item->title() . '" data-index="' . $index . '" data-thumb="' . ( $thumb ? $thumb->url() : '' ) . '" href="' . $item->url() . '"';
}
// if( $imgCheck || $textCheck ) {
echo '<a class="click item rotate shift droppable' . ( $attrs ? $attrs : '' ) . '>';
	echo '<div class="inner" style="color:' . $color . '">';
		if( isset( $item ) ) {
		  snippet( 'items/' . $type, array( 'item' => $item, 'color' => $color, 'display' => $display ) );
		}
	echo '</div>';
	echo '<div class="shadow"></div>';
echo '</a>';
?>