<?php
/* User Test cases generated on: 2011-09-30 10:46:34 : 1317415594*/
App::import('Model', 'User');

class UserTest extends CakeTestCase {
	var $fixtures = array('app.user', 'app.event', 'app.location');

	function startTest() {
		$this->User =& ClassRegistry::init('User');
	}

	function endTest() {
		unset($this->User);
		ClassRegistry::flush();
	}

}
