<?php
$title = $page->title();

snippet('header');
  echo '<main class="main" role="main">';
	  echo '<h1 class="title"><div class="wrap"><span>' . $title . '</span></div></h1>';
	  echo '<div class="grid">';
		  foreach( $page->builder()->toStructure() as $index => $item ):
		  	echo '<div class="item ' . $item->_fieldset() . '" data-index="' . $index . '">';
		  		echo '<div class="inner">';
					  snippet( 'items/' . $item->_fieldset(), array( 'data' => $item ) );
					echo '</div>';
				echo '</div>';
			endforeach;
			echo '<div class="sizer"></div>';
			echo '<div class="gutter"></div>';
		echo '</div>';
  echo '</main>';
  snippet('footnotes');
snippet('footer');