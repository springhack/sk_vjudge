<?php /**
        Author: SpringHack - springhack@live.cn
        Last modified: 2015-08-28 09:33:49
        Filename: get.php
        Description: Created by SpringHack using vim automatically.
**/ ?>
<?php
 	require_once("api.php");
	require_once("classes/Problem.php");
	$id = exlplode("id=", $_SERVER["HTTP_REFERER"]);
	$id = isset($id[1])?$id[1]:0;
	$db = new MySQL();
	$info = $db->from("Problem")->where("`id` = '".$id."'")->select()->fetch_one();
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
?>
