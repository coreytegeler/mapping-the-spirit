<header>
  <div class="inner">
    <div class="row">
      <div class="trail">
        <?php
        echo '<span class="item title ' . (isset( $item ) ? 'ready show':'') . '">';
          echo '<a href="' . (isset( $item ) ? $item->url():'') . '">' . (isset( $item ) ? $item->title():'') . '</a>';
        echo '</span>';
        echo '<span class="story title ' . (isset( $story ) ? 'ready show':'') . '">';
          echo '<a href="' . (isset( $story ) ? $story->url():'') . '" class="close-singles">' . (isset( $story ) ? $story->title():'') . '</a>';
        echo '</span>';
        echo '<span class="site title show ready">';
          echo '<a href="' . $site->url() . '">' . $site->title() . '</a>';
        echo '</span>';
        ?>
      </div>
      <div class="links">
        <?php
        if( $about = page( 'about' ) ) {
          echo '<a href="' . $about->url() . '">About</a>';
        }
        if( $stories = page( 'stories' ) ) {
          if( sizeof( $stories->children()->visible() ) ) {
            echo '<a href="' . $stories->url() . '">Stories</a>';
          }
        }
        if( $field_notes = page( 'field-notes' ) ) {
          if( sizeof( $field_notes->children()->visible() ) ) {
            echo '<a href="' . $field_notes->url() . '">Field Notes</a>';
          }
        }
        if( $aid = page( 'aid' ) ) {
          echo '<a href="' . $aid->url() . '">Finding Aid</a>';
        }
        ?>
      </div>
    </div>
  </div>
  <div class="close-singles"></div>
</header>