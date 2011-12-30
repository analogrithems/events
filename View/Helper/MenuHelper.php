<?php

App::uses('AppHelper', 'View/Helper');
class MenuHelper extends AppHelper{


	var $helpers = array('Html','Session');
	var $__style_options = array('activeController'=>'activeController', 'activeLink'=>'activeLink','link'=>'link','odd'=>false,'before'=>null,'after'=>null);

	public function __construct(View $View, $settings = array()) {
		global $menus;
		$this->menu = $menus;
		parent::__construct($View, $settings);
	}

	function ShowMenu( $name = 'Project' ){
		$this->currentURL = $this->request->here();
		//$this->log(':Object:'.print_r($this,true),'debug');
		if(isset($this->menu[$name]) && !empty($this->menu[$name])){
			$menu =  "<div class='".$this->stringToSlug($name)."menu' >".$this->buildMenu($this->menu[$name])."</div>\n";
			return $menu;
		}else{
			return false;
		}
	}

	function buildMenu($tree=false){
		$html = '';
		if($tree==false) return false;
		$i = 0;
		$html .= "<ul>\n";
		foreach($tree as $name=>$leaf){
			if(!isset($leaf['permissions']) ){
				$show = true;
			}elseif(is_string($leaf['permissions'])){
				$user = $this->Session->read('Auth');
				switch($leaf['permissions']){
					case 'any':
					case '*':
						$show = true;
						break;
					case 'anonymous': //This is only for users not logged in
						if(!isset($user['User']['id'])){
							$show = true;
						}else{
							$show = false;
							continue;
						}
						break;
					case 'authed':
						if(isset($user['User']['id'])){
							$show = true;
						}else{
							$show = false;
							continue;
						}
						break;
					default:	//Assume anything else is a group name and check if user is in that group
						$show = true;
						break;
				}
			}else{
				$show = false;
				continue;
			}

			$__style_options = $this->__style_options;
			if(isset($leaf['style'])){
				$__style_options = array_merge($this->__style_options,$leaf['style']);
			}

			$linkClass = '';
			if($__style_options['odd']){
				if ($i++ % 2 == 0) {
					$linkClass .= " {$__style_options['odd']} ";
				}
			}

			if(isset($leaf['img'])){
				$__style_options['before'] = $__style_options['before'].$this->Html->image($leaf['img']['url'],$leaf['img']['options']);
			}
			if(!isset($leaf['options'])) $leaf['options'] = array();

			$id = $this->stringToSlug($name).'-'.$i;
			if($show === true){
				if(isset($leaf['url'])){
					$linkClass .= " {$__style_options['link']} ";
					if($leaf['url']['controller'] == $this->request->params['controller']){
						$linkClass .= " {$__style_options['activeController']} ";
					}
					if(($leaf['url']['controller'] == $this->request->params['controller']) && ($leaf['url']['action'] == $this->request->params['action'])){
						$linkClass .= " {$__style_options['activeLink']} ";
					}
					$html .= "<li id='{$id}' class='{$linkClass}'>".$__style_options['before'].$this->Html->link($name,$leaf['url'],$leaf['options']);
				}else{
					$html .= "<li id='{$id}' class='{$linkClass}'>".$__style_options['before']."{$name}\n";				
					$html .= "<li id='{$id}' class='{$linkClass}'>".$__style_options['before']."{$name}\n";				
				}
			}
					
			if(isset($leaf['children']) && is_array($leaf['children']) && $show ){
				$html .= $this->buildMenu($leaf['children']);
			}else{
				//$this->log("No Child:".print_r($leaf,1),'debug');
			}
			$i++;
			$html .= $__style_options['after']."</li>\n";
		}
		$html .= "</ul>\n";
		return $html;
	}

	function stringToSlug($str) {
		// trim the string
		$str = strtolower(trim($str));
		// replace all non valid characters and spaces with an underscore
		$str = preg_replace('/[^a-z0-9-]/', '_', $str);
		$str = preg_replace('/-+/', "_", $str);
		return $str;
	}

}
