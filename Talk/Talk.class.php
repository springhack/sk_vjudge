<?php
	require_once(dirname(__FILE__)."/../App.class.php");
	App::loadMod("MySQL");
	App::loadMod("User");
	App::loadMod("Tools");
	class Talk {
		private $user;
		private $db;
		private $tools;
		
		public function __construct()
		{
			$this->user = new User();
			$this->db = new MySQL();
			$this->tools = new Tools();
			if ($this->db->query("SHOW TABLES LIKE 'Talk'")->num_rows() != 1)
			{
				$this->db->struct(array(
						'id' => 'text',
						'user' => 'text',
						'tid' => 'text',
						'rid' => 'text',
						'time' => 'text',
						'content' => 'longtext',
						'json' => 'longtext'
					))->create("Talk");
			}
		}
		
		public function reply($user, $tid, $rid = "", $content, $json = "")
		{
			$id = uniqid();
			$this->db->value(array(
					'id' => $id,
					'user' => $user,
					'tid' => $tid,
					'rid' => $rid,
					'time' => time(),
					'content' => $this->tools->dealString($content),
					'json' => $json
				))->insert("Talk");
			return $id;
		}
		
		public function delete($id)
		{
			$this->db->from("Talk")->where("`id` = '".$id."'")->delete("");
			return true;
		}
		
		public function getTalk($id)
		{
			return $this->db->from("Talk")->where("`id` = '".$id."'")->select()->fetch_one();
		}
		
		public function getList($tid = "", $limit = "100", $offset = "0", $user = "")
		{
			if ($user == "")
				if ($tid == "")
					return $this->db->from("Talk")->limit($limit, $offset)->order("DESC", "time")->select()->fetch_all();
				else
					return $this->db->from("Talk")->where("`tid` = '".$tid."'")->limit($limit, $offset)->order("DESC", "time")->select()->fetch_all();
			else
				if ($tid == "")
					return $this->db->from("Talk")->where("`user` = '".$user."'")->limit($limit, $offset)->order("DESC", "time")->select()->fetch_all();
				else
					return $this->db->from("Talk")->where("`tid` = '".$tid."'"." AND `user` = '".$user."'")->limit($limit, $offset)->order("DESC", "time")->select()->fetch_all();
		}
	}
?>