<?php
/* Invites Test cases generated on: 2011-10-05 19:25:23 : 1317878723*/
App::import('Controller', 'Invites');

class TestInvitesController extends InvitesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class InvitesControllerTest extends CakeTestCase {
	var $fixtures = array('app.invite', 'app.event', 'app.location', 'app.user', 'app.reservation');

	function startTest() {
		$this->Invites =& new TestInvitesController();
		$this->Invites->constructClasses();
	}

	function endTest() {
		unset($this->Invites);
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
