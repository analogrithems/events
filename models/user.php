<?php
class User extends AppModel {
	var $name = 'User';
	var $displayField = 'username';
	var $validate = array(
		'dn' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);


	//The Associations below have been created with all possible keys, those that are not needed can be removed
	function __construct(){
		$this->usernameAttr = Configure::read('LDAP.User.Identifier');
		parent::__construct();
	}


        /**
         * @access      public
         * @var         array
	public $actsAs = array(
		'Permissionable' => array(
		    'defaultBits'   => 416
		)
	);
         */

	var $hasAndBelongsToMany = array(
		'Group'=>array(
			'className' =>'Group',
			'joinTable'=>'groups_users',
			'foreignKey'=>'user_id',
			'associationForeignKey'=>'group_id'
		)
	);

	var $hasMany = array(
		'Event' => array(
			'className' => 'Event',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Page' => array(
			'className' => 'Page',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

}
