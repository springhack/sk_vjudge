<?php /**
        Author: SpringHack - springhack@live.cn
        Last modified: 2015-08-28 09:16:27
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
		$alert = "Problem ".$pro_info['title']." added !";
	}
	if (isset($_POST['time']))
	{
		$app->setting->set("startTime", strtotime($_POST['stime']));
		$alert = "Start at ".$_POST['stime'];
	}
	if (isset($_POST['clean']))
	{
		$db = new MySQL();
		$db->from("Problem")->delete();
		$db->from("Record")->delete();
		$app->setting->set("lastArray", "a:0:{}");
		$app->setting->set("lastCache", time());
		$app->setting->set("startTime", time());
		$alert = "我都忘了耶~!";
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>评测管理</title>
    </head>
    <body>
		<center>
        	<br /><br />
            <?php
            	if (isset($alert))
					echo "<h1>".$alert."</h1><br />";
			?>
        	<table border="1">
            	<tr>
                	<td align="center" style="padding: 20px;">
                    	<h2>Add Problem</h2>
                    </td>
                    <td align="center" style="padding: 20px;">
                    	<h2>Set Start Time</h2>
                    </td>
                    <td align="center" style="padding: 20px;">
                    	<h2>Clean System</h2>
                    </td>
                </tr>
                <tr>
                    <td align="center" style="padding: 20px;">
                    	<form action="manager.php" method="post"><br /><br />
                            <label>Problem ID:&nbsp;</label><input type="text" name="pid" /><br /><br />
                            <label>Problem OJ:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                            <select name="oj">
                                <option value="POJ">POJ</option>
                                <option value="HDOJ">HDOJ</option>
                            </select><br /><br />
                            <input type="submit" value="Submit" name="submit" />
                        </form>
                    </td>
                    <td align="center" style="padding: 20px;">
                    	<form action="manager.php" method="post"><br /><br />
                            <label>Start Time:&nbsp;</label><input type="text" name="stime" value="<?php
                            	echo date("Y-m-d H:i:s", $app->setting->get("startTime", time()));
							?>" /><br /><br />
                            <input type="submit" value="Submit" name="time" />
                        </form>
                    </td>
                    <td align="center" style="padding: 20px;">
                    	<form action="manager.php" method="post">
                        	<input type="submit" name="clean" value="一切皆忘" />
                        </form>
                    </td>
                </tr>
            </table>
        </center>
    </body>
</html>
