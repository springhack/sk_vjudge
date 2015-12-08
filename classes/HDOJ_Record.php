<?php /**
        Author: SpringHack - springhack@live.cn
        Last modified: 2015-12-08 10:19:09
        Filename: HDOJ_Record.php
        Description: Created by SpringHack using vim automatically.
**/ ?>
<?php
	
	class HDOJ_Record {
		
		private $db = NULL;
		private $res = "";
		private $id = "";
		
		//Patch of record
		private $html;
		private $data;
		private $user;
		private$pass;
		private $rid;
		//Patch end
		
		public function HDOJ_Record($id)
		{
			$this->id = $id;
			$this->db = new MySQL();
			$this->res = $this->db->from("Record")->where("`id` = '".$id."'")->select()->fetch_one();
			//Patch
			$this->rid = $id;
			$this->user = $this->res['oj_u'];
			$this->pass = $this->res['oj_p'];
			$this->pid = $this->res['tid'];
			if ($this->res['rid'] == '__')
			{
				$run_id = $this->getRunID();
				if ($run_id != "")
					$this->db->set(array(
								'rid' => $run_id
							))->where('`id`=\''.$id.'\'')->update('Record');
			}
		}
		
		public function getInfo()
		{
			if ($this->res['result'] != 'N/A'
				&& $this->res['result'] != 'Running & Judging'
				&& $this->res['result'] != 'Running'
				&& $this->res['result'] != 'Queuing'
				&& $this->res['result'] != 'Compiling'
				&& $this->res['result'] != 'Pending')
			return $this->res;
			//Patch
			if ($this->res['rid'] == '__')
				return $this->res;
			require_once(dirname(__FILE__)."/HTMLParser.php");
			$th = new HTMLParser("http://acm.hdu.edu.cn/status.php?first=".$this->res['rid']."&user=".$this->res['oj_u']);
			$th->loadHTML($th->innerHTML("<td height=22px>".$this->res['rid']."</td>", "</tr>"));
			$th->loadHTML($th->startString("<td>".$th->innerHTML("<td>", "</td>")."</td>"));
			$this->res['result'] = $th->innerHTML(">", "</", $th->innerHTML("<font", "font>", $th->innerHTML("<td>", "</td>")));
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

		private function getRunID()
		{
			require_once(dirname(__FILE__)."/HTMLParser.php");
			$this->html = new HTMLParser("http://acm.hdu.edu.cn/status.php?pid=".$this->pid."&user=".$this->user);
			$this->html->loadHTML($this->html->innerHTML('Output Limit Exceeded</option></select></span>', '<< First Page'));
			//echo "LLL:".$this->rid."\n\n";
			while ($this->html->innerHTML('align=center ><td height=22px>', '</td>') != "")
			{
				$r_id = $this->html->innerHTML('align=center ><td height=22px>', '</td>');
				//echo "RID:".$r_id."\n";
				$this->html->loadHTML($this->html->startString('align=center ><td height=22px>'));
				$t_id = $this->getIdFromSource($r_id);
				//echo "LID:".$t_id."\n\n";
				if ($t_id == $this->rid)
					return $r_id;
			}
			return "";
		}
		
		public function getIdFromSource($RunID)
		{
			$cookie_file = tempnam("./cookie", "cookie");
			$this->cookie_file = $cookie_file;
			$login_url = "http://acm.hdu.edu.cn/userloginex.php?action=login";
			$post_fields = "username=".$this->user."&userpass=".$this->pass."&login=Sign In";
			
			//Login
			$curl = curl_init($login_url); 
    		curl_setopt($curl, CURLOPT_HEADER, 0);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie_file);
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $post_fields);
			$this->data = curl_exec($curl);

			//Get Source
			$curl = curl_init("http://acm.hdu.edu.cn/viewcode.php?rid=".$RunID); 
    		curl_setopt($curl, CURLOPT_HEADER, 0);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_COOKIEFILE, $this->cookie_file);
			$src = curl_exec($curl);
			
			$th = new HTMLParser();
			$th->loadHTML($src);
			return $th->innerHTML('//&lt;ID&gt;', '&lt;/ID&gt;');
		}
		
	}
	
?>
