<?php /**
        Author: SpringHack - springhack@live.cn
        Last modified: 2015-12-07 15:22:12
        Filename: header.php
        Description: Created by SpringHack using vim automatically.
**/
require_once("api.php");
?>           
<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">Virtual Judge</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="index.php">Home</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php
                if ($app->user->isLogin()) {
                    echo "<li><a href=\"#\">".$app->user->getUser()."</a></li>";
                    echo '<li><a href="admin/status.php?action=logout&url=../index.php">Sign Out</a></li>';
                } else {
                    echo '<li><a href="admin/status.php?action=login&url=../index.php">Sign in</a>';
                }
            ?>
            </ul>
         </div>
    </div>
</div>
            