<?php
class model_posts extends abstract_model{
	
	protected $sClassRow='row_posts';
	
	protected $sTable='posts';
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
	
	public function findAllOwnerAndFollowed($members_id){
		return $this->findMany('SELECT posts.* FROM '.$this->sTable.' LEFT OUTER JOIN followers ON followers.member_id=posts.member_id WHERE posts.member_id=? OR followers.follower_member_id=? ORDER BY posts.id DESC',$members_id,$members_id);
	}
	
	
	public function findByHashtag($uId){
		return $this->findMany('SELECT posts.* FROM '.$this->sTable.',hashtags_posts WHERE posts.id=hashtags_posts.post_id AND hashtag_id=?',$uId );
	}
	
	public function findAllByMention($uId){
		return $this->findMany('SELECT posts.* FROM '.$this->sTable.',mentions WHERE posts.id=mentions.post_id AND mentions.member_id=?',$uId );
	}
	
	
	public function findAllLastByMember($member_id){
		return $this->findMany('SELECT * FROM '.$this->sTable.' WHERE member_id=? ORDER BY id DESC',$member_id);
	}
	
}

class row_posts extends abstract_row{
	
	protected $sClassModel='model_posts';
	
	/*exemple jointure 
	public function findAuteur(){
		return model_auteur::getInstance()->findById($this->auteur_id);
	}
	*/
	public function findMember(){
		return model_members::getInstance()->findById($this->member_id);
	}
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
		
		$this->dateCreation=date('Y-m-d H:i:s');
		
		parent::save();
		
		//on incremente notre nombre de posts
		$oMember=$this->findMember();
		$oMember->nb_posts=$oMember->nb_posts+1;
		$oMember->save();
		
		//on en profilte pour enregistrer les tags et les mentions
		
		//les tags
		$tHashtags=model_hashtags::getInstance()->findAllHashtags($this->text);
		if($tHashtags){
			foreach($tHashtags as $sHashtag){
				$sHashtag=trim($sHashtag);
				model_hashtags::getInstance()->addForPost($sHashtag,$this->id);
			}
		}
		
		//les mentions
		$tMentions=model_mentions::getInstance()->findAllMention($this->text);
		if($tMentions){
			foreach($tMentions as $sLogin){
				model_mentions::getInstance()->addForPost($sLogin,$this->id);
			}
		}
		
		return true;
	}

}
