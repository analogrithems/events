<?php
class Reservation extends AppModel {
	var $name = 'Reservation';
	var $displayField = 'name';
	var $validate = array(
		'event_id' => array(
                        'uuid' => array(
                                'rule' => array('uuid'),
				'message' => 'Internal Error with the event pointer.  Contact Support',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'invite_id' => array(
                        'uuid' => array(
                                'rule' => array('uuid'),
				'message' => 'Internal Error with the event pointer.  Contact Support',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => "Please give type your name, this will be used for the guest list.",
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'guest_count' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => "How many people (including you) will be attending?",
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'email' => array(
			'email' => array(
				'rule' => array('email'),
				'message' => "Please give your email address.",
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Event' => array(
			'className' => 'Event',
			'foreignKey' => 'event_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Invite' => array(
			'className' => 'Invite',
			'foreignKey' => 'invite_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
