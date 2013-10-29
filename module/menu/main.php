<?php 
class module_menu extends abstract_module{
	
	
	public function _list(){
	
		$tLink=array(
			
			'Votre fil' => array('posts','list'),
			'Hashtag' => array('hashtags','list'),
			'Mention' => array('mentions','list'),
			
			'Votre profil' => array('profil','index'),
		);
	
		$oView=new _view('menu::list');
		$oView->tLink=$tLink;
		
		return $oView;
	}
	
	
	
}
