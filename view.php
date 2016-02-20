<?php /**
        Author: SpringHack - springhack@live.cn
        Last modified: 2015-12-08 10:29:33
        Filename: view.php
        Description: Created by SpringHack using vim automatically.
**/ ?>
<?php
    require_once("api.php");
    require_once("classes/Problem.php");
    $db = new MySqL();
    $info = $db->from("Problem")->where("`id` = '".$_GET['id']."'")->select()->fetch_one();
    $pro = new Problem($info['pid'], $info['oj']);
    $pro_info = $pro->getInfo();
?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php require_once("head.html"); ?>
        <title><?php echo $_GET['id'].' '.$pro_info['title']?></title>
    </head>
    <body>
    	<center>
        <?php require_once("navbar.php"); ?>
		<?php
			$start = $app->setting->get("startTime", time() + 10);
			if ($start>time())
				die('<center><h1><a href="index.php" style="color: #000000;">Contest not start !</a></h1></center></body></html>');
		?>
        <h1><?php echo $_GET['id'].' '.$pro_info['title']?></h1>
        <table border="1">
        	<tr>
            	<td width="200">
            		<h2>Submit Code</h2>
            	</td>
                <td width="600">
                	<a href="submit.php?id=<?php echo $_GET['id']; ?>">Submit</a>
                </td>
            </tr>
            <?php
                foreach ($pro_info as $key => $val)
                {
                    echo "<tr><td width='200'><h2>".$key."</h2></td><td width='800'>";
                    if (strstr($key, "sample_"))
                        echo "<pre>".$val."</pre></td></tr>";
                    else
                        echo $val."</td></tr>";
                }
            ?>
            </table>
            <br /><br />
        </center>
    </body>
</html>
