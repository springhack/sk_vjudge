<?php /**
        Author: SpringHack - springhack@live.cn
        Last modified: 2015-08-04 21:15:21
        Filename: header.php
        Description: Created by SpringHack using vim automatically.
**/ ?>
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
								echo '<a href="admin/status.php?action=logout&url=../index.php">Logout</a>';
							else
								echo '<a href="admin/status.php?action=login&url=../index.php">Login & Register</a>';
						?>
                    </td>
                </tr>
            </table>
