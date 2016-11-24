<header>
  <div class="inner">
    <div class="row primary">
      <div class="trail">
        <?php
        echo '<span class="site title show">';
          echo '<a href="' . $site->url() . '">' . $site->title() . '</a>';
        echo '</span>';
        echo '<span class="story title ' . (isset( $story ) ? 'show':'') . '">';
          echo '<a href="' . (isset( $story ) ? $story->url():'') . '">' . (isset( $story ) ? $story->title():'') . '</a>';
        echo '</span>';
        echo '<span class="item title ' . (isset( $item ) ? 'show':'') . '">';
          echo '<a href="' . (isset( $item ) ? $item->url():'') . '">' . (isset( $item ) ? $item->title():'') . '</a>';
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
    <!-- <div class="row secondary">
      <div class="title">
        <span>
          <?#php if( isset( $item ) ) {
            #echo '<a href="' . $item->url() . '">' . $item->title() . '</a>';
          # } else {
            # echo '<a></a>';
          #} ?>
        </span>
      </div>
      <div class="tools">
        <div class="tool close">×</div>
        <div class="tool add">+</div>
      </div>
    </div> -->
  </div>
</header>