<?php
/* Invite Fixture generated on: 2011-10-05 19:25:04 : 1317878704 */
class InviteFixture extends CakeTestFixture {
	var $name = 'Invite';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'event_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 6),
		'email' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'modified' => array('type' => 'date', 'null' => false, 'default' => NULL),
		'created' => array('type' => 'date', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'event_id' => 1,
			'email' => 'Lorem ipsum dolor sit amet',
			'modified' => '2011-10-05',
			'created' => '2011-10-05'
		),
	);
}
