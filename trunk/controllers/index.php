<?php
Load::FromClasses('controller_base');

Class Controller_Index extends Controller_Base {

	function index() {
		$this->registry['template']->set ('first_name', 'Dennis');
		$this->registry['template']->show('index');
	}

}

?>