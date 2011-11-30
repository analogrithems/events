<?php
class EventsController extends AppController {

	var $name = 'Events';
	var $components = array('DebugKit.Toolbar','Idbroker.LDAPAuth'=>array('homeLanding'=>'/'), 'Session');
	var $helpers = array('Html', 'Form', 'Cksource', 'Ajax', 'Js'=>array('Jquery'),'Javascript');

	function index() {
		$this->Event->recursive = 0;
		$this->set('events', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid event: '.print_r($id,1), true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('event', $this->Event->read(null, $id));
	}

	function admin_index() {
		$this->Event->recursive = 0;
		$this->set('events', $this->paginate());
	}

	function my_events(){
		if(isset($this->user['User']['id']) && !empty($this->user['User']['id'])){
			$user_id = $this->user['User']['id'];
		}else{
			return false;
		}
		$my_events = $this->paginate( array(
			'Event.user_id'=>$user_id
			)
		);
		foreach($my_events as $id=>$event){
			$my_events[$id]['Invite']['count'] = $this->Event->Invite->find('count',array('conditions'=>array('Invite.event_id'=>$event['Event']['id'])));
			$reservation = $this->Event->Reservation->find('first',array('conditions'=>array('Reservation.event_id'=>$event['Event']['id']), 'fields'=>array("SUM(Reservation.guest_count) as count")));
			$my_events[$id]['Reservation']['count'] = $reservation[0]['count'];
		}
		if(isset($this->params['requested'])){
			return $my_events;
		}else{
			$this->set('my_events', $my_events);
		}
	}
	
	function events_by_location(){
                if(isset($this->user['User']['id']) && !empty($this->user['User']['id'])){
                        $user_id = $this->user['User']['id'];
                }else{
                        return false;
                }
		$this->paginate['order'] = array('Event.location_id'=>'asc');
                $eventsby = $this->paginate();
                if(isset($this->params['requested'])){
                        return $eventsby;
                }else{
                        $this->set('eventsby', $eventsby);
                }
        }

	function events_by_user(){
                if(isset($this->user['User']['id']) && !empty($this->user['User']['id'])){
                        $user_id = $this->user['User']['id'];
                }else{
                        return false;
                }       
                $this->paginate['order'] = array('Event.user_id'=>'asc');
                $eventsby = $this->paginate();
                if(isset($this->params['requested'])){
                        return $eventsby;
                }else{  
                        $this->set('eventsby', $eventsby);
                }       
        }

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid event', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('event', $this->Event->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->log("Logged in User: ".print_r($this->user,1),'debug');
			$this->data['Event']['user_id'] = $this->user['User']['id'];
			if(isset($this->data['Invites']['email']) && !empty($this->data['Invites']['email'])){
				//add all the invites
				$emails = explode("\n",$this->data['Invites']['email']);
				foreach($emails as $address){
					$this->data['Invite'][] = array('email'=>$address,'sent'=>'No');
				}
				unset($this->data['Invites']);
				$this->log("Guest Where listed:".print_r($this->data['Invite'],1),'debug');
			}else{
				$this->log("Guest Where not listed:".print_r($this->data['Invite'],1),'debug');
				$addEmails = false;
			}
			unset($this->Event->Invite->validate['event_id']);
			$this->log("Trying to do a big add:".print_r($this->data,1),'debug');
			$this->Event->create();
			if ($sar = $this->Event->saveAll($this->data,array('atomic'=>false))) {
				$this->Session->setFlash(__('The event has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The event could not be saved. Please, try again.'.print_r($sar,1).':'.print_r($this->Event->validationErrors,1).':'.print_r($this->Event->Invite->validationErrors,1), true));
			}
		}
		$locations = $this->Event->Location->find('list');
		$users = $this->Event->User->find('list');
		$this->set('current_user', $this->user);
		$this->set(compact('locations', 'users'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid event', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if(isset($this->user['User']['id'])){
				$this->data['Event']['user_id'] = $this->user['User']['id'];
				if(isset($this->data['Invites']['email']) && !empty($this->data['Invites']['email'])){
					//add all the invites
					$emails = explode("\n",$this->data['Invites']['email']);
					foreach($emails as $address){
						$this->data['Invite'][] = array('email'=>$address,'sent'=>'No', 'event_id'=>$id);
					}
					unset($this->data['Invites']);
					$this->log("Guest Where listed:".print_r($this->data['Invite'],1),'debug');
				}else{
					$this->log("Guest Where not listed:".print_r($this->data['Invite'],1),'debug');
					$addEmails = false;
				}
				if ($sar = $this->Event->saveAll($this->data,array('atomic'=>false))) {
					$this->Session->setFlash(__('The event has been saved', true));
					$this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__('The event could not be saved. Please, try again. Sar was'.print_r($sar,1).':validation errors where:'.print_r($this->Event->validationErrors,1).':invite validation errors:'.print_r($this->Event->Invite->validationErrors.': Data was:'.print_r($this,1),1), true),'default',array('class'=>'error-message'));
				}
			}else{
				$this->Session->setFlash(__('You Are not Authorized to do this',true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Event->read(null, $id);
		}
		$locations = $this->Event->Location->find('list');
		$users = $this->Event->User->find('list');
		$this->set(compact('locations', 'users'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for event', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Event->delete($id)) {
			$this->Session->setFlash(__('Event deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Event was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}

	// Handle incoming uploads. 
	function upload() { 
		if ($this->data) { 
		    // Uploaded file is saved by a behavior attached to UserImage model (See model code below). 
		    if ($this->UserImage->saveAll($this->data['UserImage'])) { 
			$this->Session->setFlash(__('profile updated', true)); 
			return $this->_back(); 
		    } else { 
			$this->Session->setFlash(__('errors in form', true)); 
		    } 
		} else { 
		    $this->data = $this->User->read(null, $this->Auth->user('id')); 
		} 
		$this->_setSelects(); 
		} 
	}
