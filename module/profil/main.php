<?php 
class module_profil extends abstract_module{
	
	public function before(){
		$this->oLayout=new _layout('template1');
		
		$this->oLayout->addModule('menu','menu::list');
	}
	
	
	public function _index(){
	    //on considere que la page par defaut est la page d'affichage de profil
	    $this->_show();
	}
	

	public function _new(){
		$tMessage=$this->save();
	
		$oMembers=new row_members;
		
		$oView=new _view('profil::new');
		$oView->oMembers=$oMembers;
		
		
		
		$oPluginXsrf=new plugin_xsrf();
		$oView->token=$oPluginXsrf->getToken();
		$oView->tMessage=$tMessage;
		
		$this->oLayout->add('main',$oView);
	}
	
	
	public function _edit(){
		$tMessage=$this->save();
		
		//recuperation de l'id notre membre connecte
		$member_id=_root::getAuth()->getAccount()->id;
	    $oMembers=model_members::getInstance()->findById( $member_id );
		
		$oView=new _view('profil::edit');
		$oView->oMembers=$oMembers;
		$oView->tId=model_members::getInstance()->getIdTab();
		
		$oPluginXsrf=new plugin_xsrf();
		$oView->token=$oPluginXsrf->getToken();
		$oView->tMessage=$tMessage;
		
		$this->oLayout->add('main',$oView);
	}

	public function _show(){
		//recuperation de l'id notre membre connecte
		$member_id=_root::getAuth()->getAccount()->id;
	    $oMembers=model_members::getInstance()->findById( $member_id );
		
		$oView=new _view('profil::show');
		$oView->oMembers=$oMembers;
		
		$tMember=model_members::getInstance()->findAll();
		$oView->tMember=$tMember;
		
		$tFollowed=model_followers::getInstance()->findListIndexedFollowedByMember($member_id);
		$oView->tFollowed=$tFollowed;
		
		
		$this->oLayout->add('main',$oView);
	}
	
	public function _showother(){
		$oMembers=model_members::getInstance()->findByLogin(_root::getParam('name'));
		
		if($oMembers){
			$oView=new _view('profil::showother');
			$oView->oMembers=$oMembers;
			
			$oModulePosts=new module_posts;
			$oViewPosts=$oModulePosts->listLastByMember($oMembers->id);
			
			$oView->oViewPosts=$oViewPosts;
		}else{
			$oView=new _view('profil::showothernotfound');
		}
		
		$this->oLayout->add('main',$oView);
		
		
	}
	
	public function _follow(){
		
		model_followers::getInstance()->followForMember(_root::getParam('member_id'),_root::getAuth()->getAccount()->id);
		
		model_members::getInstance()->calculFollower(_root::getParam('member_id'));
		
		model_members::getInstance()->calculSubscription(_root::getAuth()->getAccount()->id);
		
		_root::redirect('profil::show');
	}
	public function _unfollow(){
		model_followers::getInstance()->unfollowForMember(_root::getParam('member_id'),_root::getAuth()->getAccount()->id);
		
		model_members::getInstance()->calculFollower(_root::getParam('member_id'));

		model_members::getInstance()->calculSubscription(_root::getAuth()->getAccount()->id);
		
		_root::redirect('profil::show');
	}
	
	
	
	
	public function save(){
		if(!_root::getRequest()->isPost() ){ //si ce n'est pas une requete POST on ne soumet pas
			return null;
		}
		
		$oPluginXsrf=new plugin_xsrf();
		if(!$oPluginXsrf->checkToken( _root::getParam('token') ) ){ //on verifie que le token est valide
			return array('token'=>$oPluginXsrf->getMessage() );
		}
	
		$oMembers=_root::getAuth()->getAccount();
		
		$tId=model_members::getInstance()->getIdTab();
		$tColumn=model_members::getInstance()->getListColumn();
		foreach($tColumn as $sColumn){
			 if(isset($_FILES[$sColumn]) and $_FILES[$sColumn]['size'] > 0){
				$sNewFileName=_root::getConfigVar('path.upload').$sColumn.'_'.date('Ymdhis');

				$oPluginUpload=new plugin_upload($_FILES[$sColumn]);
				$oPluginUpload->saveAs($sNewFileName);
				$oMembers->$sColumn=$oPluginUpload->getPath();
				continue;	
			}else  if( _root::getParam($sColumn,null) === null ){ 
				continue;
			}else if( in_array($sColumn,$tId)){
				 continue;
			}
			
			$oMembers->$sColumn=_root::getParam($sColumn,null) ;
		}
		
		if($oMembers->save()){
			//une fois enregistre on redirige (vers la page d'affichage)
			_root::redirect('profil::show');
		}else{
			return $oMembers->getListError();
		}
		
	}
	
	public function after(){
		$this->oLayout->show();
	}
	
	
}

/*variables
#select		$oView->tJoinmembers=members::getInstance()->getSelect();#fin_select
#uploadsave if(isset($_FILES[$sColumn]) and $_FILES[$sColumn]['size'] > 0){
				$sNewFileName='data/upload/'.$sColumn.'_'.date('Ymdhis');

				$oPluginUpload=new plugin_upload($_FILES[$sColumn]);
				$oPluginUpload->saveAs($sNewFileName);
				$oMembers->$sColumn=$oPluginUpload->getPath();
				continue;	
			}else #fin_uploadsave
variables*/

