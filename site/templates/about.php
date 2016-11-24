<?php
$stories = $pages->find('stories')->children()->visible();
snippet('head');
  echo '<main>';
		echo '<section id="about">';
			echo '<div class="group about">';
		  	echo '<h3 class="title">About</h3>';
		  	echo '<div class="text">';
		  	echo '</div>';
		  echo '</div>';
		echo '</section>';
		snippet('footer');
  echo '</main>';
?>