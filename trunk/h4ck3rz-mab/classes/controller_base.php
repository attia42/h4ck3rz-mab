<?php
Load::FromDataMappers("contact");
Load::FromDataMappers("user");
Load::FromClasses('authenticator');

Abstract Class Controller_Base {
	protected $registry;

	function __construct($registry) {
		$this->registry = $registry;
		$topPart = $this->get_replace("views/top.html", array());
		
		echo $topPart;
		if(Authenticator::IsLogged())
		{
			$loggedUser = new User( $this->registry, Authenticator::GetLoggedUserId());
			$userContact = new Contact($this->registry, $loggedUser['bcID']);
			$topMenu = $this->get_replace("views/user/usertopmenu.html",array("uid"=> $loggedUser['id'],"userName" => $userContact['firstName']." ".$userContact['lastName']));
		}
		else
		{
			$topMenu = $this->get("views/user/guesttopmenu.html");
		}
		echo $topMenu ;
		
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
			for($i= strlen($folder)-1; $i >= 0 ;$i--)
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
			if(!empty($folder))			
				chdir($folder);
			$text = file_get_contents($file);
			chdir($cwd);
			return $text;
		}
		
		function __destruct()
		{
		
		$lowerPart =$this->get("views/lower.html");
		echo $lowerPart;
			
		}
		
		protected function outputError($error)
		{
			echo '<div class="error">'.$error.'</div>';
		}
		
		protected function Printhint($hint)
		{
			echo '<div class="hint">'.$hint.'</div>';
		}
		
		
		
}
?>

