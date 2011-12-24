<?php


class MenuHelper extends AppHelper{


	var $helpers = array('Html','Session');
	var $__style_options = array('activeController'=>'activeController', 'activeLink'=>'activeLink','link'=>'link','odd'=>false,'before'=>null,'after'=>null);

	function __construct(){
		global $menus;
		$this->menu = $menus;
		$this->currentURL = $this->here;
	}

	function showMenu( $name = 'Project' ){
		$this->Session->activate();
		if(isset($this->menu[$name]) && !empty($this->menu[$name])){
			$menu =  "<div class='".$this->stringToSlug($name)."menu' >".$this->buildMenu($this->menu[$name])."</div>\n";
			return $menu;
		}else{
			$this->log("No menu found!".print_r($this->menu,1),'error');
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
				$this->log("Check link permissions:".print_r($leaf['permissions'],1).':Session:'.print_r($user,1),'debug');
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
				$this->log("Permissions:".print_r($leaf,1),'debug');
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
					if($leaf['url']['controller'] == $this->params['controller']){
						$linkClass .= " {$__style_options['activeController']} ";
					}
					if(($leaf['url']['controller'] == $this->params['controller']) && ($leaf['url']['action'] == $this->params['action'])){
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
				$this->log("Child Menu:".print_r($html,1),'debug');
			}else{
				$this->log("No Child:".print_r($leaf,1),'debug');
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
