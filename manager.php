<?php /**
        Author: SpringHack - springhack@live.cn
        Last modified: 2015-08-04 17:31:10
        Filename: manager.php
        Description: Created by SpringHack using vim automatically.
**/ ?>
<?php
	require_once("api.php");
	if (!$app->user->isLogin())
		die('<center><a href=\'admin/status.php?action=login&url=../index.php\'>Please login or register first!</a></center>');
	if ($app->user->getPower() != 0)
		die('<center><a href=\'admin/status.php?action=login&url=../index.php\'>Please login or register first!</a></center>');
	if (isset($_POST['submit']))
	{
		require_once("classes/Problem.php");
		$pro = new Problem($_POST['pid'], $_POST['oj']);
		$pro_info = $pro->getInfo();
		$db = new MySQL();
		$num = $db->from("Problem")
					->select()
					->num_rows();
		$db->value(array(
				'id' => intval($num) + 1,
				'pid' => $_POST['pid'],
				'title' => $pro_info['title'],
				'oj' => $_POST['oj']
			))
			->insert("Problem");
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Manager Problems</title>
    </head>
    <body>
		<center>
        	<form action="manager.php" method="post"><br /><br />
            	<label>Problem ID:&nbsp;</label><input type="text" name="pid" /><br /><br />
                <label>Problem OJ:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                <select name="oj">
                	<option value="POJ">POJ</option>
                </select><br /><br />
                <input type="submit" value="Submit" name="submit" />
            </form>
        </center>
    </body>
</html>
