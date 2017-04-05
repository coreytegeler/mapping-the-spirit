<?php
$item = $page;
$blocks = $item->blocks();
if( !kirby()->request()->ajax() ) {
	$story = $item->parent();
	snippet( 'head', array( 
		'bodyClass' => array ( 'looking', 'story' ),
		'story' => $story,
		'item' => $item
	) );
	echo '<main data-title="' . $story->title() . '">';
	snippet( 'table', array( 'story' => $story ) );
	snippet( 'footnotes' );
	echo '<div class="single stack open" data-slug="' . $item->slug() . '" data-title="' . $item->title() . '" data-url="' . $item->url() . '" data-type="stack">';
} else {
	echo '<div class="data" data-slug="' . $item->slug() . '" data-title="' . $item->title() . '" data-url="' . $item->url() . '" data-type="stack"></div>';
}
echo '<section>';
	snippet( 'buttons' );
	echo '<div class="scroll">';
		echo '<div class="inner">';
			echo '<div class="blocks text-wrap">';
				echo '<div class="block ' . ( $blocks->toStructure() && $blocks->toStructure()->first() ? $blocks->toStructure()->first()->size() : '' ) . ' header">';
					echo '<h2 class="title">' . $item->title() . '</h2>';
					snippet( 'meta', array( 'item' => $item ) );
				echo '</div>';
				if( !$blocks->empty() ) {
					foreach($blocks->toStructure() as $index => $block) {
						$size = $block->size();
						$textSize = $block->textSize();
						$align = $block->align();
						$type = $block->_fieldset();
						if ( !$size || $size == '' ) {
							$size = 'medium';
						}
						echo '<div class="block ' . $type . ' ' . $size . ' ' . $textSize . ' ' . $align . '">';
						  snippet( 'blocks/' . $type, array( 'block' => $block ) );
						echo '</div>';
					}
				}
			echo '</div>';		
		echo '</div>';
	echo '</div>';
echo '</section>';
snippet( 'pagination', array( 'item' => $item ) );
if(!kirby()->request()->ajax()) {
	echo '</div>';
	echo '</main>';
	echo '</body>';
	echo '</html>';
}
?>