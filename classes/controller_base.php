<?php

Abstract Class Controller_Base {
	protected $registry;

	function __construct($registry) {
		$this->registry = $registry;
	}

	abstract function index();


		protected function get_replace($filePath,$replace)
		{
			$text= $this->get($filePath);
			$text= $this->replace_vars($text, $replace);
			return $text;
		}
		
	  protected function replace_vars($text , $replace)
		{
			foreach($replace as  $name => $value)
			{
					$text = str_replace("{{".$name."}}", $value, $text);
			}
			return $text;
		}
		protected function get($filePath)
		{
			$text = file_get_contents($filePath);
			return $text;
		}
}
?>