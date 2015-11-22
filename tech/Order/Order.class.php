<?php
	require_once(dirname(__FILE__)."/../App.class.php");
	App::loadMod("MySQL");
	App::loadMod("User");
	App::loadMod("Tools");
	class Order {
		private $user;
		private $db;
		private $tools;
		
		public function __construct()
		{
			$this->user = new User();
			$this->db = new MySQL();
			$this->tools = new Tools();
			if ($this->db->query("SHOW TABLES LIKE 'Order'")->num_rows() != 1)
			{
				$this->db->struct(array(
						'id' => 'text',
						'user' => 'text',
						'time' => 'text',
						'order' => 'longtext'
					))->create("Order");
			}
		}
		
		public function createOrder($user, $order = array())
		{
			$id = uniqid();
			$this->db->value(array(
					'id' => uniqid(),
					'user' => $user,
					'time' => time(),
					'order' => addslashes(serialize($order))
				))->insert("Order");
			return $id;
		}
		
		public function deleteOrder($id)
		{
			$this->db->from("Order")->where("`id` = '".$id."'")->delete("");
			return true;
		}
		
		public function getOrder($id)
		{
			$data = $this->db->from("Order")->where("`id` = '".$id."'")->select()->fetch_one();
			if (isset($data['order']))
				$data['order'] = unserialize($data['order']);
			return $data;
		}
		
		public function getList($limit = "100", $offset = "0", $user = "")
		{
			if ($user == "")
				return $this->db->from("Order")->limit($limit, $offset)->order("DESC", "time")->select()->fetch_all();
			else
				return $this->db->from("Order")->where("`user` = '".$user."'")->limit($limit, $offset)->order("DESC", "time")->select()->fetch_all();
		}
	}
?>