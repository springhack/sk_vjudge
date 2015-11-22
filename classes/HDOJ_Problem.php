<?php /**
        Author: SpringHack - springhack@live.cn
        Last modified: 2015-11-22 19:17:42
        Filename: HDOJ_Problem.php
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
					'title' => substr($html->innerHTML("<h1 style='color:#1A5CC8'>", '</h1>'), $sub_start)
				);
			
			//Just a hack for OS X
			$sub_start = 0;
			
			$pro_info['time'] = substr($html->innerHTML('<span style=\'font-family:Arial;font-size:12px;font-weight:bold;color:green\'>Time Limit: ', ' MS (Java/Others)'), $sub_start);
			$pro_info['memory'] = substr($html->innerHTML('MS (Java/Others)&nbsp;&nbsp;&nbsp;&nbsp;Memory Limit: ', ' K (Java/Others)<br>'), $sub_start);
			$pro_info['submissions'] = substr($html->innerHTML('Total Submission(s): ', '&nbsp;&nbsp;&nbsp;&nbsp;Accepted'), $sub_start);
			$pro_info['accepted'] = substr($html->innerHTML('Accepted Submission(s): ', '<br></span></b></font>'), $sub_start);
			$pro_info['description'] = substr($html->innerHTML('<div class=panel_title align=left>Problem Description</div> <div class=panel_content>', '</div><div class=panel_bottom>'), $sub_start);
			$pro_info['input'] = substr($html->innerHTML('<div class=panel_title align=left>Input</div> <div class=panel_content>', '</div><div class=panel_bottom>'), $sub_start);
			$pro_info['output'] = substr($html->innerHTML('<div class=panel_title align=left>Output</div> <div class=panel_content>', '</div><div class=panel_bottom>'), $sub_start);
			$pro_info['sample_input'] = substr($html->innerHTML('<div class=panel_title align=left>Sample Input</div><div class=panel_content><pre>', '</pre>'), $sub_start);
			$pro_info['sample_output'] = substr($html->innerHTML('<div class=panel_title align=left>Sample Output</div><div class=panel_content><pre>', '</pre>'), $sub_start);
			$pro_info['hint'] = "N/A";
			$pro_info['source'] = substr($html->innerHTML('<div class=panel_title align=left>Author</div> <div class=panel_content>', '</div><div class=panel_bottom>'), $sub_start);
			foreach ($pro_info as $k => $v)
				$pro_info[$k] = iconv('GB2312', 'UTF-8', $v);
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
