<?php
$excerpt = $item->excerpt();
if( $excerpt->empty() ) {
	$excerpt = str::short( $item->text()->kirbytext(), 200, '...' );
}
echo $excerpt;
?>