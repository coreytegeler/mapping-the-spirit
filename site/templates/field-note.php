<?php
$field_notes = page( 'field-notes' )->children()->visible();
$blocks = $page->blocks()->toStructure();
snippet('head');
echo '<main>';
	echo '<section id="field-note">';
		echo '<div class="inner">';
			echo '<div class="blocks text-wrap">';
		  	echo '<div class="block text">';
		  		echo '<h2 class="title">' . $page->title() . '</h2>';
	  		echo '</div>';
	  		foreach($blocks as $block) {
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
	echo '</section>';
	snippet('footer');
echo '</main>';
?>