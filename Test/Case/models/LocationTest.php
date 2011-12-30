<?php
/* Location Test cases generated on: 2011-09-30 10:46:06 : 1317415566*/
App::import('Model', 'Location');

class LocationTest extends CakeTestCase {
	var $fixtures = array('app.location', 'app.event', 'app.user');

	function startTest() {
		$this->Location =& ClassRegistry::init('Location');
	}

	function endTest() {
		unset($this->Location);
		ClassRegistry::flush();
	}

}
