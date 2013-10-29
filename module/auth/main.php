<?php 
class module_auth extends abstract_module{
	
	public function before(){
		$this->oLayout=new _layout('template1');
		
		//$this->oLayout->addModule('menu','menu::index');
	}
	/* #debutaction#
	public function _exampleaction(){
	
		$oView=new _view('examplemodule::exampleaction');
		
		$this->oLayout->add('main',$oView);
	}
	#finaction# */
	
	
	public function _login(){
		$sMessage=$this->tryLogin();
	
		$oView=new _view('auth::login');
		$oView->sMessage=$sMessage;
		
		$this->oLayout->add('main',$oView);
	}
	private function tryLogin(){
		if(!_root::getRequest()->isPost()){
			return null;
		}
		
		$sLogin=_root::getParam('login');
		//on stoque les mots de passe hashé en sha1 pour l'exemple
		$sPassword=sha1('tutorialSalt'._root::getParam('password'));
		$tAccount=model_members::getInstance()->getListAccount();

		//on va verifier que l'on trouve dans le tableau retourné par notre model "account"
		//l'entrée $tAccount[ login ][ mot de passe hashé* ]
		if(_root::getAuth()->checkLoginPass($tAccount,$sLogin,$sPassword)){
			_root::redirect('profil::index');
		}else{
			return 'Login/mot de passe incorrect';
		}
	}
	
	
	public function _logout(){
	
		_root::getAuth()->logout();
	}
	
	public function _inscription(){
		$tMessage=$this->saveInscription();
	
		$oView=new _view('auth::inscription');
		$oView->tMessage=$tMessage;
		
		$this->oLayout->add('main',$oView);
	}
	private function saveInscription(){
		if(!_root::getRequest()->isPost()){
			return null;
		}
		
		$oPluginValid=new plugin_valid(_root::getRequest()->getParams());
		$oPluginValid->isNotEmpty('login','Vous devez saisir un nom d\'utilisateur');
		$oPluginValid->matchExpression('login','/^[0-9a-zA-Z]*$/','Le login ne prend que les caract&eacute;res a-Z 0-9');
		$oPluginValid->isNotEmpty('password','Vous devez saisir un mot de passe');
		$oPluginValid->isEqual('password',_root::getParam('password2'),'Les deux mots de passes doivent &ecirc;tre identique');
		$oPluginValid->isLoginUnique('login','Ce nom d\'utilisateur n\'est pas unique');
		
		if($oPluginValid->isValid()){
			$oMember=new row_members;
			$oMember->login=_root::getParam('login');
			$oMember->pass=sha1( 'tutorialSalt'._root::getParam('password'));
			$oMember->picture=_root::getConfigVar('path.upload').'defaultavatar.png';
			$oMember->save();
			
			_root::redirect('auth::login');
		}else{
			return $oPluginValid->getListError();
		}
	}
	
	public function after(){
		$this->oLayout->show();
	}
	
	
}
