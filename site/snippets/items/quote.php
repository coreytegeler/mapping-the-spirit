<?php
$text = $data->text();
$citation = $data->citation();
echo '<div class="text">';
	echo $text;
echo '</div>';
echo '<div class="citation">';
	echo $citation;
echo '</div>';
?>