<h1>Tweets</h1>
<table class="tb_posts">
	
	
	<?php if($this->tPosts):?>
	<?php foreach($this->tPosts as $oPosts):?>
		<?php
			$oMember=$oPosts->findMember();
			$oDate=new plugin_datetime($oPosts->dateCreation);
			$sDate=$oDate->toString('d/m/Y &\a\g\r\a\v\e; H\hi');
			$tHashtags=model_hashtags::getInstance()->findAllHashtags($oPosts->text);
			$sText=$oPosts->text.' ';
			foreach($tHashtags as $sHashtags){
				$sLink='<a href="'._root::getLink('hashtags::show',array('name'=>$sHashtags)).'">#'.$sHashtags.'</a> ';
				$sText=preg_replace('/#'.$sHashtags.'/',$sLink,$sText);
			}
			
			$tMentions=model_mentions::getInstance()->findAllMention($oPosts->text);
			foreach($tMentions as $sMention){
				$sLink='<a href="'._root::getLink('profil::showother',array('name'=>$sMention)).'">@'.$sMention.'</a> ';
				$sText=preg_replace('/@'.$sMention.'/',$sLink,$sText);
			}
		?>
		
		<tr <?php echo plugin_tpl::alternate(array('','class="alt"'))?>>
			
			<td style="width:22px"><img style="width:20px" src="<?php echo $oMember->picture?>"/></td>
			<td>
				<div style="float:right;color:gray"><?php echo $sDate?></div>
				<strong><?php echo $oMember->shortname?></strong> <a style="color:#444" href="<?php echo _root::getLink('profil::showother',array('name'=>$oMember->login))?>">@<?php echo $oMember->login?></a><br/><?php echo $sText ?></td>

			
		</tr>	
	<?php endforeach;?>
	<?php else:?>
	Aucun posts
	<?php endif;?>
</table>
