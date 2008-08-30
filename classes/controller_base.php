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
			$file = "";
			$folder = $filePath;
			for($i= strlen($folder)-1; $i > 0 ;$i--)
			{
				if($folder[$i] == "/")
					{break;}
				$file[] = $folder[$i];
				$folder[$i] = null;
	
	
			}
	
			$file=array_reverse($file);
			$file = implode("",$file);
			$folder= trim($folder);
			$cwd = getcwd();
			chdir($folder);
			$text = file_get_contents($file);
			chdir($cwd);
			return $text;
		}
}
?>