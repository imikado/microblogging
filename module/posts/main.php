<?php 
class module_posts extends abstract_module{
	
	public function before(){
		$this->oLayout=new _layout('template1');
		
		$this->oLayout->addModule('menu','menu::list');
	}
	
	
	public function _index(){
	    //on considere que la page par defaut est la page de listage
	    $this->_list();
	}
	
	public function _list(){
		
		$tPosts=model_posts::getInstance()->findAllOwnerAndFollowed(_root::getAuth()->getAccount()->id);
		$oView=new _view('posts::list');
		$oView->tPosts=$tPosts;

		$this->oLayout->add('main',$oView);
	}
	
	public function listByHashtag($hashtag_id){
		$tPosts=model_posts::getInstance()->findByHashtag($hashtag_id);
		
		$oView=new _view('posts::list');
		$oView->tPosts=$tPosts;
		
		return $oView;
	}
	public function listByMention($member_id){
		$tPosts=model_posts::getInstance()->findAllByMention($member_id);
		
		$oView=new _view('posts::list');
		$oView->tPosts=$tPosts;
		
		return $oView;
	}
	public function listLastByMember($member_id){
		$tPosts=model_posts::getInstance()->findAllLastByMember($member_id);
		
		$oView=new _view('posts::list2');
		$oView->tPosts=$tPosts;
		
		return $oView;
	}

	public function _new(){
		$tMessage=$this->save();
	
		$oPosts=new row_posts;
		
		$oView=new _view('posts::new');
		$oView->oPosts=$oPosts;
		
		
		
		$oPluginXsrf=new plugin_xsrf();
		$oView->token=$oPluginXsrf->getToken();
		$oView->tMessage=$tMessage;
		
		$this->oLayout->add('main',$oView);
	}
	

	public function save(){
		if(!_root::getRequest()->isPost() ){ //si ce n'est pas une requete POST on ne soumet pas
			return null;
		}
		
		$oPluginXsrf=new plugin_xsrf();
		if(!$oPluginXsrf->checkToken( _root::getParam('token') ) ){ //on verifie que le token est valide
			return array('token'=>$oPluginXsrf->getMessage() );
		}
	
		$iId=_root::getParam('id',null);
		if($iId==null){
			$oPosts=new row_posts;	
		}else{
			$oPosts=model_posts::getInstance()->findById( _root::getParam('id',null) );
		}
		
		$tId=model_posts::getInstance()->getIdTab();
		$tColumn=model_posts::getInstance()->getListColumn();
		foreach($tColumn as $sColumn){
			 if(isset($_FILES[$sColumn]) and $_FILES[$sColumn]['size'] > 0){
				$sNewFileName=_root::getConfigVar('path.upload').$sColumn.'_'.date('Ymdhis');

				$oPluginUpload=new plugin_upload($_FILES[$sColumn]);
				$oPluginUpload->saveAs($sNewFileName);
				$oPosts->$sColumn=$oPluginUpload->getPath();
				continue;	
			}else  if( _root::getParam($sColumn,null) === null ){ 
				continue;
			}else if( in_array($sColumn,$tId)){
				 continue;
			}
			
			$oPosts->$sColumn=_root::getParam($sColumn,null) ;
		}
		//on force l'id du membre
		$oPosts->member_id=_root::getAuth()->getAccount()->id;
		
		
		if($oPosts->save()){
			//une fois enregistre on redirige (vers la page liste)
			_root::redirect('posts::list');
		}else{
			return $oPosts->getListError();
		}
		
	}

	
	public function after(){
		$this->oLayout->show();
	}
	
	
}

/*variables
#select		$oView->tJoinposts=posts::getInstance()->getSelect();#fin_select
#uploadsave if(isset($_FILES[$sColumn]) and $_FILES[$sColumn]['size'] > 0){
				$sNewFileName=_root::getConfigVar('path.upload').$sColumn.'_'.date('Ymdhis');

				$oPluginUpload=new plugin_upload($_FILES[$sColumn]);
				$oPluginUpload->saveAs($sNewFileName);
				$oPosts->$sColumn=$oPluginUpload->getPath();
				continue;	
			}else #fin_uploadsave
variables*/

