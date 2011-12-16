<?php
class Group extends AppModel {

    var $actsAs = array(
        'Tree'
    );

        /**
        * @access       public
        * @var          array
        */
    public $belongsTo = array(
        'ParentGroup' => array(
            'className'     => 'Group',
            'foreignKey'    => 'parent_id'
        )
    );

        var $hasAndBelongsToMany = array(
                'User'=>array(
                        'className' =>'User',
                        'joinTable'=>'groups_users',
                        'foreignKey'=>'group_id',
                        'associationForeignKey'=>'user_id'
                )
        ); 

        /**
         * @access      public
         * @return      void
    public function beforeSave() {
                // in case we didn't already specify it, we need to determine the next bit
        if(!isset($this->data['Group']['bit']) or empty($this->data['Group']['bit'])) {
            $next_bit   = 1;
                        // go get the last bit
            $max_bit    = $this->field('bit', null, "bit DESC");

            if(!empty($max_bit)) {
                $next_bit = $max_bit * 2;
            }

            $this->set('bit', $next_bit);
        }
    }
         */
}
