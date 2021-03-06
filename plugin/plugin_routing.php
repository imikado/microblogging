<?php
/*
This file is part of Mkframework.

Mkframework is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License.

Mkframework is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Mkframework.  If not, see <http://www.gnu.org/licenses/>.

*/
/**
* plugin_rss classe gerant l'url rewriting
* @author Mika
* @link http://mkf.mkdevs.com/
*/
class plugin_routing{
	
	private $tRoute;
	
	/** 
	* constructeur
	* @access public
	*/
	public function __construct(){
		include(_root::getConfigVar('urlrewriting.conf'));
		$this->tRoute=$tab;
	}
	
	/** 
	* retourne l'url rewrite 
	* @access public
	* @param string $sNav variable de navigation exple article::list
	* @param array $tParam tableau de parametre
	* @param bool $bAmp retourne l'url avec ou sans les &amp;
	*/
	public function getLink($sNav,$tParam=null,$bAmp=null){
		foreach($this->tRoute as $sUrl=>$tUrl){
			if($tUrl['nav']==$sNav){
				$ok=0;
				
				if(!isset($tUrl['tParam']) ){
					if($tParam==null){
						$ok=1;//si pas de parametres des deux cotes, c est la bonne regle
					}
				}elseif(is_array($tUrl['tParam']) ){
					if(is_array($tParam)  ){
						$tmpok=1;
						foreach($tUrl['tParam'] as $val){
							if(!isset($tParam[$val])){
								$tmpok=0;	
								break;
							}
						}
						if($tmpok==1){
							$ok=1;//si la regle demande des parametres, tous presents dans les parametres passes on choisi celle-ci
						}
											
					}
				}
				
				if($ok==1){
					return $this->convertUrl($sUrl,$tParam);
					break;
				}
			}
		}
		return _root::getLinkString($sNav,$tParam,$bAmp);
	}
	/** 
	* parse l'url rewrite pour en extraire les parametres (nav, parametres...) 
	* @access public
	* @param string $sUrl url
	*/
	public function parseUrl($sUrl){
		/*LOG*/_root::getLog()->info('plugin_routing parseUrl('.$sUrl.')');
		if(is_array($this->tRoute)){
			foreach($this->tRoute as $sPattern => $tUrl){
				$sPattern=preg_replace('/:(.)*:/','(.*)',$sPattern);
				$sPattern=preg_replace('/\//','\/',$sPattern);
				
				if(preg_match_all('/'.$sPattern.'/',$sUrl,$tTrouve)){
					_root::getRequest()->loadModuleAndAction($tUrl['nav']);
					if(isset($tUrl['tParam']) and is_array($tTrouve[1]))
					foreach($tTrouve[1] as $i => $found){
						_root::setParam($tUrl['tParam'][$i],$found);
					}
					return;
				}
			}
			/*LOG*/_root::getLog()->info('plugin_routing regle non trouve, utilisation de 404 loadModuleAndAction('.$this->tRoute['404']['nav'].')');
			_root::getRequest()->loadModuleAndAction($this->tRoute['404']['nav']);
		}
	}
	
	private function convertUrl($sUrl,$tParam=null){
		if(is_array($tParam)){
			foreach($tParam as $sVar => $sVal){
				$sUrl=preg_replace('/:'.$sVar.':/',$sVal,$sUrl);
			}
		}
		return $sUrl;
	}



}
