<?php /**
        Author: SpringHack - springhack@live.cn
        Last modified: 2015-08-31 16:25:12
        Filename: classes/HDOJ_Record.php
        Description: Created by SpringHack using vim automatically.
**/ ?>
<?php
	
	class HDOJ_Record {
		
		private $db = NULL;
		private $res = "";
		private $id = "";
		
		public function HDOJ_Record($id)
		{
			$this->id = $id;
			$this->db = new MySQL();
			$this->res = $this->db->from("Record")->where("`id` = '".$id."'")->select()->fetch_one();
		}
		
		public function getInfo()
		{
			/**
			if ($this->res['result'] != 'N/A'
				&& $this->res['result'] != 'Running & Judging'
				&& $this->res['result'] != 'Queuing'
				&& $this->res['result'] != 'Compiling'
				&& $this->res['result'] != 'Pending')
			return $this->res;
			**/
			require_once(dirname(__FILE__)."/HTMLParser.php");
			
			/**
			//Infomation
			$cookie_file = tempnam("./cookie", "cookie");
			$login_url = "http://acm.hdu.edu.cn/userloginex.php?action=login";
			$post_fields = "username=".$this->res['oj_u']."&userpass=".$this->res['oj_p']."&login=Sign In";
			
			//Login
			$curl = curl_init($login_url); 
    		curl_setopt($curl, CURLOPT_HEADER, 0);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie_file);
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $post_fields);
			$this->data = curl_exec($curl);
			
			//Get Source
			$curl = curl_init("http://acm.hdu.edu.cn/viewcode.php?rid=".$this->res['rid']); 
    		curl_setopt($curl, CURLOPT_HEADER, 0);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie_file);
			$src = curl_exec($curl);
			
			//Logout
			$curl = curl_init('http://acm.hdu.edu.cn/userloginex.php?action=logout'); 
    		curl_setopt($curl, CURLOPT_HEADER, 0);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie_file);
			curl_exec($curl);
			
			@unlink($cookie_file);
			$th = new HTMLParser();
			$th->loadHTML($src);
			$th->loadHTML($th->startString('Judge Status : '));
			$this->res['result'] = $th->innerHTML('>', '</font>');
			$this->res['memory'] = "N/A";//$th->innerHTML('<td><b>Memory:</b> ', '</td>');
			$this->res['long'] = "N/A";//$th->innerHTML('<td><b>Time:</b> ', '</td>');
			$this->res['lang'] = "N/A";//$th->innerHTML('<td><b>Language:</b> ', '</td>');
			**/
			
			$th = new HTMLParser("http://acm.hdu.edu.cn/status.php?first=".$this->res['rid']."&user=".$this->res['oj_u']);
			$th->loadHTML($th->innerHTML("<td height=22px>".$this->res['rid']."</td>", "</tr>"));
			echo "\n\n\n\n<pre>";
			echo $th->innerHTML("<td height=22px>".$this->res['rid']."</td>", "</tr>");
			echo "</pre>\n\n\n\n";
			$th->loadHTML($th->startString("<td height=22px>".$this->res['rid']."</td>"));
			$th->loadHTML($th->startString("<td>".$th->innerHTML("<td>", "</td>")."</td>"));
			$this->res['result'] = $th->innerHTML("<td>", "</td>");
			$th->loadHTML($th->startString("<td>".$th->innerHTML("<td>", "</td>")."</td>"));
			$th->loadHTML($th->startString("<td>".$th->innerHTML("<td>", "</td>")."</td>"));
			$this->res['long'] = $th->innerHTML("<td>", "</td>");
			$th->loadHTML($th->startString("<td>".$th->innerHTML("<td>", "</td>")."</td>"));
			$this->res['memory'] = $th->innerHTML("<td>", "</td>");
			$th->loadHTML($th->startString("<td>".$th->innerHTML("<td>", "</td>")."</td>"));
			$th->loadHTML($th->startString("<td>".$th->innerHTML("<td>", "</td>")."</td>"));
			$this->res['lang'] = $th->innerHTML("<td>", "</td>");
			
			$this->db->set(array(
					'memory' => $this->res['memory'],
					'long' => $this->res['long'],
					'lang' => $this->res['lang'],
					'result' => $this->res['result']
				))->where("`id` = '".$this->id."'")->update("Record");
			return $this->res;
		}
		
	}
	
?>
