<?php /**
        Author: SpringHack - springhack@live.cn
        Last modified: 2015-08-31 16:24:46
        Filename: Config.php
        Description: Created by SpringHack using vim automatically.
**/ ?>
<?php
	$Config = array(
			'DB_HOST' => '10.4.26.93',
			'DB_USER' => 'urJ50OB4xqEuZ',
			'DB_PASS' => 'pSWTY6QAzQYoD',
			'DB_NAME' => 'da406f595195d45a9b2d77caa2f8a4b1f',
			'AUTO_USER' => 'root',
			'AUTO_PASS' => 'sksks'
		);
	$sql = NULL;
	function __autoload($class)
	{
		$file = dirname(__FILE__)."/".$class."/".$class.".class.php";
		if (file_exists($file))
			require_once($file);
		else
			die("<center><h1>Class not found!</h1></center>");
	}
	function redirect($str)
	{
		header($str);
		die();
	}
?>
