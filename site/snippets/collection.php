<?php
$items = $page->children();
echo '<div id="collection" class="horzScroll empty">';
  echo '<div class="items"></div>';
  echo '<div class="instruct"><div class="vert">';
  	echo '<span>Your collection is empty. </span>';
  	echo '<span class="main">Drag items here to save them.</span>';
  	echo '<span class="mobile">Open an item and click the plus sign to save.</span>';
  echo '</div></div>';
echo '</div>';
?>