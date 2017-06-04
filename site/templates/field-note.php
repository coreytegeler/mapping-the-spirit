<?php
$field_notes = page( 'field-notes' )->children()->visible();
$blocks = $page->blocks()->toStructure();
snippet('head');
echo '<main>';
	echo '<section id="field-note">';
		echo '<div class="center">';
			echo '<div class="blocks text-wrap">';
		  	echo '<div class="block text">';
		  		echo '<h2 class="title">' . $page->title() . '</h2>';
	  		echo '</div>';
	  		foreach($blocks as $index => $block) {
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
			echo '</div>';
  	echo '</div>';
	echo '</section>';
	snippet('footer');
echo '</main>';
?>