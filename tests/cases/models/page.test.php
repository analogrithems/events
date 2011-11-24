<?php
/* Page Test cases generated on: 2011-10-06 13:03:27 : 1317942207*/
App::import('Model', 'Page');

class PageTestCase extends CakeTestCase {
	var $fixtures = array('app.page', 'app.user', 'app.event', 'app.location', 'app.invite', 'app.reservation');

	function startTest() {
		$this->Page =& ClassRegistry::init('Page');
	}

	function endTest() {
		unset($this->Page);
		ClassRegistry::flush();
	}

}
