<header>
  <div class="inner">
    <div class="row primary">
      <div class="title">
        <span>
          <a href="<?php echo $site->url() ?>">
            Mapping The Spirit
          </a>
        </span>
      </div>
      <div class="pageTitle">
        <span>
          <?php
          if( isset( $pageTitle ) ) {
            echo $pageTitle;
          } else if( isset( $story ) ) {
            echo $story->title();
          } else {
            echo $page->title();
          }
          ?>
        </span>
      </div>
    </div>
    <div class="row secondary">
      <div class="title">
        <span>
          <?php
          if( isset( $item ) ) {
            echo '<a href="' . $item->url() . '">' . $item->title() . '</a>';
          } else {
            echo '<a></a>';
          }
          ?>
        </span>
      </div>
      <div class="tools">
        <div class="tool close">×</div>
      </div>
    </div>
  </div>
</header>