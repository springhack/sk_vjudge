<?php /**
        Author: SpringHack - springhack@live.cn
        Last modified: 2015-08-04 13:23:12
        Filename: POJ_DataPoster.php
        Description: Created by SpringHack using vim automatically.
**/ ?>
<?php

	class POJ_DataPoster {
		
		private $data = "";
		private $db = NULL;
		private $app = NULL;
		private $geter = NULL;
		private $info = NULL;
		private $pid = "";
		private $lang = "";
		private $user = "";
		private $pass = "";
		private $rid = "";
		
		public function POJ_DataPoster($user = "skvj01", $pass = "forskvj", $id = "1000", $lang = "0", $code = "")
		{
			//MySQL
			$this->db = new MySQL();

			//Infomation
			$cookie_file = tempnam("./cookie", "cookie");
			$login_url = "http://poj.org/login";
			$post_fields = "user_id1=".$user."&password1=".$pass."&url=/";
			$rid = $_POST['rid'];
			$this->rid = $_POST['rid'];
			$this->pid = $id;
			$this->lang = $lang;
			$this->user = $user;
			$this->pass = $pass;
			
			//Login
			$curl = curl_init($login_url); 
    		curl_setopt($curl, CURLOPT_HEADER, 0);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie_file);
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $post_fields);
			$this->data = curl_exec($curl);
			curl_close($curl);
			
			//Submit
			$hint_code = /*"//<ID>".$rid."</ID>\n".*/$code;
			/**$post_fields = http_build_query(array(
					'problem_id' => $id,
					'language' => $lang,
					'encoded' => 1,
					'source' => base64_encode($hint_code)
				));**/
			$post_fields = 'problem_id='.$id.'&language='.$lang.'&encoded=1&source='.urlencode($hint_code);
			//print_r(base64_encode($code));
			$curl = curl_init("http://poj.org/submit"); 
    		curl_setopt($curl, CURLOPT_HEADER, 0);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie_file);
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $post_fields);
			$this->data = curl_exec($curl);
			curl_close($curl);
			
			
			@unlink($cookie_file);
			
			//Record Information
			$this->info = array(
					'id' => $rid,
					'user' => $user
				);
			
			//Add record
			$run_id = $this->getRunID();
			if ($run_id != "")
				$ret = $this->db->value(array(
						'id' => $rid,
						'oid' => $_GET['id'],
						'tid' => $id,
						'rid' => $run_id,
						'user' => $_SESSION['user'],
						'time' => time(),
						'memory' => 'N/A',
						'long' => 'N/A',
						'lang' => 'N/A',
						'result' => 'N/A',
						'oj' => 'POJ',
						'oj_u' => $user,
						'oj_p' => $pass,
						'code' => $code
					))->insert("Record");
			
		}
		
		public function getData()
		{
			return $this->data;
		}
		
		private function getRunID()
		{
			require_once(dirname(__FILE__)."/HTMLParser.php");
			$this->html = new HTMLParser("http://poj.org/status?problem_id=".$this->pid."&user_id=".$this->user."&result=&language=".$this->lang);
			$this->html->loadHTML($this->html->innerHTML('<td width=17%>Submit Time</td></tr>'."\n", "\n".'</table>'));
			//echo "LLL:".$this->rid."\n\n";
			while ($this->html->innerHTML('<tr align=center><td>', '</td>') != "")
			{
				$r_id = $this->html->innerHTML('<tr align=center><td>', '</td>');
				//echo "RID:".$r_id."\n";
				$this->html->loadHTML($this->html->startString('<tr align=center><td>'));
				$t_id = $this->getIdFromSource($r_id);
				//echo "LID:".$t_id."\n\n";
				if ($t_id == $this->rid)
					return $r_id;
			}
			return "";
		}
		
		public function getIdFromSource($RunID)
		{
			//Infomation
			$cookie_file = tempnam("./cookie", "cookie");
			$login_url = "http://poj.org/login";
			$post_fields = "user_id1=".$this->user."&password1=".$this->pass."&url=/";
			
			//Login
			$curl = curl_init($login_url); 
    		curl_setopt($curl, CURLOPT_HEADER, 0);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie_file);
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $post_fields);
			$this->data = curl_exec($curl);
			
			//Get Source
			$curl = curl_init("http://poj.org/showsource?solution_id=".$RunID); 
    		curl_setopt($curl, CURLOPT_HEADER, 0);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie_file);
			$src = curl_exec($curl);
			@unlink($cookie_file);
			$th = new HTMLParser();
			$th->loadHTML($src);
			return $th->innerHTML('//&lt;ID&gt;', '&lt;/ID&gt;');
		}
		
	}
	
?>
