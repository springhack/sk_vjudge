<?php
	require_once("../App.class.php");
	App::loadMod("User");
	App::loadMod("Talk");
	App::loadMod("Eassy");
	$app = new App();
	$user = new User();
	$talk = new Talk(); 
	$eassy = new Eassy();
	if (!$user->isLogin())
		redirect("Location: status.php?action=login");
	if (isset($_GET['action']) || isset($_GET['id']))
		if ($_GET['action'] == "delete")
		{
			if (!$user->str_check($_GET['id']))
				redirect("Location: error.php");
			$t = $talk->getTalk($_GET['id']);
			$e = $eassy->getEassy($t['tid']);
			if ($user->getPower() != 0)
				if ($user->getUser() != $e['author'])
					redirect("Location: error.php");
			$talk->delete($_GET['id']);
			echo "<script language=\"javascript\">alert('删除成功!');history.back(-1);</script>";
			die();
		}
	$tid = isset($_GET['tid'])?$_GET['tid']:"";
	$limit = isset($_GET['page'])?(intval($_GET['page']) - 1)*20:"0";
	if ($tid == "")
	{
		if ($user->getPower() == 0)
			$u = "";
		else
			$u = $user->getUser();
	} else {
		$u = "";
	}
	$list = $talk->getList($tid, 20, $limit, $u);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>评论管理</title>
        <link rel="stylesheet" href="css/frame.css" type="text/css" />
    </head>
    <body>
    	<center>
        	<br />
            <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="150">
                        ID
                    </td>
                    <td width="250">
                        文章  
                    </td>
                    <td width="150">
                        回复ID  
                    </td>
                    <td width="100">
                        作者  
                    </td>
                    <td width="250">
                        内容  
                    </td>
                    <td width="50">
                    	操作
                    </td>
                </tr>
                <?php for ($i=0;$i<count($list);++$i) { ?>
                    <tr>
                        <td>
                            <?php echo $list[$i]['id']; ?>
                        </td>
                        <td>
                            <a href="../view.php?id=<?php
                            	echo $list[$i]['tid'];
							?>" target="_blank"><?php
                            	$post = $eassy->getEassy($list[$i]['tid']);
								echo $post['title'];
							?></a>
                        </td>
                        <td>
                            <?php echo $list[$i]['rid']; ?>
                        </td>
                        <td>
                            <?php echo $list[$i]['user']; ?>
                        </td>
                        <td>
                            <?php echo $list[$i]['content']; ?>
                        </td>
                        <td>
                        	<a href="talk.php?action=delete&id=<?php echo $list[$i]['id']; ?>">删除</a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </center>
    	<script language="javascript" src="../Widget/pageSwitcher/pageSwitcher.js"></script>
    </body>
</html>
