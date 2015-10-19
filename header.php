<?php /**
        Author: SpringHack - springhack@live.cn
        Last modified: 2015-10-19 21:02:52
        Filename: header.php
        Description: Created by SpringHack using vim automatically.
**/ ?>
			<script language="javascript" src="javascript/jquery-2.1.3.min.js"></script>
			<script language="javascript" src="javascript/common.js"></script>
			<link rel="stylesheet" href="css/common.css" type="text/css" />
			<br />
			<table border="1">
            	<tr>
                	<td style="padding: 20px;" align="center" width="200">
                    	<a href="index.php">Index Page</a>
                    </td>
                    <td style="padding: 20px;" align="center" width="200">
                    	<a href="rank.php">Rank List</a>
                    </td>
                    <td style="padding: 20px;" align="center" width="200">
                    	<a href="status.php">Online Status</a>
                    </td>
                    <td style="padding: 20px;" align="center" width="200">
                    	<?php
                        	require_once("api.php");
							if ($app->user->isLogin())
								echo '<font style="display: inline-block; padding: 5px; border-radius: 7px; color: #F00; background-color: #000;">'.$app->user->getUser().'</font> => <a href="admin/status.php?action=logout&url=../index.php">Logout</a>';
							else
								echo '<a href="admin/status.php?action=login&url=../index.php">Login & Register</a>';
						?>
                    </td>
                </tr>
            </table>
