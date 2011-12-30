<?php
	if(isset($user['User']['id'])){echo json_encode(true); }
	else{ echo json_encode(false); }
?>
