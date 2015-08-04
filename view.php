<?php /**
        Author: SpringHack - springhack@live.cn
        Last modified: 2015-08-04 13:41:45
        Filename: view.php
        Description: Created by SpringHack using vim automatically.
**/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>View Problem</title>
    </head>
    <body>
    	<a href="submit.php?id=<?php echo $_GET['id']; ?>">Submit</a>
    	<?php
			require_once("api.php");
			require_once("classes/Problem.php");
        	$pro = new Problem($_GET['id'], "POJ");
			$pro_info = $pro->getInfo();
			foreach ($pro_info as $key => $val)
			{
				echo "<h2>".$key."</h2>";
				if (strstr($key, "sample_"))
					echo "<pre>".$val."</pre><br /><br />";
				else
					echo $val."<br /><br />";
			}
		?>
    </body>
</html>
