<?php /**
        Author: SpringHack - springhack@live.cn
        Last modified: 2016-03-06 19:41:07
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
        <?php require_once("navbar.php"); ?>
		<?php
			$start = $app->setting->get("startTime", time() + 10);
			if ($start>time())
				die('<center><h1><a href="index.php" style="color: #000000;">Contest not start !</a></h1></center></body></html>');
		?>
        <div class="page-header">
            <div class="container">
                <center><h3><?php echo $_GET['id'].' '.$pro_info['title']?></h3></center>
            </div>
            <div class="container">
                <center>
                    <div class="col-lg-6">
                        <table>
                            <tr>
                                <td><strong>Time Limit: </strong></td>
                                <td><?php echo $pro_info['time']."ms"; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Total Submissions: </strong></td>
                                <td><?php echo $pro_info['submissions']; ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-lg-6">
                        <table>
                            <tr>
                                <td><strong>Memory Limit: </strong></td>
                                <td><?php echo $pro_info['memory']."kb"; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Accepted: </strong></td>
                                <td><?php echo $pro_info['accepted']; ?></td>
                            </tr>
                        </table>
                    </div>
                </center>
            </div>
        </div>
        <div class="page-content">
            <div class="container">
                <p class="lead">Description</p>
                <div class="well"><?php echo $pro_info['description']; ?></div>
                <p class="lead">Input</p>
                <div class="well"><?php echo $pro_info['input']; ?></div>
                <p class="lead">Output</p>
                <div class="well"><?php echo $pro_info['output']; ?></div>
                <p class="lead">Sample Input</p>
                <pre><?php echo $pro_info['sample_input'] ?></pre>
                <p class="lead">Sample Output</p>
                <pre><?php echo $pro_info['sample_output'] ?></pre>
                <?php if (!empty($pro_info['hint'])) {
                    echo '<p class="lead">Hint</p>';
                    echo '<div class="well">'.$pro_info['hint'].'</div>';
                }?>
                <p class="lead">Source</p>
                <div class="well"><?php echo $pro_info['source']; ?></div>
            </div>
            <div class="footer">
                <div class="container">
                    <div class="btn-group" role="group">
                        <a class="btn btn-default" href="submit.php?id=<?php echo $_GET['id']; ?>">Submit</a>
                    </div>
                </div>
            </div>
        </div>

    </body>
</html>
