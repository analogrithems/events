<?php
/* Event Test cases generated on: 2011-10-05 19:27:27 : 1317878847*/
App::import('Model', 'Event');

class EventTestCase extends CakeTestCase {
	var $fixtures = array('app.event', 'app.location', 'app.user', 'app.invite', 'app.reservation');

	function startTest() {
		$this->Event =& ClassRegistry::init('Event');
	}

	function endTest() {
		unset($this->Event);
		ClassRegistry::flush();
	}

}
