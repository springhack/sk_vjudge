/**
        Author: SpringHack - springhack@live.cn
        Last modified: 2015-12-07 11:36:35
        Filename: javascript/common.js
        Description: Created by SpringHack using vim automatically.
**/
$(function () {
		var list = $("table");
		list.each(function () {
				if ($(this).attr("data-type") != "rank")
					$(this).addClass("menu");
			});
		$(document.body).append("<center><br /><h5><a href='http://www.90its.cn/' target='_blank' style='color: #000000;'>Designed by SpringHack in Cello Studio.</a></h5></center>");
	});
