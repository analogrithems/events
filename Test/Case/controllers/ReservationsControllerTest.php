<?php
/* Reservations Test cases generated on: 2011-09-30 12:41:15 : 1317422475*/
App::import('Controller', 'Reservations');

class TestReservationsController extends ReservationsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class ReservationsControllerTest extends CakeTestCase {
	var $fixtures = array('app.reservation', 'app.event', 'app.location', 'app.user');

	function startTest() {
		$this->Reservations =& new TestReservationsController();
		$this->Reservations->constructClasses();
	}

	function endTest() {
		unset($this->Reservations);
		ClassRegistry::flush();
	}

	function testIndex() {

	}

	function testView() {

	}

	function testAdd() {

	}

	function testEdit() {

	}

	function testDelete() {

	}

	function testAdminIndex() {

	}

	function testAdminView() {

	}

	function testAdminAdd() {

	}

	function testAdminEdit() {

	}

	function testAdminDelete() {

	}

}
