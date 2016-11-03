<header>
  <div class="inner">
    <div class="title">
      <span>
        <a href="<?php echo $site->url() ?>">
          Mapping The Spirit
        </a>
      </span>
    </div>
    <div class="tools">
      <div class="tool close">×</div>
    </div>
    <div class="subtitle">
      <span>
        <?php
        if( isset( $subtitle ) ) {
          echo $subtitle;
        } else if( isset( $story ) ) {
          echo $story->title();
        } else {
          echo $page->title();
        }
        ?>
      </span>
    </div>
  </div>
</header>