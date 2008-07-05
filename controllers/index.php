<?php

Class Controller_Index Extends Controller_Base {

	function index() {
		$this->registry['template']->set ('first_name', 'Dennis');
		$this->registry['template']->show('index');
	}

}

?>