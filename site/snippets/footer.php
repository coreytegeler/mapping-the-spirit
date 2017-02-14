<?php 
if( !isset( $card ) ) {
	echo '<footer>';
	if( $page->slug() !== 'collection' ) {
  	snippet( 'collection' );
  }
}
echo '<div class="inner">';
	// echo '<em>' . page( 'home' )->brief()->kirbytext() . '</em>';
	echo '<div class="column map">';
		$credits = page( 'about' )->credits()->toStructure();
		echo '<ul>';
			echo '<li><h3>Site Map</h3></li>';
			if( $home = page( 'home' ) ) {
        echo '<li><a href="' . $home->url() . '">Home</a></li>';
      }
      if( $about = page( 'about' ) ) {
        echo '<li><a href="' . $about->url() . '">About</a></li>';
      }
			if( $stories = page( 'stories' ) ) {
        echo '<li><a href="' . $stories->url() . '">Stories</a></li>';
      }
      if( $field_notes = page( 'field-notes' ) ) {
        if( sizeof( $field_notes->children()->visible() ) ) {
          echo '<li><a href="' . $field_notes->url() . '">Field Notes</a></li>';
        }
      }
      if( $aid = page( 'aid' ) ) {
        echo '<li><a href="' . $aid->url() . '">Finding Aid</a></li>';
      }
      if( $collection = page( 'collection' ) ) {
        echo '<li><a href="' . $collection->url() . '">Collection</a></li>';
      }
  	echo '</ul>';
  echo '</div>';
  if( $stories = page( 'stories' ) ) {
		$stories = $stories->children()->visible()->limit( 5 );
		if( sizeof( $stories ) ) {
		  echo '<div class="column stories">';
				echo '<ul>';
					echo '<li><h3>Stories</h3></li>';
	  			foreach( $stories as $story ) {
		  			echo '<li><a href="' . $story->url() . '" style="color:' . $story->color() . '" class="story">' . $story->title() . '</a></li>';
		  		}
		  	echo '</ul>';
		  echo '</div>';
	  }
	}
  if( $field_notes = page( 'field-notes' ) ) {
		$field_notes = $field_notes->children()->visible()->limit( 5 );
		if( sizeof( $field_notes ) ) {
		  echo '<div class="column field-notes">';
				echo '<ul>';
					echo '<li><h3>Field Notes</h3></li>';
	  			foreach( $field_notes as $field_note ) {
		  			echo '<li><a href="' . $field_note->url() . '">' . $field_note->title() . '</a></li>';
		  		}
		  	echo '</ul>';
		  echo '</div>';
		}
	}
	echo '<div class="column credits">';
		$credits = page( 'about' )->credits()->toStructure();
		echo '<ul>';
			echo '<li><h3>Credits</h3></li>';
			foreach( $credits as $credit ) {
  			echo '<li class="credit">';
  				echo '<div class="label">' . $credit->label() . '</div>';
  				echo '<div class="name">';
	  				if( $link = $credit->link() ) {
	  					echo '<a href="' . $link . '" target="_blank">' . $credit->name() . '</a>';
	  				} else {
	  					echo $credit->name();
	  				}
	  			echo '</div>';
  			echo '</li>';
  		}
  	echo '</ul>';
  echo '</div>';
 echo '</div>';
if( !isset( $card ) ) {
	echo '</footer>';
}
?>