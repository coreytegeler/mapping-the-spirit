<?php
if( $item->hasNextVisible() ) {
	$next = $item->nextVisible();
	echo '<a href="' . $next->url() . '" data-slug="' . $next->slug() . '" class="paginate arrow next"></a>';
}
if( $item->hasPrevVisible() ) {
	$prev = $item->prevVisible();
	echo '<a href="' . $prev->url() . '" data-slug="' . $prev->slug() . '" class="paginate arrow prev"></a>';
}
?>