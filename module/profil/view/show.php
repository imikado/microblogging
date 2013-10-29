<div style="background:#ddd;width:676px;margin:10px;border:1px solid #ccc;">
	<div style="margin:auto;width:100px;background:#fff;margin-top:20px;border:2px solid #ccc"><img style="width:100px" src="<?php echo $this->oMembers->picture ?>"/></div>

	<p style="text-align:center;font-weight:bold;font-size:14px"><?php echo $this->oMembers->shortname ?></p>

	<p style="text-align:center;font-size:14px">@<?php echo $this->oMembers->login ?></p>


	<p style="text-align:center"><?php echo $this->oMembers->description ?></p>

	<p style="margin:10px;text-align:right"> <a class="btn" style="width:100px" href="<?php echo $this->getLink('profil::edit')?>">Editer le profil</a></p>

</div>

<table class="profil">
	<tr>
		<td>
			<strong><?php echo $this->oMembers->nb_posts?></strong>
			<br />POSTS</td>
		<td>
			<strong><?php echo $this->oMembers->nb_followers?></strong>
			<br />ABONNES</td>
		<td style="width:450px">
			<strong><?php echo $this->oMembers->nb_subscriptions?></strong>
			<br />ABBONNEMENTS</td>
	</tr>
</table>

<h1 style="margin-top:30px">Abonnements</h1>
<table class="tb_subscriptions">
<?php foreach($this->tMember as $oMember):?>
	<?php if($oMember->id==$this->oMembers->id) continue ?>
	<tr>
		<td style="width:22px"><img style="width:20px" src="<?php echo $oMember->picture?>" /></td>
		<td><strong><?php echo $oMember->shortname?></strong>
			@<?php echo $oMember->login?>
		</td>
		<td style="width:100px;text-align:right">
			<?php if(in_array($oMember->id, $this->tFollowed)):?>
				<a class="btnDisabled" href="<?php echo _root::getLink('profil::unfollow',array('member_id'=>$oMember->id))?>">Suivre</a>
			<?php else:?>
				<a class="btn" href="<?php echo _root::getLink('profil::follow',array('member_id'=>$oMember->id))?>">Suivre</a>
			<?php endif;?>
		</td>
	</tr>
<?php endforeach;?>
</table>


<div style="clear:both;height:10px"></div>

