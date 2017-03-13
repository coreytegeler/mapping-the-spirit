<?php
$field_notes = $page->children()->visible();
$blocks = $page->blocks()->toStructure();
snippet('head');
echo '<main>';
	echo '<section id="field-notes" class="rows">';
		echo '<div class="inner">';
			echo '<h2 class="title">Field Notes</h2>';
			if( !$page->text()->empty() ) {
				echo '<div class="about">';
					echo $page->text()->kirbytext();
				echo '</div>';
			}
		echo '</div>';
		echo '<div class="rowrap">';
			$index = 0;
			foreach( $field_notes as $field_note ) {
				$index++;
				if( $index % 2 == 0 ) {
					$sign = -1;
				} else {
					$sign = 1;
				}
				$url = $field_note->url();
				$thumb = $field_note->getThumb( 'large' );
				$rotate = mt_rand( -25, 10 )/100;
				$shift = mt_rand( -50, -25 )/100 * $sign;
		  	echo '<div class="row field-note ' . ( $index % 2 == 0 ? 'odd ' : 'even ' ) . ( !$thumb ? ' no-thumb' : '' ) . '">';
			  	echo '<div class="wrap">';
			  	 if( $thumb ) {
				  		echo '<div class="image">';
				  			echo '<a href="' . $url . '" class="img rotate shift" style="background-color:' . $field_note->color() . '" data-shift="' . $shift . '" data-rotate="' . $rotate .'" data-index="' . $index . '">';
				  				if( $thumb ) {
								  	echo '<img src="' . $thumb->url() . '"/>';
								  }
							  echo '</a>';
						  echo '</div>';
						}
					  $rotate = mt_rand( -25, 10 )/100;
						$shift = mt_rand( -50, -25 )/100 * $sign;
		  			echo '<a href="' . $url . '" class="title">';
		  				echo '<h2 class="shift rotate" data-shift="' . $shift . '" data-rotate="' . $rotate .'" data-index="' . $index/2 . '">' .  $field_note->title() . '</h2>';
		  			echo '</a>';
				  echo '</div>';
		  	echo '</div>';
		  }
		 echo '</div>';
	echo '</section>';
	snippet('footer');
echo '</main>';
?>