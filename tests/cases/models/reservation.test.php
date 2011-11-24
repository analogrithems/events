<?php
/* Reservation Test cases generated on: 2011-09-30 10:57:56 : 1317416276*/
App::import('Model', 'Reservation');

class ReservationTestCase extends CakeTestCase {
	var $fixtures = array('app.reservation', 'app.event', 'app.location', 'app.user');

	function startTest() {
		$this->Reservation =& ClassRegistry::init('Reservation');
	}

	function endTest() {
		unset($this->Reservation);
		ClassRegistry::flush();
	}

}
