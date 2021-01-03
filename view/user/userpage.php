<?php

namespace Anax\View;
//var_dump($comments);
//$questions = isset($questions) ? $questions : null;
//$comments = isset($comments) ? $comments : null;
$user = isset($user) ? $user : null;


$edit = " <a href=" . url("user/edit/" . $user->userId) ."><button type='button'><b>Redigera användare</b></button></a>";
$idCheck = $this->di->get("session")->get("userId");

/**
 * Frontpage for books
 */
//var_dump($user);
?>
<h1>Profil för <?= $user->username ?> </h1>

<div style="height: auto; border: 1px solid black; padding-left: 5px;">
    <p><b>Användarnamn:</b> <?= $user->username ?></p>
    <p><b>E-post:</b> <?= $user->email ?></p>
    <p><img class="gravatarpic" src="https://www.gravatar.com/avatar/<?= md5($user->email) ?>?s=200&d=mm"></p>

    <?php
    if ($questions) : ?>
    <div>
        <h3><?= sizeof($questions) ?> frågor ställda i forumet</h3>
        <ul class="userpageul">
            <?php foreach ($questions as $question) : ?>
            <li>
                <a href="<?= url("forum/viewquestion/" . $question->questionId) ?>"><?= $question->rubrik ?></a>
            </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <?php
//    var_dump($comments);

    $entryIdHolder = [];
    $commentIdHolder = [];

    foreach ($comments as $key) {
        if ($key->entryId) {
            $entryIdHolder[] = $key;
        } elseif ($key->commentId) {
            $commentIdHolder[] = $key;
        }
    }

// var_dump($entryIdHolder);
//var_dump($commentIdHolder);


    if ($comments) : ?>
    <div>
        <h3><?= sizeof($comments) ?> kommentarer gjorda i forumet</h3>
        <ul class="userpageul">
            <?php foreach ($entryIdHolder as $item) : ?>
            <li>
                <a href="<?= url("forum/viewquestion/" . $item->entryId) ?>"><?= $filter->parse($item->comment, ["markdown"])->text ?></a>
            </li>
            <?php endforeach; ?>
            <?php foreach ($commentIdHolder as $item) : ?>
            <li>
                <a href="<?= url("forum/viewquestion/" . $item->answerId) ?>"><?= $filter->parse($item->comment, ["markdown"])->text ?></a>
            </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <?php if ($user->userId == $idCheck) { ?>
        <p> <?= $edit ?> </p>
    <?php } ?>
</div>
