<?php 
class module_hashtags extends abstract_module{
	
	public function before(){
		$this->oLayout=new _layout('template1');
		
		$this->oLayout->addModule('menu','menu::list');
	}
	
	
	public function _index(){
	    //on considere que la page par defaut est la page de listage
	    $this->_list();
	}
	
	public function _list(){
		
		$tHastags=model_hashtags::getInstance()->findAll();
		
		$oView=new _view('hashtags::list');
		$oView->tHastags=$tHastags;
		
		

		$this->oLayout->add('main',$oView);
	}
	

	public function _show(){
		$oHastags=model_hashtags::getInstance()->findByName( _root::getParam('name') );
		
		$oView=new _view('hashtags::show');
		$oView->oHastags=$oHastags;
		
		$this->oLayout->add('main',$oView);
		
		$oModulePost=new module_posts;
		$oViewPost=$oModulePost->listByHashtag($oHastags->id);
		
		$this->oLayout->add('main',$oViewPost);
	}
	
	
	public function after(){
		$this->oLayout->show();
	}
	
	
}

/*variables
#select		$oView->tJoinhastags=hastags::getInstance()->getSelect();#fin_select
#uploadsave if(isset($_FILES[$sColumn]) and $_FILES[$sColumn]['size'] > 0){
				$sNewFileName=_root::getConfigVar('path.upload').$sColumn.'_'.date('Ymdhis');

				$oPluginUpload=new plugin_upload($_FILES[$sColumn]);
				$oPluginUpload->saveAs($sNewFileName);
				$oHastags->$sColumn=$oPluginUpload->getPath();
				continue;	
			}else #fin_uploadsave
variables*/

