<?php 
if( !isset( $card ) ) {
	echo '<footer>';
	if( $page->slug() !== 'collection' ) {
  	snippet( 'collection' );
  }
}
$about = page( 'about' );
echo '<div class="inner">';
	$events = $about->events()->toStructure();
  if( sizeof( $events ) ) {
		echo '<div class="column events">';
			echo '<ul>';
				echo '<li><h3>Events</h3></li>';
				foreach( $events as $item ) {
					// echo strtotime( '+10 day', $item->date() ) . '   ' . time();
					$status = ( strtotime( '+1 day', $item->date() ) < time() ? 'old' : 'new' );
					$title = $item->title();
					$link = $item->link();
					$date = $item->date( 'l, F j' );
					$location = $item->location();
					echo '<li class="event ' . $status . '">';
						echo '<div class="label">';
							if( $date ) {
								echo '<span class="date">' . $date . '</span>';
							}
							if( $location->isNotEmpty() ) {
								echo '<span class="location">' . $location . '</span>';
							}
						echo '</div>';
						echo '<div class="name">';
							if( $link->isNotEmpty() ) {
								echo '<a href="' . $link . '" target="_blank">' . $title . '</a>';
							} else {
								echo $title;
							}
						echo '</div>';
					echo '</li>';
				}
			echo '</ul>';
		echo '</div>';
	}
	echo '<div class="column map">';
		$credits = $about->credits()->toStructure();
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
		$stories = $stories->children()->visible();
		if( sizeof( $stories ) ) {
		  echo '<div class="column stories">';
				echo '<ul>';
					echo '<li><h3>Stories</h3></li>';
	  			foreach( $stories->limit( 5 ) as $story ) {
		  			echo '<li><a href="' . $story->url() . '" style="color:' . $story->color() . '" class="story">' . $story->title() . '</a></li>';
		  		}
		  	echo '</ul>';
		  echo '</div>';
	  }
	}
  if( $field_notes = page( 'field-notes' ) ) {
		$field_notes = $field_notes->children()->visible();
		if( sizeof( $field_notes ) ) {
		  echo '<div class="column field-notes">';
				echo '<ul>';
					echo '<li><h3>Field Notes</h3></li>';
	  			foreach( $field_notes->sortBy( 'published', 'desc' )->limit( 5 ) as $field_note ) {
		  			echo '<li><a href="' . $field_note->url() . '">' . $field_note->title() . '</a></li>';
		  		}
		  	echo '</ul>';
		  echo '</div>';
		}
	}
	echo '<div class="column credits">';
		$credits = $about->credits()->toStructure();
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