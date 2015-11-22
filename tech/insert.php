<?php /**
        Author: SpringHack - springhack@live.cn
        Last modified: 2015-10-11 20:09:51
        Filename: insert.php
        Description: Created by SpringHack using vim automatically.
**/ ?>
<?php
	require_once('api.php');
	if (!$app->user->isLogin())
		redirect("Location: admin/status.php?action=login&url=../insert.php");
	$id = isset($_GET['id'])?$_GET['id']:'new';
	$is_new = true;
	if ($id != 'new')
	{
		$is_new = false;
		$app->db = new MySQL();
		$info = $app->db->from('Tech')->where('`id`=\''.$id.'\'')->select()->fetch_one();
		if (isset($info['keyword']))
			$info['keyword'] = unserialize($info['keyword']);
	}
	if (isset($_POST['submit']))
	{
		$app->db = new MySQL();
		if ($id == 'new')
		{
		//	$id = $app->db->from('Tech')->select('max(id)')->fetch_one();
		//	$id = $id['max(id)'];
		//	$id = intval($id) + 1;
			$id = uniqid();
			$_POST['id'] = $id;
			$_POST['keyword'] = serialize($_POST['keyword']);
			unset($_POST['submit']);
			foreach ($_POST as $key => $val)
				if (!get_magic_quotes_gpc())
					$_POST[$key] = addslashes($val);
			$app->db->value($_POST)->insert('Tech');
		} else {
			$_POST['id'] = $id;
			$_POST['keyword'] = serialize($_POST['keyword']);
			unset($_POST['submit']);
			foreach ($_POST as $key => $val)
				if (!get_magic_quotes_gpc())
					$_POST[$key] = addslashes($val);
			$app->db->set($_POST)->update('Tech');
		}
		header('Location: insert.php?id='.$id);
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>插入</title>
        <link rel="stylesheet" href="admin/css/frame.css" type="text/css" />
    </head>
    <body>
    	<center>
			<?php require_once("header.php"); ?>
        	<form action="insert.php?id=<?php echo $id; ?>" method="post">
        	<table>
				<tr>
					<td>
						提交
					</td>
					<td>
						<input type="submit" value="提交" name="submit" />
					</td>
				</tr>
            	<tr>
                	<td width="200">
                    	1.成果登记（登记号）
                    </td>
                    <td width="600">
                    	<input <?php if (!$is_new) echo 'disabled value="'.$info['id'].'"';?> type="text" name="id" />
                    </td>
                </tr>
                <tr>
                	<td width="200">
                    	2.关键词
                    </td>
                    <td width="600">
                    	<table>
                        	<tr>
                            	<td width=200>
                                	(1)<input <?php if (!$is_new) echo 'value="'.$info['keyword'][0].'"';?> type="text" name="keyword[0]" />
                                </td>
                                <td width=200>
                                	(2)<input <?php if (!$is_new) echo 'value="'.$info['keyword'][1].'"';?> type="text" name="keyword[1]" />
                                </td>
                                <td width=200>
                                	(3)<input <?php if (!$is_new) echo 'value="'.$info['keyword'][2].'"';?> type="text" name="keyword[2]" />
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                	<td width="200">
                    	3.成果完成单位
                    </td>
                    <td width="600">
                    	<input <?php if (!$is_new) echo 'value="'.$info['company'].'"';?> type="text" name="company" />
                    </td>
                </tr>
                <tr>
                	<td width="200">
                    	4.成果完成人
                    </td>
                    <td width="600">
                    	<table>
                        	<tr>
                            	<td width=300>
                                	<input <?php if (!$is_new) echo 'value="'.$info['owner'].'"';?> type="text" name="owner" />
                                </td>
                            	<td width=300>
                                	<table width=300>
                                    	<tr>
                                        	<td>
                                            	电话
                                            </td>
                                            <td>
                                            	<input <?php if (!$is_new) echo 'value="'.$info['telephone'].'"';?> type="text" name="telephone" />
                                            </td>
                                        </tr>
                                        <tr>
                                        	<td>
                                            	手机
                                            </td>
                                            <td>
                                            	<input <?php if (!$is_new) echo 'value="'.$info['cellphone'].'"';?> type="text" name="cellphone" />
                                            </td>
                                        </tr>
                                        <tr>
                                        	<td>
                                            	电子邮箱
                                            </td>
                                            <td>
                                            	<input <?php if (!$is_new) echo 'value="'.$info['email'].'"';?> type="text" name="email" />
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                	<td width="200">
                    	5.成果来源
                    </td>
                    <td width="600">
                    	<table>
                        	<tr>
                            	<td width=250>
                                	<input <?php if (!$is_new) if ($info['source'] == 1) echo 'checked'; ?> value="1" type="radio" name="source" />国家财政资金资助项目
                                    <input <?php if (!$is_new) if ($info['source'] == 2) echo 'checked'; ?> value="2" type="radio" name="source" />省财政资金资助项目
                                    <input <?php if (!$is_new) if ($info['source'] == 3) echo 'checked'; ?> value="3" type="radio" name="source" />市财政资金资助项目
                                    <input <?php if (!$is_new) if ($info['source'] == 4) echo 'checked'; ?> value="4" type="radio" name="source" />学校自主研发项目
                                    <input <?php if (!$is_new) if ($info['source'] == 5) echo 'checked'; ?> value="5" type="radio" name="source" />企事业单位委托研发项目
                                    <input <?php if (!$is_new) if ($info['source'] == 6) echo 'checked'; ?> value="6" type="radio" name="source" />合资合作研发项目
                                </td>
                                <td width=100>
                                	成果类型
                                </td>
                                <td width=250>
                                	<input <?php if (!$is_new) if ($info['type'] == 1) echo 'checked'; ?> value="1" type="radio" name="type" />技术开发类应用技术成果
                                    <input <?php if (!$is_new) if ($info['type'] == 2) echo 'checked'; ?> value="2" type="radio" name="type" />社会公益类应用技术成果
                                    <input <?php if (!$is_new) if ($info['type'] == 3) echo 'checked'; ?> value="3" type="radio" name="type" />软科学研究成果
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                	<td width="200">
                    	6.成果完成时间
                    </td>
                    <td width="600">
                    	<table>
                        	<tr>
                            	<td width=200>
                                	<input <?php if (!$is_new) echo 'value="'.$info['time'].'"';?> type="text" name="time" />
                                </td>
                                <td width=100>
                                	成果评价形式
                                </td>
                                <td width=300>
                                	<input <?php if (!$is_new) if ($info['status'] == 1) echo 'checked'; ?> value="1" type="radio" name="status" />鉴定
                                    <input <?php if (!$is_new) if ($info['status'] == 2) echo 'checked'; ?> value="2" type="radio" name="status" />验收
                                    <input <?php if (!$is_new) if ($info['status'] == 3) echo 'checked'; ?> value="3" type="radio" name="status" />结题
                                    <input <?php if (!$is_new) if ($info['status'] == 4) echo 'checked'; ?> value="4" type="radio" name="status" />评审
                                    <input <?php if (!$is_new) if ($info['status'] == 5) echo 'checked'; ?> value="5" type="radio" name="status" />评估
                                    <input <?php if (!$is_new) if ($info['status'] == 6) echo 'checked'; ?> value="6" type="radio" name="status" />行业准入
                                    <input <?php if (!$is_new) if ($info['status'] == 7) echo 'checked'; ?> value="7" type="radio" name="status" />权威部门检测
                                    <input <?php if (!$is_new) if ($info['status'] == 8) echo 'checked'; ?> value="8" type="radio" name="status" />其他
                                    <input <?php if (!$is_new) echo 'value="'.$info['status_other'].'"';?> type="text" name="status_other" />
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                	<td width="200">
                    	7.成果体现形式
                    </td>
                    <td width="600">
						<input <?php if (!$is_new) if ($info['model'] == 1) echo 'checked'; ?> value="1" type="radio" name="model" />新技术
						<input <?php if (!$is_new) if ($info['model'] == 2) echo 'checked'; ?> value="2" type="radio" name="model" />新工艺
						<input <?php if (!$is_new) if ($info['model'] == 3) echo 'checked'; ?> value="3" type="radio" name="model" />新产品
						<input <?php if (!$is_new) if ($info['model'] == 4) echo 'checked'; ?> value="4" type="radio" name="model" />新材料
						<input <?php if (!$is_new) if ($info['model'] == 5) echo 'checked'; ?> value="5" type="radio" name="model" />新装备
						<input <?php if (!$is_new) if ($info['model'] == 6) echo 'checked'; ?> value="6" type="radio" name="model" />生物医药品种
						<input <?php if (!$is_new) if ($info['model'] == 7) echo 'checked'; ?> value="7" type="radio" name="model" />动植物新品种
						<input <?php if (!$is_new) if ($info['model'] == 8) echo 'checked'; ?> value="8" type="radio" name="model" />矿产新品种
						<input <?php if (!$is_new) if ($info['model'] == 9) echo 'checked'; ?> value="9" type="radio" name="model" />其他应用技术
						<input <?php if (!$is_new) if ($info['model'] == 10) echo 'checked'; ?> value="10" type="radio" name="model" />标准
                    </td>
                </tr>
                <tr>
                	<td width="200">
                    	8.知识产权形式
                    </td>
                    <td width="600">
						<input <?php if (!$is_new) if ($info['view'] == 1) echo 'checked'; ?> value="1" type="radio" name="view" />发明专利
						<input <?php if (!$is_new) if ($info['view'] == 2) echo 'checked'; ?> value="2" type="radio" name="view" />实用新型专利
						<input <?php if (!$is_new) if ($info['view'] == 3) echo 'checked'; ?> value="3" type="radio" name="view" />集成电路设计权
						<input <?php if (!$is_new) if ($info['view'] == 4) echo 'checked'; ?> value="4" type="radio" name="view" />软件著作权
						<input <?php if (!$is_new) if ($info['view'] == 5) echo 'checked'; ?> value="5" type="radio" name="view" />其他
						<input <?php if (!$is_new) echo 'value="'.$info['view_other'].'"';?> type="text" name="view_other">
                    </td>
                </tr>
                <tr>
                	<td width="200">
                    	9.成果属性
                    </td>
                    <td width="600">
						<input <?php if (!$is_new) if ($info['prop'] == 1) echo 'checked'; ?> value="1" type="radio" name="prop" />原始性创新
						<input <?php if (!$is_new) if ($info['prop'] == 2) echo 'checked'; ?> value="2" type="radio" name="prop" />国外引进消化吸收创新
						<input <?php if (!$is_new) if ($info['prop'] == 3) echo 'checked'; ?> value="3" type="radio" name="prop" />国内技术二次开发
                    </td>
                </tr>
                <tr>
                	<td width="200">
                    	10.成果所处阶段
                    </td>
                    <td width="600">
						<input <?php if (!$is_new) if ($info['stage'] == 1) echo 'checked'; ?> value="1" type="radio" name="stage" />小试
						<input <?php if (!$is_new) if ($info['stage'] == 2) echo 'checked'; ?> value="2" type="radio" name="stage" />完成中试
						<input <?php if (!$is_new) if ($info['stage'] == 3) echo 'checked'; ?> value="3" type="radio" name="stage" />小规模生产（已成立项目公司）
						<input <?php if (!$is_new) if ($info['stage'] == 4) echo 'checked'; ?> value="4" type="radio" name="stage" />已通过小范围转化应用
						<input <?php if (!$is_new) if ($info['stage'] == 5) echo 'checked'; ?> value="5" type="radio" name="stage" />大规模、大范围应用阶段
                    </td>
                </tr>
                <tr>
                	<td width="200">
                    	11.成果创新程度
                    </td>
                    <td width="600">
						<input <?php if (!$is_new) if ($info['level'] == 1) echo 'checked'; ?> value="1" type="radio" name="level" />重大突破达同类技术领先水平
						<input <?php if (!$is_new) if ($info['level'] == 2) echo 'checked'; ?> value="2" type="radio" name="level" />明显突破达同类技术先进水平
						<input <?php if (!$is_new) if ($info['level'] == 3) echo 'checked'; ?> value="3" type="radio" name="level" />一般接近同类技术先进水平
                    </td>
                </tr>
                <tr>
                	<td width="200">
                    	12.所属技术领域
                    </td>
                    <td width="600">
						<input <?php if (!$is_new) if ($info['area'] == 1) echo 'checked'; ?> value="1" type="radio" name="area" />先进制造
						<input <?php if (!$is_new) if ($info['area'] == 2) echo 'checked'; ?> value="2" type="radio" name="area" />新材料
						<input <?php if (!$is_new) if ($info['area'] == 3) echo 'checked'; ?> value="3" type="radio" name="area" />电子与信息
						<input <?php if (!$is_new) if ($info['area'] == 4) echo 'checked'; ?> value="4" type="radio" name="area" />生物与医药
						<input <?php if (!$is_new) if ($info['area'] == 5) echo 'checked'; ?> value="5" type="radio" name="area" />新能源与高效节能技术
						<input <?php if (!$is_new) if ($info['area'] == 6) echo 'checked'; ?> value="6" type="radio" name="area" />资源与环境
						<input <?php if (!$is_new) if ($info['area'] == 7) echo 'checked'; ?> value="7" type="radio" name="area" />现代农业
						<input <?php if (!$is_new) if ($info['area'] == 8) echo 'checked'; ?> value="8" type="radio" name="area" />民用航空
						<input <?php if (!$is_new) if ($info['area'] == 9) echo 'checked'; ?> value="9" type="radio" name="area_other" />其他
                    </td>
                </tr>
            </table>
            </form>
			<?php require_once("footer.php"); ?>
        </center>
    </body>
</html>
