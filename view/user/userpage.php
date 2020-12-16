<?php

namespace Anax\View;
$edit = " <a href=" . url("user/edit/" . $user->userId) ."><button type='button'>Redigera användare</button></a>";
/**
 * Frontpage for books
 */
//var_dump($user);
?>
<h1>Profil för <?= $user->username ?> </h1>

<div style="height: 550px;">
    <h3>En sida om böcker, för böcker, av böcker...</h3>
    <p><?= $edit ?></p>
</div>
