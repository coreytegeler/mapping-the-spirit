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
	echo '<div id="single" class="left show open folder" data-item="' . $item->slug() . '" data-title="' . $item->title() . '" data-url="' . $item->url() . '" data-type="folder">';
} else {
	echo '<div class="data" data-item="' . $item->slug() . '" data-title="' . $item->title() . '" data-url="' . $item->url() . '" data-type="folder"></div>';
}
$images = $item->images();
echo '<section id="left">';
	echo '<div id="handle" class="ui-resizable-handle ui-resizable-e"><div class="line"></div></div>';
	echo '<div class="scroll">';
		echo '<div class="inner">';
			echo '<div class="blocks">';
				echo '<div class="blocksWrap">';
					foreach( $images->filterBy( 'thumb', '!=', 'false' ) as $index => $image ) {
						echo '<div class="block image" data-index="' . $index . '">';
							echo '<div class="blockWrap">';
								echo '<img src="' . $image->resize(1500, 1500, 100)->url() . '"/>';
								if( !$image->caption()->empty() ) {
									echo '<div class="text">';
										echo '<div class="caption">';
											echo $image->caption()->kirbytext();
										echo '</div>';
									echo '</div>';
								}
							echo '</div>';
						echo '</div>';
					}
				echo '</div>';
			echo '</div>';
		echo '</div>';
	echo '</div>';
echo '</section>';
echo '<section id="right">';
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