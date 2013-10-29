<?php
class model_hashtags extends abstract_model{
	
	protected $sClassRow='row_hashtags';
	
	protected $sTable='hashtags';
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
	
	public function findByName($uId){
		return $this->findOne('SELECT * FROM '.$this->sTable.' WHERE name=?',$uId );
	}
	
	
	public function addForPost($sHashtag,$post_id){
		//recherche du hashtag par son nom
		$oHashtag=$this->findByName($sHashtag);
		if($oHashtag){ 
			//si on trouve le hashtag en base, on incremente sa notoriete
			$oHashtag->nb_posts=$oHashtag->nb_posts+1;
		}else{
			//si on ne le trouve pas on créé ce hashtag
			$oHashtag=new row_hashtags;
			$oHashtag->name=$sHashtag;
			$oHashtag->nb_posts=1;			
		}
		$oHashtag->dateLastUse=date('Y-m-d H:i:s');
		$oHashtag->save();
		
		//on sauvegarde le lien post/hashtag
		$oHashtagPost=new row_hashtags_posts;
		$oHashtagPost->post_id=$post_id;
		$oHashtagPost->hashtag_id=$oHashtag->id;
		$oHashtagPost->save();
	}
	
	public function findAllHashtags($sText){
		$sText.=' ';
		preg_match_all('/#([0-9a-zA-Z]*) /',$sText,$tHashtag);
		if(isset($tHashtag[1])){
			return $tHashtag[1];
		}
		return null;
	}
	
	
}

class row_hashtags extends abstract_row{
	
	protected $sClassModel='model_hashtags';
	
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
