<?php 
class module_default extends abstract_module{
	
	public function before(){
		$this->oLayout=new _layout('template1');
	}
	
	public function _index(){
	    _root::redirect('profil::index');
	}
	
	public function after(){
		$this->oLayout->show();
	}
}
