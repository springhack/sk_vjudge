<?php /**
        Author: SpringHack - springhack@live.cn
        Last modified: 2015-08-04 13:35:24
        Filename: get.php
        Description: Created by SpringHack using vim automatically.
**/ ?>
<?php
	phpinfo();
?>
 	require_once("api.php");
	require_once("classes/Problem.php");
	$db = new MySQL();
	$info = $db->from("Problem")->where("`id` = '".$_GET['id']."'")->select()->fetch_one();
	$prefix = "";
	switch ($info['oj'])
	{
		case "POJ":
			$prefix = "http://poj.org";
		break;
		default:
		break;
	}
	echo file_get_contents($prefix.$_SERVER["REQUEST_URI"]);

