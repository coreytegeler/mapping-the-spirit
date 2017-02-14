<?php
if( $data->title()->notEmpty() ) {
	echo '<strong>' . $data->title() . '</strong></br>';
}
echo $data->source() . '.com/' . $data->videoid();
?>