<?php
/* Invite Test cases generated on: 2011-10-05 19:25:04 : 1317878704*/
App::import('Model', 'Invite');

class InviteTestCase extends CakeTestCase {
	var $fixtures = array('app.invite', 'app.event', 'app.location', 'app.user', 'app.reservation');

	function startTest() {
		$this->Invite =& ClassRegistry::init('Invite');
	}

	function endTest() {
		unset($this->Invite);
		ClassRegistry::flush();
	}

}
