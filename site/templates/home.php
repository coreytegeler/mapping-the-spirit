<?php
snippet('header');

  echo '<main class="main" role="main">';
  	echo '<div class="title">';
	  	echo '<h1>';
	  		echo $site->title();
	  	echo '</h1>';
	  echo '</maidiv>';
  echo '</main>';

snippet('footer')
?>