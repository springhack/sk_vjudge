<?php
	echo file_get_contents(str_replace("/vj", "http://poj.org", $_SERVER["REQUEST_URI"]));
?>