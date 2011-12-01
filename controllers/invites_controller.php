<?php
class InvitesController extends AppController {

	var $name = 'Invites';
	var $components = array('Email');
	var $uses = array('Event', 'Invite');

        function beforeFilter(){
                $this->LDAPAuth->allow('index','view','sendInvite', 'optOut');
		parent::beforeFilter();
        }

	function optOut($id=null){
		if(!$id) return false;
		$invitee = $this->Invite->read(null, $id);
		$invitee['Invite']['opted_out'] = 'Yes';
		$this->Invite->save($invitee);
		$this->set('invitee', $invitee);
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid invite', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('invite', $this->Invite->read(null, $id));
	}

	function admin_index() {
		$this->log("Current User is:".print_r($this->user,1),'debug');
		$this->Invite->recursive = 0;
			
		$this->set('invites', $this->paginate("Invite", array('Event.user_id'=>$this->user['User']['id'])));
	}



	function admin_view_event($id = false) {
		if($id == false) return false;
		
		//Lets see if we own the event we are trying to edit.
		if($event = $this->Invite->Event->isOwner($id)){
			if($this->user['User']['id'] == $event['Event']['user_id']){
				$this->paginate = array( 'Invite'=>array('recursive' => -1));
				$invites = $this->paginate("Invite", array('Invite.event_id'=>$event['Event']['id']));
				$this->set('invites', $invites);
				$this->set('event', array('id'=>$event['Event']['id']));
			}else{
				$this->Session->setFlash(__('Permission Denied!', true));
				$this->redirect(array('controller'=>'events', 'action' => 'index'));
				$this->log("You are trying to access event {$id} and you are not authorized.  Current user info:".print_r($this->user,1),'auth');
			}
		}

	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid invite', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('invite', $this->Invite->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Invite->create();
			if ($this->Invite->save($this->data)) {
				$this->Session->setFlash(__('The invite has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The invite could not be saved. Please, try again.', true));
			}
		}
		$events = $this->Invite->Event->find('list');
		$this->set(compact('events'));
	}

	function admin_edit($id = null, $eventUUID = null) {
		if ( $this->RequestHandler->isAjax() ) {
			Configure::write('debug',0);
		}
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid invite', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Invite->save($this->data)) {
				$this->Session->setFlash(__('The invite has been saved', true));
				$this->redirect(array('controller'=>'invites', 'action' => 'view_event',$eventUUID));
			} else {
				$this->Session->setFlash(__('The invite could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Invite->find('first',array('conditions'=>array('Invite.id'=>$id)));
		}
		$event = $this->Invite->Event->isOwner($this->data['Invite']['event_id'],'id');
		$this->log("Invite::admin_edit user:".print_r($this->user,1).':'.print_r($event,1),'debug');
		if($this->user['User']['id'] == $event['Event']['user_id']){
			//This user is the owner and has permission continue
			$this->set(compact('events'));
		}else{
			$this->Session->setFlash(__('Permission Denied!', true));
			$this->redirect(array('controller'=>'events', 'action' => 'index'));
			return false;
		}
	}

	function admin_resend($id=null,$eventUUID = null){
		if (!$id) {
			$this->Session->setFlash(__('Invalid invite', true));
			if($eventUUID) $this->redirect(array('controller'=>'events', 'action'=>'index'));
			else return false;
		}
		$this->Invite->recursive = -1;
		$invite = $this->Invite->find('first',array('conditions'=>array('Invite.id'=>$id)));
		if($invite['Invite']['opted_out'] == 'No') $invite['Invite']['sent'] = 'No';
		if( $result = $this->Invite->save($invite)){
			$this->log("Resending invite for {$id}:".print_r($invite,1),'debug');
			$this->Session->setFlash(__('Scheduled Invite To Be Resent.', true));
			if($eventUUID) $this->redirect(array('controller'=>'invites','action'=>'view_event',$eventUUID));
			else return true;
		}
		$this->Session->setFlash(__('Invite was not deleted', true));
		if($eventUUID) $this->redirect(array('action' => 'index'));
		else return false;
	}

	function admin_delete($id = null,$eventUUID = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid invite given, is someone being nosy....', true));
			if($eventUUID) $this->redirect(array('controller'=>'invites', 'action'=>'view_event',$eventUUID));
			else return false;
		}
		if ($this->Invite->delete($id)) {
			$this->Session->setFlash(__('Invite deleted', true));
			if($eventUUID) $this->redirect(array('controller'=>'invites', 'action'=>'view_event',$eventUUID));
			else return true;
		}
		$this->Session->setFlash(__('Invite was not deleted', true));
		if($eventUUID) $this->redirect(array('controller'=>'invites', 'action'=>'view_event',$eventUUID));
		else return false;
	}

	function sendInvite($id = null){
		$this->log("Calling sendInvite",'debug');
		if($id == null) return false;
		$invitee = $this->Invite->read(null,$id);
		
		if($invitee['Invite']['sent'] == 'Yes' || $invitee['Invite']['opted_out'] == 'Yes') return false;
		//$this->Email->delivery = 'debug';
		$this->Email->sendAs = Configure::read('Email.Format');
		$this->Email->subject = $invitee['Event']['name'];
		$this->Email->from = $invitee['Event']['User']['email'];
		$this->Email->replyTo = 'no-reply@asynonymous.net';
		$this->Email->to = $invitee['Invite']['email'];
		$this->Email->tempalte = 'invite';
		$this->set('content', $invitee['Event']['details']);
		$this->set('url', Configure::read('Events.URL'));
		$this->set('id', $invitee['Invite']['id']);
		$this->set('invitee', $invitee);

		//Lets send the email
		$sent = $this->Email->send($invitee['Event']['details'],'invite');
		$this->log("Email Log:".print_r($this->Email->smtpError,1),'debug');
		if($sent){
			$this->log("Sent email to:".$invitee['Invite']['email'],'debug');
			$invitee['Invite']['sent'] = 'Yes';
			$this->Invite->save($invitee);
		}else{
			$error = !empty($this->Email->smtpError) ? $this->Email->smtpError : '';
			$this->log("Failed to send to:". $invitee['Invite']['email']. ":".print_r($error,1).":".print_r($invitee,1),'error');
		}

		$this->Email->reset();
		return true;
	}

	function admin_bulkUpdate(){
		$this->log("Data I got:".print_r($this->data,1),'debug');
		if(!empty($this->data)){
			if(isset($this->data['Invite']['cmd'])){
				$this->log("Data is not Empty",'debug');
				switch($this->data['Invite']['cmd']){
					case 'resend':
						$this->log("Doing Bulk Resend",'debug');
						if(isset($this->data['Invite']['id']) && is_array($this->data['Invite']['id']) ){
							$result = '';
							foreach($this->data['Invite']['id'] as $invite){
								$this->admin_resend($invite);
							}
						}
						break;
					case 'delete':
						$this->log("Doing Bulk Delete",'debug');
						if(isset($this->data['Invite']['id']) && is_array($this->data['Invite']['id']) ){
							$result = '';
							foreach($this->data['Invite']['id'] as $invite){
								$this->admin_delete($invite);
							}
						}
						break;
					default:
						$this->log("Doing Bulk Delete",'debug');
						$this->Session->setFlash(__('Invalid Bulk Option', true));
						break;
				}
			}
		}
		$this->redirect(array('controller'=>'invites', 'action'=>'view_event',$this->data['event']['id']));
		
	}
}
