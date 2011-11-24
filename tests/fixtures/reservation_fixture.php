<?php
/* Reservation Fixture generated on: 2011-09-30 10:57:56 : 1317416276 */
class ReservationFixture extends CakeTestFixture {
	var $name = 'Reservation';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'event_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 6),
		'guest_count' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 6),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'email' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'created_date' => array('type' => 'date', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'event_id' => 1,
			'guest_count' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'email' => 'Lorem ipsum dolor sit amet',
			'created_date' => '2011-09-30'
		),
	);
}
