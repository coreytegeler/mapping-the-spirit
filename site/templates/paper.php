<?php
$item = $page;
if(!kirby()->request()->ajax()) {
	$story = $item->parent();
	snippet( 'head', array( 
		'bodyClass' => array ( 'looking', 'story' ),
		'story' => $story,
		'item' => $item
	) );
	echo '<main>';
	snippet( 'table', array( 'story' => $story ) );
	snippet( 'footnotes' );
	echo '<div id="single" class="show paper open" data-item="' . $item->slug() . '" data-title="' . $item->title() . '" data-url="' . $item->url() . '" data-type="paper">';
} else {
	echo '<div class="data" data-item="' . $item->slug() . '" data-title="' . $item->title() . '" data-url="' . $item->url() . '" data-type="paper"></div>';
}
echo '<section>';
	echo '<div class="closeSingle"></div>';
	echo '<div class="scroll">';
		echo '<div class="inner">';
			echo '<div class="blocks textWrap">';
				echo '<div class="block medium">';
					snippet( 'meta', array( 'item' => $item ) );
				echo '</div>';
				foreach($page->blocks()->toStructure() as $block) {
					$size = $block->size();
					if ( !$size || $size == '' ) {
						$size = 'medium';
					}
					echo '<div class="block ' . $block->_fieldset() . ' ' . $size . '">';
					  snippet( 'blocks/' . $block->_fieldset(), array( 'block' => $block ) );
					echo '</div>';
				}
			echo '</div>';		
		echo '</div>';
	echo '</div>';
echo '</section>';
if(!kirby()->request()->ajax()) {
	echo '</div>';
	echo '</main>';
	snippet('footer');
}
?>