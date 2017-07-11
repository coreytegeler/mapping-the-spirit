<?php
$published = $item->date( 'j M. Y', 'published' );
$today = date( 'j M. Y' );
$url = '&lt;<a href="' . $item->url() . '">' . $item->url() . '</a>&gt;';
$citation = 'Rasheed, Kameelah Janan. "' . $item->title() . '." <em>Mapping The Spirit</em>, Kameelah Janan Rasheed, ' . ( $published ? $published . ',' : '' ) . ' Web. ' . ( $today ? $today . '.' : '' ) . ' ';
$copy = htmlspecialchars( strip_tags( $citation ) . '<' . $item->url() . '>' );
$citation .= $url;
echo '<div class="block medium footer">';
	echo '<div class="cell label">';
  	echo 'Cite this page';
	echo '</div>';
	
	echo '<div class="cell copy cite" data-clipboard-text="' . $copy . '">';
  	echo 'Copy citation';
	echo '</div>';
	echo '<div class="citation">';
		echo $citation;
	echo '</div>';
echo '</div>';
?>