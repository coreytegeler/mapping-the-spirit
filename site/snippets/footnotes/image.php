<?php
$image = $page->image($data->image())->url();
$caption = $data->caption();
echo '<div class="image">';
	echo '<img src="' . $image . '"/>';
echo '</div>';
echo '<div class="caption">';
	echo $caption;
echo '</div>';
?>