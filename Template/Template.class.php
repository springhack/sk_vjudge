<?php
	class Template {
		private $file = "";
		public function __construct($tpl)
		{
			$file = dirname(__FILE__)."/../Res/tpl/php/".$tpl.".php";
			if (!file_exists($file))
				return false;
			$this->file = $file;
		}
		public function setVars($var, $val = "")
		{
			if (is_array($var))
				foreach ($var as $k => $v)
					$this->$k = $v;
			else
				$this->$var = $val;
			return $this;
		}
		public function fetchTemplate($tpl, $out = false)
		{
			if (!$out)
			{
				ob_start();
				include(dirname(__FILE__)."/../Res/tpl/php/".$tpl.".php");
				$ret = ob_get_contents();
				ob_end_clean();
				return $ret;
			} else {
				include(dirname(__FILE__)."/../Res/tpl/php/".$tpl.".php");
				return $this;
			}
		}
		public function fetchOut($out = false)
		{
			if (!$out)
			{
				ob_start();
				include($this->file);
				$ret = ob_get_contents();
				ob_end_clean();
				return $ret;
			} else {
				include($this->file);
				return $this;
			}
		}
	}
	function Template($tpl)
	{
		return new Template($tpl);
	}
?>
