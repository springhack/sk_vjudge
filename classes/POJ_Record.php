<?php /**
        Author: SpringHack - springhack@live.cn
        Last modified: 2015-08-04 13:23:18
        Filename: /home/springhack/sk_vjudge/classes/POJ_Record.php
        Description: Created by SpringHack using vim automatically.
**/ ?>
<?php
	
	class POJ_Record {
		
		private $db = NULL;
		private $res = "";
		private $id = "";
		
		public function POJ_Record($id)
		{
			$this->id = $id;
			$this->db = new MySQL();
			$this->res = $this->db->from("Record")->where("`id` = '".$id."'")->select()->fetch_one();
		}
		
		public function getInfo()
		{
			if ($this->res['result'] != 'N/A'
				&& $this->res['result'] != 'Running & Judging'
				&& $this->res['result'] != 'Waiting'
				&& $this->res['result'] != 'Compiling')
			return $this->res;
			require_once(dirname(__FILE__)."/HTMLParser.php");
			//Infomation
			$cookie_file = tempnam("./cookie", "cookie");
			$login_url = "http://poj.org/login";
			$post_fields = "user_id1=".$this->res['oj_u']."&password1=".$this->res['oj_p']."&url=/";
			
			//Login
			$curl = curl_init($login_url); 
    		curl_setopt($curl, CURLOPT_HEADER, 0);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie_file);
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $post_fields);
			$this->data = curl_exec($curl);
			
			//Get Source
			$curl = curl_init("http://poj.org/showsource?solution_id=".$this->res['rid']); 
    		curl_setopt($curl, CURLOPT_HEADER, 0);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie_file);
			$src = curl_exec($curl);
			@unlink($cookie_file);
			$th = new HTMLParser();
			$th->loadHTML($src);
			$this->res['memory'] = $th->innerHTML('<td><b>Memory:</b> ', '</td>');
			$this->res['long'] = $th->innerHTML('<td><b>Time:</b> ', '</td>');
			$this->res['lang'] = $th->innerHTML('<td><b>Language:</b> ', '</td>');
			$th->loadHTML($th->startString('<td><b>Result:</b> '));
			$th->loadHTML($th->startString('<font '));
			$this->res['result'] = $th->innerHTML('>', '</font>');
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
