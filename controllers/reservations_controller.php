<?php
class ReservationsController extends AppController {

	var $name = 'Reservations';
        var $components = array('DebugKit.Toolbar','Idbroker.LDAPAuth'=>array('homeLanding'=>'/'), 'Session', );
        var $helpers = array('Html', 'Form', 'Cksource', 'Ajax', 'Js'=>array('Jquery'),'Javascript');

        function beforeFilter(){
                $this->LDAPAuth->allow('index','view');
                $user = $this->Session->read('Auth.LdapAuth');
                $userPK = Configure::read('LDAP.User.Identifier');
                if(isset($user[$userPK]) && !empty($user[$userPK]) ){
                        $username = $user[$userPK];
                        $this->requestAction('/users/existsOrCreate/'.$username);
                }
        }

	function index() {
		$this->Reservation->recursive = 0;
		$this->set('reservations', $this->paginate());
	}

	function view($id = null) {
		$this->layout = 'borderless';
		if (!$id) {
			$this->Session->setFlash(__('Invalid reservation', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('reservation', $this->Reservation->read(null, $id));
	}

	function add($id = null) {
		$this->layout = 'borderless';
		if (!empty($this->data)) {
			$this->Reservation->create();
			if ($this->Reservation->save($this->data)) {
				$this->Session->setFlash(__('Your reservation has been saved', true));
				$this->redirect(array('controller'=>'Events', 'action' => 'view',$this->data['Reservation']['event_id']));
			} else {
				$this->Session->setFlash(__('The reservation could not be saved. Please, try again.', true));
			}
		}
		$events = $this->Reservation->Event->find('list');
		if(!is_null($id)){
			$this->set('event', $this->Reservation->Event->read(null,$id));
			$this->set('id',$id);
		}
		$this->set(compact('events'));
	}

	function admin_index() {
		$this->Reservation->recursive = 0;
		$this->set('reservations', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid reservation', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('reservation', $this->Reservation->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Reservation->create();
			if ($this->Reservation->save($this->data)) {
				$this->Session->setFlash(__('The reservation has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The reservation could not be saved. Please, try again.', true));
			}
		}
		$events = $this->Reservation->Event->find('list');
		$this->set(compact('events'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid reservation', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Reservation->save($this->data)) {
				$this->Session->setFlash(__('The reservation has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The reservation could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Reservation->read(null, $id);
		}
		$events = $this->Reservation->Event->find('list');
		$this->set(compact('events'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for reservation', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Reservation->delete($id)) {
			$this->Session->setFlash(__('Reservation deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Reservation was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
