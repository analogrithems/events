<?php
/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       cake
 * @subpackage    cake.cake.libs.controller
 */
class PagesController extends AppController {

	var $name = 'Pages';
        var $components = array('DebugKit.Toolbar','Idbroker.LDAPAuth'=>array('homeLanding'=>'/'), 'Session');
        var $helpers = array('Html', 'Form', 'Cksource', 'Ajax', 'Js'=>array('Jquery'),'Javascript');
        var $user;


/**
 * Displays a view
 *
 * @param mixed What page to display
 * @access public
 */
	function display() {
		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			$this->redirect('/');
		}
		$page = $subpage = $title_for_layout = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title_for_layout = Inflector::humanize($path[$count - 1]);
		}
		if(isset($page) && is_numeric($page)){
			$cond = array( 'Page.id'=>$page );
		}elseif(isset($page) && is_string($page)){
			$cond = array( 'Page.slug'=>$page );
		}
		if($post = $this->Page->find('first',array('conditions'=>$cond))){
			$this->log("Rendering Static Page:".print_r($page,1)."\tSubpage:".print_r($subpage,1),'debug');
			$this->set('page',$page);
			//TODO chane to acl check
			if(isset($this->user['id'])){
				$this->render('admin_view');
			}else{
				$this->render('view');
			}
		}else{
			$this->set('auth',$this->Session->read('Auth'));
			$this->set(compact('page', 'subpage', 'title_for_layout'));
			$this->render(implode('/', $path));
		}
	}

        function beforeFilter(){
                $this->LDAPAuth->allow('index','view', 'display');
                if($this->RequestHandler->isAjax()){
                    Configure::write('debug', 0);// and forget debug messages
                    $this->layout = 'ajax'; //or try with $this->layout = '';
                }
                parent::beforeFilter();
        } 

        function admin_view($id) {
            $this->Page->id = $id;
            $post = $this->Page->read();
            $revisions = $this->Page->revisions($id);
            $users = $this->Page->User->find('list');
            $this->set(compact('post','revisions','users'));
        }
	// [..] 
	function admin_undo($id) { 
	    $this->Page->id = $id; 
	    $this->Page->undo(); 
	    $this->redirect(array('action'=>'view',$id)); 
	} 
	// [..] 
	function make_current($id, $version_id) { 
	    $this->Page->id = $id; 
	    $this->Page->revertTo($version_id); 
	    $this->redirect(array('action'=>'view',$id));
	} 
	function admin_add() {
		$this->layout = 'dashboard';
		if (!empty($this->data)) {
			$this->data['Page']['user_id'] = $this->user['User']['id'];
			$this->Page->create();
			if ($this->Page->save($this->data)) {
				$this->Session->setFlash(__('The page has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The page could not be saved. Please, try again.', true));
			}
		}
		$users = $this->Page->User->find('list');
		$this->set(compact('users'));
	}

	function admin_edit($id = null) {
		$this->layout = 'dashboard';
		$this->Page->id = $id; //important for read,shadow and revisions call bellow 
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid page', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->log("Trying to save: ".print_r($this->data,1),'debug');
			if ($foo = $this->Page->save($this->data)) {
				$this->Session->setFlash(__('The page has been saved, with this data:'.print_r($this->data,1).':'.print_r($foo,1), true));
				//$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The page could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
		    $this->data = $this->Page->read(); 
		}
		$users = $this->Page->User->find('list');
		$revisions = $this->Page->revisions($id);
		$this->set(compact('users','revisions')); 
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for page', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Page->delete($id)) {
			$this->Session->setFlash(__('Page deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Page was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
        function admin_index() {
		$this->layout = 'dashboard';
                $this->Page->recursive = 0;
                $this->set('pages', $this->paginate());
        }
}
