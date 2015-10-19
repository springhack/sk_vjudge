$(function () {
		var list = $("table, tr, td");
		list.each(function () {
				if ($(this).attr("data-type") != "rank")
					$(this).addClass("menu");
			});
		$(document.body).append("<h5><a href='http://www.90its.cn/' target='_blank' style='color: #000000;'>Designed by SpringHack in Cello Studio.</a></h5>");
	});
