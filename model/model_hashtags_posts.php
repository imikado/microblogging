<?php
class model_hashtags_posts extends abstract_model{
	
	protected $sClassRow='row_hashtags_posts';
	
	protected $sTable='hashtags_posts';
	protected $sConfig='microblogging';
	
	protected $tId=array('id');

	public static function getInstance(){
		return self::_getInstance(__CLASS__);
	}

	public function findById($uId){
		return $this->findOne('SELECT * FROM '.$this->sTable.' WHERE id=?',$uId );
	}
	public function findAll(){
		return $this->findMany('SELECT * FROM '.$this->sTable);
	}
	
	
}

class row_hashtags_posts extends abstract_row{
	
	protected $sClassModel='model_hashtags_posts';
	
	/*exemple jointure 
	public function findAuteur(){
		return model_auteur::getInstance()->findById($this->auteur_id);
	}
	*/
	/*exemple test validation*/
	private function getCheck(){
		$oPluginValid=new plugin_valid($this->getTab());
		/* renseigner vos check ici
		$oPluginValid->isEqual('champ','valeurB');
		$oPluginValid->isNotEqual('champ','valeurB');
		$oPluginValid->isUpperThan('champ','valeurB');
		$oPluginValid->isUpperOrEqualThan('champ','valeurB');
		$oPluginValid->isLowerThan('champ','valeurB');
		$oPluginValid->isLowerOrEqualThan('champ','valeurB');
		$oPluginValid->isEmpty('champ');
		$oPluginValid->isNotEmpty('champ');
		$oPluginValid->isEmailValid('champ');
		$oPluginValid->matchExpression('champ','/[0-9]/');
		$oPluginValid->notMatchExpression('champ','/[a-zA-Z]/');
		*/

		return $oPluginValid;
	}

	public function isValid(){
		return $this->getCheck()->isValid();
	}
	public function getListError(){
		return $this->getCheck()->getListError();
	}
	public function save(){
		if(!$this->isValid()){
			return false;
		}
		parent::save();
		return true;
	}

}
