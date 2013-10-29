<?php 
class module_mentions extends abstract_module{
	
	public function before(){
		$this->oLayout=new _layout('template1');
		
		$this->oLayout->addModule('menu','menu::list');
	}
	/* #debutaction#
	public function _exampleaction(){
	
		$oView=new _view('examplemodule::exampleaction');
		
		$this->oLayout->add('main',$oView);
	}
	#finaction# */
	
	
	public function _list(){
	
		$oMember=_root::getAuth()->getAccount();
	
		$oView=new _view('mentions::list');
		$oView->oMember=$oMember;
		
		$this->oLayout->add('main',$oView);
		
		$oModulePost=new module_posts;
		$oViewPost=$oModulePost->listByMention($oMember->id);
		
		$this->oLayout->add('main',$oViewPost);
	}
	
	
	public function after(){
		$this->oLayout->show();
	}
	
	
}
