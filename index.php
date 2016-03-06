<?php /**
        Author: SpringHack - springhack@live.cn
        Last modified: 2016-03-06 19:42:26
        Filename: index.php
        Description: Created by SpringHack using vim automatically.
**/ ?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php require_once("head.html"); ?>
        <title>Problem List</title>
    </head>
    <body>
        <?php require_once("navbar.php"); ?>
        <div class="container">
            <h1>Problems List</h1>
        </div>
        <div class="container">
    	<?php
			$sstart = isset($_GET['page'])?(intval($_GET['page'])-1)*100:0;
			require_once("api.php");
			$start = $app->setting->get("startTime", time() + 10);
			if ($start>time())
				die('<center><h1><a href="index.php" style="color: #000000;">Contest not start !</a></h1></center></body></html>');
			$db = new MySQL();
			if ($db->query("SHOW TABLES LIKE 'Problem'")->num_rows() != 1)
			{
				$db->struct(array(
						'id' => 'text',
						'pid' => 'text',
						'title' => 'text',
						'oj' => 'text'
					))->create("Problem");
			}
			$list = $db->from("Problem")->limit(100, $sstart)->select()->fetch_all();
			echo '<table class="table table-bordered table-hover"><thead><tr><td>Problem ID</td><td>Problem Title</td></tr></thead><tbody>';
			for ($i=0;$i<count($list);++$i)
				echo "<tr><td>".(intval($i)+1)."</td><td><a href='view.php?id=".$list[$i]['id']."'>".$list[$i]['title']."</a></td></tr>";
			echo "</tbody></table>";
		?><br /><br />
		<script language="javascript" src="Widget/pageSwitcher/pageSwitcher.js"></script>
		<br /><br />
        </div>
    </body>
</html>
