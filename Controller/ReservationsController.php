<?php
class ReservationsController extends AppController {

	var $name = 'Reservations';
        var $helpers = array('Html', 'Form', 'Cksource', 'Ajax', 'Js'=>array('Jquery'));
	var $uses = array('Reservation', 'Event', 'Invite');

        function beforeFilter(){
                $this->Auth->allow('index','view','add');
                if($this->RequestHandler->isAjax()){
                    Configure::write('debug', 0);// and forget debug messages
                    $this->layout = 'ajax'; //or try with $this->layout = '';
                }
                parent::beforeFilter();
        } 

	function index() {
		$this->Reservation->recursive = 0;
		$this->set('reservations', $this->paginate());
	}

	function view($id = null) {
		$this->layout = 'borderless';
		if (!$id) {
			$this->Session->setFlash(__('Invalid reservation'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('reservation', $this->Reservation->read(null, $id));
	}

	function add($id = null) {
		if(!$id && isset($this->request->data['Reservation']['invite_id']) && !empty($this->request->data['Reservation']['invite_id']) ) $id = $this->request->data['Reservation']['invite_id'];

		$invite = $this->Invite->find('first',array('conditions'=>array('Invite.id'=>$id)));
		$event = $this->Reservation->Event->read(null,$invite['Invite']['event_id']);

		//Is Valid?
		$exists = $this->Reservation->find('first',array('conditions'=>array('Reservation.invite_id'=>$id)));
		if(isset($exists['Reservation']['id']) && $event['Event']['has_reservations'] == 'Yes'){
			$this->Session->setFlash(__('Sorry, your invite has already been used.  The event you are trying to R.S.V.P. for has been set to invite only.'),'default',array('class'=>'error-message'));
			$this->redirect(array('controller'=>'Events', 'action' => 'view',$event['Event']['id']));
		}
			
		if (!empty($this->request->data)) {
			$this->log("Trying to add a reservation:".print_r($this->request->data,1),'debug');
			$this->Reservation->create();
			if ($result = $this->Reservation->save($this->request->data)) {
				$this->Session->setFlash(__('Your reservation has been saved'));
				$this->redirect(array('controller'=>'Events', 'action' => 'view',$this->request->data['Reservation']['event_id']));
			} else {
				$this->Session->setFlash(__('The reservation could not be saved. Please, try again.').
					print_r($result,1),'default',array('class'=>'error-message'));
			}
		}
		$events = $this->Reservation->Event->find('list');
		if(!is_null($id)){
			$this->set('event', $event);
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
			$this->Session->setFlash(__('Invalid reservation'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('reservation', $this->Reservation->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->request->data)) {
			$this->Reservation->create();
			if ($this->Reservation->save($this->request->data)) {
				$this->Session->setFlash(__('The reservation has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The reservation could not be saved. Please, try again.'));
			}
		}
		$events = $this->Reservation->Event->find('list');
		$this->set(compact('events'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid reservation'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->Reservation->save($this->request->data)) {
				$this->Session->setFlash(__('The reservation has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The reservation could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->Reservation->read(null, $id);
		}
		$events = $this->Reservation->Event->find('list');
		$this->set(compact('events'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for reservation'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Reservation->delete($id)) {
			$this->Session->setFlash(__('Reservation deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Reservation was not deleted'));
		$this->redirect(array('action' => 'index'));
	}


        function admin_view_event($id = false) {
                if($id == false) return false;

                //Lets see if we own the event we are trying to edit.
                if($event = $this->Reservation->Event->isOwner($id)){
                        if($this->user['User']['id'] == $event['Event']['user_id']){
                                $this->paginate = array( 'Reservation'=>array('recursive' => -1));
                                $reservations = $this->paginate('Reservation', array('Reservation.event_id'=>$event['Event']['id']));
                                $this->set('reservations', $reservations);
                                $this->set('event', array('id'=>$event['Event']['id']));
                        }else{
                                $this->Session->setFlash(__('Permission Denied!'));
                                $this->redirect(array('controller'=>'events', 'action' => 'index'));
                                $this->log("You are trying to access event {$id} and you are not authorized.  Current user info:".print_r($this->user,1),'auth');
                        }
                }

        }
}
