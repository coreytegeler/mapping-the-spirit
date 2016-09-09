<?php
echo '<aside id="foonotes">';
  foreach($page->builder()->toStructure() as $index => $section):
  	echo '<figcaption class="item ' . $section->_fieldset() . '" data-index="' . $index . '">';
  		echo '<div class="inner">';
		    snippet('footnotes/' . $section->_fieldset(), array('data' => $section));
		  echo '</div>';
		echo '</figcaption>';
  endforeach;
echo '</aside>';
?>