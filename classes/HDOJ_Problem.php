<?php /**
        Author: SpringHack - springhack@live.cn
        Last modified: 2015-08-04 13:38:20
        Filename: /home/springhack/sk_vjudge/classes/POJ_Problem.php
        Description: Created by SpringHack using vim automatically.
**/ ?>
<?php

	require_once(dirname(__FILE__)."/DataPoster.php");

	class HDOJ_Problem {
		
		private $pro_info = array();
		private $pro_submit = NULL;
		
		public function HDOJ_Problem($id = 1000)
		{
			require_once(dirname(__FILE__)."/HTMLParser.php");
			$html = new HTMLParser("http://acm.hdu.edu.cn/showproblem.php?pid=".$id);
			$html->optHTMLLink();
			$pro_info = array(
					'title' => substr($html->innerHTML("<h1 style='color:#1A5CC8'>", '</h1>'), 8)
				);
			$pro_info['time'] = substr($html->innerHTML('<span style=\'font-family:Arial;font-size:12px;font-weight:bold;color:green\'>Time Limit: ', ' MS (Java/Others)'), 8);
			$pro_info['memory'] = substr($html->innerHTML('MS (Java/Others)&nbsp;&nbsp;&nbsp;&nbsp;Memory Limit: ', ' K (Java/Others)<br>'), 8);
			$pro_info['submissions'] = substr($html->innerHTML('Total Submission(s): ', '&nbsp;&nbsp;&nbsp;&nbsp;Accepted'), 8);
			$pro_info['accepted'] = substr($html->innerHTML('Accepted Submission(s): ', '<br></span></b></font>'), 8);
			$pro_info['description'] = substr($html->innerHTML('<div class=panel_title align=left>Problem Description</div> <div class=panel_content>', '</div><div class=panel_bottom>'), 8);
			$pro_info['input'] = substr($html->innerHTML('<div class=panel_title align=left>Input</div> <div class=panel_content>', '</div><div class=panel_bottom>'), 8);
			$pro_info['output'] = substr($html->innerHTML('<div class=panel_title align=left>Output</div> <div class=panel_content>', '</div><div class=panel_bottom>'), 8);
			$pro_info['sample_input'] = substr($html->innerHTML('<div class=panel_title align=left>Sample Input</div><div class=panel_content><pre>', '</pre>'), 8);
			$pro_info['sample_output'] = substr($html->innerHTML('<div class=panel_title align=left>Sample Output</div><div class=panel_content><pre>', '</pre>'), 8);
			$pro_info['hint'] = "N/A";
			$pro_info['source'] = substr($html->innerHTML('<div class=panel_title align=left>Author</div> <div class=panel_content>', '</div><div class=panel_bottom>'), 8);
			$this->pro_info = $pro_info;
		}
		
		public function getInfo()
		{
			return $this->pro_info;
		}
		
		public function submitCode($oj = "HDOJ", $id = "1000", $lang = "0", $code = "")
		{
			$this->pro_submit = new DataPoster($oj, $id, $lang, $code);
		}
		
	}
	
?>
