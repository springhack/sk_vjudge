<?php /**
        Author: SpringHack - springhack@live.cn
        Last modified: 2015-08-04 13:35:24
        Filename: get.php
        Description: Created by SpringHack using vim automatically.
**/ ?>
<?php
	echo file_get_contents(str_replace("/vj", "http://poj.org", $_SERVER["REQUEST_URI"]));
?>
