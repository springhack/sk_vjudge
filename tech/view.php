<?php
	require_once(dirname(__FILE__)."/App.class.php");
	App::loadMod("Tools");
	App::loadMod("Eassy");
	App::$Tools->dealSiteOpen();
	$app = new App();
	$eassy = new Eassy();
	if (!isset($_GET['id']))
		header("Location: admin/error.php");
	$post = $eassy->getEassy($_GET['id']);
	if(!$post)
		header("Location: admin/error.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo $post['title']; ?></title>
        <link rel="stylesheet" href="admin/css/frame.css" type="text/css" />
    </head>
    <body>
    	<center>
        	<br /><br />
        	<img src="admin/img/warning.png" /><br />
            <h1 style="color: #F00;">标题：<?php echo $post['title']; ?></h1>
            <p style="color: #F30;">作者：<?php echo $post['author']; ?><br />
            内容：<br />
            <?php echo $post['content']; ?><br />
            <p style="color: #0F0;">Orz...没了...</p>
        </center>
    </body>
</html>