<?php
echo '<div class="text">';
	echo $block->text()->kirbytext();
echo '</div>';
echo '<div class="attribution">';
	echo $block->attribution();
echo '</div>';
snippet( 'meta', array( 'item' => $block ) );
?>