<?php /**
        Author: SpringHack - springhack@live.cn
        Last modified: 2015-10-11 20:09:38
        Filename: index.php
        Description: Created by SpringHack using vim automatically.
**/ ?>
<?php
	require_once('api.php');
	if (!$app->user->isLogin())
		redirect("Location: admin/status.php?action=login&url=../index.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo $app->setting->get("SiteName"); ?></title>
        <link rel="stylesheet" href="admin/css/frame.css" type="text/css" />
    </head>
    <body>
    	<center>
			<?php require_once("header.php"); ?>
            <table>
                <tr>
                    <td width="700">
                        <form action="index.php" method="post">
                            <label>成果查询:</label><br />
							<label>查询依据:</label>
							<select name="type">
								<option value="id">编号查询</option>
								<option value="keyword">关键字查询</option>
								<option value="time">时间查询</option>
								<option value="company">单位查询</option>
								<option value="owner">完成人查询</option>
							</select>&nbsp;=>&nbsp;
							<label>查询信息:</label>
							<input type="text" name="id" value="" /><input type="submit" name="submit" value="查询" />
                        </form><a href="insert.php">新建记录</a>
                    </td>
                </tr>
                    <td>
                        <?php
                            $app->db = new MySQL();
                            if ($app->db->query('SHOW TABLES LIKE \'Tech\'')->num_rows() != 1)
                            {
                                $app->db->struct(array(
                                        'id' => 'text',
                                        'keyword' => 'text',
                                        'company' => 'text',
                                        'owner' => 'text',
                                        'telephone' => 'text',
                                        'cellphone' => 'text',
                                        'email' => 'text',
										'source' => 'text',
										'type' => 'text',
										'status' => 'text',
										'model' => 'text',
										'view' => 'text',
										'prop' => 'text',
										'area' => 'text',
										'level' => 'text',
										'stage' => 'text',
										'time' => 'text',
										'view_other' => 'text',
										'status_other' => 'text',
										'area_other' => 'text'
                                    ))->create("Tech");
                            }
                            if (isset($_POST['id']))
                                $list = $app->db->from('Tech')->where('`'.$_POST['type'].'` LIKE \'%'.$_POST['id'].'%\'')->select()->fetch_all();
                            else
                                $list = $app->db->from('Tech')->select()->fetch_all();
                            for ($i=0;$i<count($list);++$i)
                                echo '成果编号:<a href=insert.php?id='.$list[$i]['id'].'>'.$list[$i]['id'].'</a> &nbsp; => 完成人: '.$list[$i]['owner'].'<br />';
                        ?>
                    </td>
                </tr>
            </table>
			<?php require_once("footer.php"); ?>
        </center>
    </body>
</html>
