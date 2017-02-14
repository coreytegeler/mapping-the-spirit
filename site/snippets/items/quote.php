<?php
$text = $item->text();
echo '<div class="text">';
	echo '<p>' . strip_tags( $text ) . '</p>';
echo '</div>';
echo '<div class="shadow"></div>';
?>