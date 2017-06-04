<?php
echo '<div class="buttons">';
	echo '<div class="button collect add">';
		echo '<div class="pseudo"></div>';
		echo '<div class="tooltip">';
			echo '<div class="add">Add item to your collection</div>';
			echo '<div class="remove">Remove item from your collection</div>';
		echo '</div>';
	echo '</div>';
	$facebook = 'https://www.facebook.com/sharer/sharer.php?sdk=joey&u=' . urlencode( $page->url() );
	echo '<a href="' . $facebook . '" target="_blank" class="button facebook"></a>';
	$twitter = 'https://twitter.com/share?url=' . urlencode( $page->url() ) . '&text=' . urlencode( $page->title() );
	echo '<a href="' . $twitter . '" target="_blank" class="button twitter"></a>';
	echo '<div class="button close-single"></div>';
echo '</div>';
?>

