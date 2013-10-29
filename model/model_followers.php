<?php
class model_followers extends abstract_model{
	
	protected $sClassRow='row_followers';
	
	protected $sTable='followers';
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
	
	public function findListIndexedFollowedByMember($member_id){
		$tFollowed=$this->findMany('SELECT * FROM '.$this->sTable.' WHERE follower_member_id=?',$member_id);
		
		$tIndexed=array();
		if($tFollowed)
		foreach($tFollowed as $oFollowed){
			$tIndexed[$oFollowed->member_id]=$oFollowed->member_id;
		}
		return $tIndexed;
	}
		
	public function followForMember($member_id,$follower_member_id){
		$this->unfollowForMember($member_id,$follower_member_id);
		
		$oFollow=new row_followers;
		$oFollow->member_id=_root::getParam('member_id');
		$oFollow->follower_member_id=_root::getAuth()->getAccount()->id;
		$oFollow->save();
	}
	
	public function unfollowForMember($member_id,$follower_member_id){
		$this->execute('DELETE FROM followers WHERE member_id=? AND follower_member_id=?',$member_id,$follower_member_id);
	}
	
	
}

class row_followers extends abstract_row{
	
	protected $sClassModel='model_followers';
	
	/*exemple jointure 
	public function findAuteur(){
		return model_auteur::getInstance()->findById($this->auteur_id);
	}
	*/
	/*exemple test validation*/
	private function getCheck(){
		$oPluginValid=new plugin_valid($this->getTab());
		/* renseigner vos check ici
		$oPluginValid->isEqual('champ','valeurB','Le champ n\est pas &eacute;gal &agrave; '.$valeurB);
		$oPluginValid->isNotEqual('champ','valeurB','Le champ est &eacute;gal &agrave; '.$valeurB);
		$oPluginValid->isUpperThan('champ','valeurB','Le champ n\est pas sup&eacute; &agrave; '.$valeurB);
		$oPluginValid->isUpperOrEqualThan('champ','valeurB','Le champ n\est pas sup&eacute; ou &eacute;gal &agrave; '.$valeurB);
		$oPluginValid->isLowerThan('champ','valeurB','Le champ n\est pas inf&eacute;rieur &agrave; '.$valeurB);
		$oPluginValid->isLowerOrEqualThan('champ','valeurB','Le champ n\est pas inf&eacute;rieur ou &eacute;gal &agrave; '.$valeurB);
		$oPluginValid->isEmpty('champ','Le champ n\'est pas vide');
		$oPluginValid->isNotEmpty('champ','Le champ ne doit pas &ecirc;tre vide');
		$oPluginValid->isEmailValid('champ','L\email est invalide');
		$oPluginValid->matchExpression('champ','/[0-9]/','Le champ n\'est pas au bon format');
		$oPluginValid->notMatchExpression('champ','/[a-zA-Z]/','Le champ ne doit pas &ecirc;tre a ce format');
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
