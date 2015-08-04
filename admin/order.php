<?php
	require_once("../App.class.php");
	App::loadMod("User");
	App::loadMod("Order");
	App::loadMod("Eassy");
	$app = new App();
	$user = new User();
	$order = new Order();
	$eassy = new Eassy();
	if (!$user->isLogin())
		redirect("Location: status.php?action=login");
	$look = false;
	if (isset($_GET['action']) || isset($_GET['id']))
	{
		if ($_GET['action'] == "delete")
		{
			if (!$user->str_check($_GET['id']))
				redirect("Location: error.php");
			$t = $order->getOrder($_GET['id']);
			if ($user->getPower() != 0)
				if ($user->getUser() != $t['user'])
					redirect("Location: error.php");
			$order->deleteOrder($_GET['id']);
			echo "<script language=\"javascript\">alert('删除成功!');history.back(-1);</script>";
			die();
		}
		if ($_GET['action'] == "look")
		{
			if (!$user->str_check($_GET['id']))
				redirect("Location: error.php");
			$t = $order->getOrder($_GET['id']);
			if ($user->getPower() != 0)
				if ($user->getUser() != $t['user'])
					redirect("Location: error.php");
			$order_info = $order->getOrder($_GET['id']);
			$look = true;
		}
	}
	$id = isset($_GET['id'])?$_GET['id']:"";
	$limit = isset($_GET['page'])?(intval($_GET['page']) - 1)*20:"0";
	if ($user->getPower() == 0)
		$u = "";
	else
		$u = $user->getUser();
	$list = $order->getList(20, $limit, $u);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>订单管理</title>
        <link rel="stylesheet" href="css/frame.css" type="text/css" />
    </head>
    <body>
    	<?php if (!$look) { ?>
    	<center>
        	<br />
            <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="150">
                        ID
                    </td>
                    <td width="150">
                        账号  
                    </td>
                    <td width="200">
                    	时间
                    </td>
                    <td width="100">
                    	操作
                    </td>
                </tr>
                <?php for ($i=0;$i<count($list);++$i) { ?>
                    <tr>
                        <td>
                            <?php echo $list[$i]['id']; ?>
                        </td>
                        <td>
                            <?php echo $list[$i]['user']; ?>
                        </td>
                        <td>
                            <?php echo date("Y-m-d H:i:s", $list[$i]['time']); ?>
                        </td>
                        <td>
                        	<a href="order.php?action=look&id=<?php echo $list[$i]['id']; ?>">查看</a>&nbsp;|&nbsp;<a href="order.php?action=delete&id=<?php echo $list[$i]['id']; ?>">删除</a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </center>
    	<script language="javascript" src="../Widget/pageSwitcher/pageSwitcher.js"></script>
        <?php } else { ?>
        <center>
        	<br />
        	<table border="0" cellpadding="0" cellspacing="0">
            	<tr>
                	<td width="150">
                    	账号
                    </td>
                    <td>
                    	<?php echo $order_info['user']; ?>
                    </td>
                </tr>
                <tr>
                	<td>
                    	时间
                    </td>
                    <td>
                    	<?php echo date("Y-m-d H:i:s", $order_info['time']); ?>
                    </td>
                </tr>
            	<?php foreach ($order_info['order'] as $key => $val) { ?>
                	<tr>
                    	<td>
                        	<?php echo $key; ?>
                        </td>
                        <td>
                        	<?php echo $val; ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </center>
        <?php } ?>
    </body>
</html>
