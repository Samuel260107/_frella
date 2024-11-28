<?php global $user;?>
<img src="assets/img/profile/<?=$user['profile_pic']?>" class="img-thumbnail my-3" style="height:150px;width:150px" alt="...">
<h3><?=$user['first_name']?>    <?=$user['last_name']?></h3>
<a>@<?=$user['username']?></a>