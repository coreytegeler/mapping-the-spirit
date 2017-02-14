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
	echo '<div class="single left open folder" data-slug="' . $item->slug() . '" data-title="' . $item->title() . '" data-url="' . $item->url() . '" data-type="folder">';
} else {
	echo '<div class="data" data-slug="' . $item->slug() . '" data-title="' . $item->title() . '" data-url="' . $item->url() . '" data-type="folder"></div>';
}
snippet( 'buttons' );
echo '<div class="sections">';
	echo '<section class="left">';
		echo '<div class="handle ui-resizable-handle ui-resizable-e"><div class="line"></div></div>';
		echo '<div class="scroll">';
			echo '<div class="inner">';
				echo '<div class="blocks text-wrap">';
					echo '<div class="block medium header">';
						echo '<h2 class="title">' . $item->title() . '</h2>';
						snippet( 'meta', array( 'item' => $item ) );
					echo '</div>';
					if( !$blocks->empty() ) {
						$index = 0;
						foreach($blocks->toStructure() as $block) {
							$size = $block->size();
							if ( !$size || $size == '' ) {
								$size = 'medium';
							}
							echo '<div class="block ' . $block->_fieldset() . ' ' . $size . '">';
							  snippet( 'blocks/' . $block->_fieldset(), array( 'block' => $block, 'index' => $index ) );
							echo '</div>';
							$index++;
						}
					}
				echo '</div>';
			echo '</div>';
		echo '</div>';
	echo '</section>';
	echo '<section class="right">';
		echo '<div class="scroll">';
			echo '<div class="inner">';
				echo '<div class="blocks">';
					echo '<div class="blocksWrap">';
						$images = $item->images()->sortBy('sort', 'asc')->filterBy( 'right', '==', 'true' );
						foreach( $images as $index => $image ) {
							echo '<div class="block image" data-index="' . $index . '">';
								echo '<div class="blockWrap">';
									snippet( 'image', array( 'item' => $image, 'image' => $image, 'index' => $index ) );
								echo '</div>';
							echo '</div>';
						}
					echo '</div>';
				echo '</div>';
			echo '</div>';
		echo '</div>';
	echo '</section>';
echo '</div>';
snippet( 'pagination', array( 'item' => $item ) );
if(!kirby()->request()->ajax()) {
	echo '</div>';
	echo '</main>';
	echo '</body>';
	echo '</html>';
}
?>