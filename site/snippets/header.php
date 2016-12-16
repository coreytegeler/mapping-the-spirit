<header>
  <div class="inner">
    <div class="row">
      <div class="trail">
        <?php
        echo '<span class="item title ' . (isset( $item ) ? 'ready show':'') . '">';
          echo '<a href="#" class="closeSingle">' . (isset( $item ) ? $item->title():'') . '</a>';
        echo '</span>';
        echo '<span class="story title ' . (isset( $story ) ? 'ready show':'') . '">';
          echo '<a href="' . (isset( $story ) ? $story->url():'') . '">' . (isset( $story ) ? $story->title():'') . '</a>';
        echo '</span>';
        echo '<span class="site title show ready">';
          echo '<a href="' . $site->url() . '">' . $site->title() . '</a>';
        echo '</span>';
        ?>
      </div>
      <div class="links">
        <?php
        $aid = page( 'aid' );
        if( $aid ) {
          echo '<a href="' . $aid->url() . '">Finding Aid</a>';
        }
        $about = page( 'about' );
        if( $about ) {
          echo '<a href="' . $about->url() . '">About</a>';
        }
        ?>
      </div>
    </div>
  </div>
</header>