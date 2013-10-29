
<div class="popup">
	<h1 class="close"><a href="<?php echo _root::getLink('posts::list')?>">Fermer</a></h1>

	<div style="margin:auto;width:100px;background:#fff;margin-top:20px"><img style="width:100px" src="<?php echo $this->oMembers->picture ?>"/></div>

	<p style="text-align:center;font-weight:bold;font-size:14px"><?php echo $this->oMembers->shortname ?></p>

	<p style="text-align:center;font-size:14px">@<?php echo $this->oMembers->login ?></p>


	<p style="text-align:center"><?php echo $this->oMembers->description ?></p>


	<table class="profil" style="width:640px">
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
	
	<?php echo $this->oViewPosts->show()?>


</div>
