<?php /**
        Author: SpringHack - springhack@live.cn
        Last modified: 2015-12-06 19:56:43
        Filename: HDOJ_DataPoster.php
        Description: Created by SpringHack using vim automatically.
**/ ?>
<?php

	class HDOJ_DataPoster {
		
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
		
		private $cookie_file = "";
		
		public function HDOJ_DataPoster($user = "skvj01", $pass = "forskvj", $id = "1000", $lang = "0", $code = "")
		{
			//MySQL
			$this->db = new MySQL();

			//Infomation
			$cookie_file = tempnam("./cookie", "cookie");
			$this->cookie_file = $cookie_file;
			$login_url = "http://acm.hdu.edu.cn/userloginex.php?action=login";
			$post_fields = "username=".$user."&userpass=".$pass."&login=Sign In";
			$rid = uniqid();
			$this->rid = $rid;
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
			
			//Submit
			$hint_code = "//<ID>".$rid."</ID>\n".$code;
			/**$post_fields = http_build_query(array(
					'problem_id' => $id,
					'language' => $lang,
					'encoded' => 1,
					'source' => base64_encode($hint_code)
				));**/
			$post_fields = 'check=0&problemid='.$id.'&language='.$lang.'&usercode='.urlencode($hint_code);
			$curl = curl_init("http://acm.hdu.edu.cn/submit.php?action=submit"); 
    		curl_setopt($curl, CURLOPT_HEADER, 0);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie_file);
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $post_fields);
			$this->data = curl_exec($curl);
			curl_close($curl);
			
			
			//@unlink($cookie_file);
			
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
						'oj' => 'HDOJ',
						'oj_u' => $user,
						'oj_p' => $pass,
						'code' => base64_encode($code)
					))->insert("Record");
			
			//Logout
			$curl = curl_init('http://acm.hdu.edu.cn/userloginex.php?action=logout'); 
    		curl_setopt($curl, CURLOPT_HEADER, 0);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_COOKIEFILE, $this->cookie_file);
			curl_exec($curl);
			@unlink($this->cookie_file);
			
		}
		
		public function getData()
		{
			return $this->data;
		}
		
		private function getRunID()
		{
			require_once(dirname(__FILE__)."/HTMLParser.php");
			//Just a terrible hack............
			while (true)
			{
				$this->html = new HTMLParser("http://acm.hdu.edu.cn/status.php?pid=".$this->pid."&user=".$this->user."&lang=".$this->lang);
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
			}
			return "";
		}
		
		public function getIdFromSource($RunID)
		{
			//Infomation
			/**
			$cookie_file = tempnam("./cookie", "cookie");
			$login_url = "http://acm.hdu.edu.cn/userloginex.php?action=login";
			$post_fields = "username=".$user."&userpass=".$pass."&login=Sign In";
			**/
			
			//Login
			/**
			$curl = curl_init($login_url); 
    		curl_setopt($curl, CURLOPT_HEADER, 0);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie_file);
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $post_fields);
			$this->data = curl_exec($curl);
			**/
			
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
