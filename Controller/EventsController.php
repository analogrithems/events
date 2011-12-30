<?php
class EventsController extends AppController {

	var $name = 'Events';
	var $helpers = array('Html', 'Form', 'Cksource', 'Ajax', 'Js'=>array('Jquery'));

	function index() {
		$this->Event->recursive = 0;
		$this->set('events', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid event: '.print_r($id,1)));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('event', $this->Event->read(null, $id));
	}

	function admin_index() {
		$this->layout = 'dashboard';
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
		if(isset($this->request->params['requested'])){
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
                if(isset($this->request->params['requested'])){
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
                if(isset($this->request->params['requested'])){
                        return $eventsby;
                }else{  
                        $this->set('eventsby', $eventsby);
                }       
        }

	function admin_view($id = null) {
		$this->layout = 'dashboard';
		if (!$id) {
			$this->Session->setFlash(__('Invalid event'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('event', $this->Event->read(null, $id));
	}

	function admin_add() {
		$this->layout = 'dashboard';
		if (!empty($this->request->data)) {
			$this->log("Logged in User: ".print_r($this->user,1),'debug');
			$this->request->data['Event']['user_id'] = $this->user['User']['id'];
			if(isset($this->request->data['Invites']['email']) && !empty($this->request->data['Invites']['email'])){
				//add all the invites
				$emails = explode("\n",$this->request->data['Invites']['email']);
				foreach($emails as $address){
					$this->request->data['Invite'][] = array('email'=>$address,'sent'=>'No','opted_out'=>'No');
				}
				unset($this->request->data['Invites']);
				$this->log("Guest Where listed:".print_r($this->request->data['Invite'],1),'debug');
			}else{
				$this->log("Guest Where not listed:".print_r($this->request->data['Invite'],1),'debug');
				$addEmails = false;
			}
			unset($this->Event->Invite->validate['event_id']);
			$this->log("Trying to do a big add:".print_r($this->request->data,1),'debug');
			$this->Event->create();
			if ($sar = $this->Event->saveAll($this->request->data)) {
				$this->log("Save result was:".print_r($sar,1).':With :'.print_r($this->request->data,1),'debug');
				$this->Session->setFlash(__('The event has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The event could not be saved. Please, try again.'.print_r($sar,1).':'.print_r($this->Event->validationErrors,1).':'.print_r($this->Event->Invite->validationErrors,1)));
			}
		}
		$locations = $this->Event->Location->find('list');
		$users = $this->Event->User->find('list');
		$this->set('current_user', $this->user);
		$this->set(compact('locations', 'users'));
	}

	function admin_edit($id = null) {
		$this->layout = 'dashboard';
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid event'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if(isset($this->user['User']['id'])){
				$this->request->data['Event']['user_id'] = $this->user['User']['id'];
				if(isset($this->request->data['Invites']['email']) && !empty($this->request->data['Invites']['email'])){
					//add all the invites
					$emails = explode("\n",$this->request->data['Invites']['email']);
					foreach($emails as $address){
						$this->request->data['Invite'][] = array('email'=>$address,'sent'=>'No', 'event_id'=>$id);
					}
					unset($this->request->data['Invites']);
					$this->log("Guest Where listed:".print_r($this->request->data['Invite'],1),'debug');
				}else{
					$this->log("Guest Where not listed:".print_r($this->request->data['Invite'],1),'debug');
					$addEmails = false;
				}
				if ($sar = $this->Event->saveAll($this->request->data,array('atomic'=>false))) {
					$this->Session->setFlash(__('The event has been saved'));
					$this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__('The event could not be saved. Please, try again. Sar was'.print_r($sar,1).':validation errors where:'.print_r($this->Event->validationErrors,1).':invite validation errors:'.print_r($this->Event->Invite->validationErrors.': Data was:'.print_r($this,1),1)),'default',array('class'=>'error-message'));
				}
			}else{
				$this->Session->setFlash(__('You Are not Authorized to do this'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->Event->read(null, $id);
		}
		$locations = $this->Event->Location->find('list');
		$users = $this->Event->User->find('list');
		$revisions = $this->Event->revisions($id);
		$this->set(compact('locations', 'users', 'revisions'));
	}

	function admin_delete($id = null) {
		$this->layout = 'dashboard';
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for event'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Event->delete($id)) {
			$this->Session->setFlash(__('Event deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Event was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

	// Handle incoming uploads. 
	function upload() { 
		if ($this->request->data) { 
		    // Uploaded file is saved by a behavior attached to UserImage model (See model code below). 
		    if ($this->UserImage->saveAll($this->request->data['UserImage'])) { 
			$this->Session->setFlash(__('profile updated')); 
			return $this->_back(); 
		    } else { 
			$this->Session->setFlash(__('errors in form')); 
		    } 
		} else { 
		    $this->request->data = $this->User->read(null, $this->Auth->user('id')); 
		} 
		$this->_setSelects(); 
		} 
	}
