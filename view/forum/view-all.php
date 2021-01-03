<?php

namespace Anax\View;

/**
 * View to display all books.
 */
// Show all incoming variables/functions
//var_dump(get_defined_functions());
//echo showEnvironment(get_defined_vars());

// Gather incoming variables and use default values if not set
$data = isset($data) ? $data : null;
//var_dump($data);
//var_dump($questions);

// Create urls for navigation
$urlToCreate = url("forum/create");

//se om någon är inloggad
$idCheck = $this->di->get("session")->get("userId");

?>
<article class="article" style="min-height:360px;">
    <h1>Alla frågor</h1>

    <?php if ($idCheck) { ?>
        <p>
            <a href="<?= $urlToCreate ?>">Ställ en fråga</a>
        </p>
    <?php } ?>


    <?php if (!$questions) : ?>
        <p>Tyvärr, tomt på frågor! Ställ en?</p>
        <?php
        return;
    endif;
    ?>

        <?php foreach ($questions as $item) :
        //var_dump($item); ?>
        <div class="forumviewer">
            <img class="gravatarpic" src="https://www.gravatar.com/avatar/<?= md5($item->email) ?>?s=30&d=mm">
            <a href="<?= url("user/userpage/{$item->userId}"); ?>"><?= $item->username ?></a>
            <a href="<?= url("forum/viewquestion/{$item->questionId}"); ?>"><?= $item->rubrik ?></a>
        </div>
        <?php endforeach; ?>

</article>
