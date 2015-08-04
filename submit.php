<?php
	require_once("api.php");
	require_once("classes/Problem.php");
	$pro = new Problem($_GET['id'], "POJ");
	if (isset($_POST['lang']) && isset($_POST['code']))
	{
		$pro->submitCode($_POST['lang'], $_POST['code']);
		header("Location: status.php");
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Submit Code</title>
    </head>
    <body>
    	<script language="javascript">
			<?php echo $pro->getEncodeScript(); ?>
		</script>
    	<h2>POJ:<?php echo $_GET['id']; ?></h2>
    	<form action="submit.php?id=<?php echo $_GET['id']; ?>" method="post" onsubmit="return encodeSource()">
        	Language:
            <select name="lang">
            	<option value=0 selected>G++</option>
                <option value=1>GCC</option>
                <option value=2>Java</option>
                <option value=3>Pascal</option>
                <option value=4>C++</option>
                <option value=5>C</option>
                <option value=6>Fortran</option>
            </select><br />Code:<br />
            <textarea name="code" rows="30" cols="100" id="code"></textarea>
            <input type="hidden" name="rid" id="rid" value="" />
            <input name="submit" type="submit" value="Submit" />
        </form>
    </body>
</html>