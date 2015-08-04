<?php /**
        Author: SpringHack - springhack@live.cn
        Last modified: 2015-08-04 13:36:59
        Filename: index.php
        Description: Created by SpringHack using vim automatically.
**/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Problem List</title>
    </head>
    <body>
    	<?php
			require_once("api.php");
			require_once("classes/Problem.php");
			for ($i=1000;$i<1100;++$i)
				echo "<a href='view.php?id=".$i."'>POJ - ".$i."</a><br />";
		?>
    </body>
</html>
