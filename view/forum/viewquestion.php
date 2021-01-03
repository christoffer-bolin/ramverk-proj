<?php

namespace Anax\View;

//var_dump($question);
// var_dump($user);
//var_dump($tags);
//var_dump($comments);
//var_dump($answers);


// $tagsHolder = " <a href=" . url("tags/view-all/" . $tags->questionId) ."><button type='button'><b>Svara på fråga</b></button></a>";
$answerQuestion = " <a href=" . url("answers/create/" . $question->questionId) ."><button type='button'><b>Svara på fråga</b></button></a>";
$commentQuestion = " <a href=" . url("comments/create/" . $question->questionId) ."><button type='button'><b>Kommentera fråga</b></button></a>";
//$commentAnswer = " <a href=" . url("comments/createReply/" . $question->answerId) ."><button type='button'><b>Kommentera svar</b></button></a>";
$idCheck = $this->di->get("session")->get("userId");
/**
 * View to display all books.
 */
// Show all incoming variables/functions
//var_dump(get_defined_functions());
//echo showEnvironment(get_defined_vars());

// Gather incoming variables and use default values if not set


?><h1><?= $question->rubrik ?> <i>av: <?= $user->username ?><img class="gravatarpic" src="https://www.gravatar.com/avatar/<?= md5($user->email) ?>?s=100&d=mm"></i></h1>
<p><?=  $filter->parse($question->question, ["markdown"])->text ?><br>


    <?php if ($idCheck) { ?>
        <p>
            <br><?= $answerQuestion ?><?= $commentQuestion ?>
        </p>
    <?php } ?>

<h5>#Taggar</h5>

<?php if ($tags) { ?>
    <p>
        <?php
        foreach ($tags as $value) : ?>
            <a href=""><?= $value->tag ?></a>
         <?php endforeach; ?>
    </p>
<?php } ?>

<h5>Kommentarer</h5>

<?php
$commentsHold = [];
foreach ($comments as $value) {
    if ($value->entryId == $question->questionId) {
        $commentsHold[] = $value;
    }
}

if (!$commentsHold) { ?>
        <p>Tyvärr, tomt på kommentarer! Kanske kan du säga något?</p> <?php
}

?>
<p>
    <?php foreach ($commentsHold as $item) : ?>
    <tr>
        <td>
            <img class="gravatarpic" src="https://www.gravatar.com/avatar/<?= md5($item->email) ?>?s=30&d=mm">
            <a href="<?= url("user/userpage/{$item->userId}"); ?>"><?= $item->username ?></a><i> sa:</i>
            <?= $filter->parse($item->comment, ["markdown"])->text ?><br>
        </td>
    </tr>
    <?php endforeach; ?>
</p>

<h5>Tidigare svar</h5>
<p>

<?php
$answersHold = [];
foreach ($answers as $value) {
    if ($value->questionId == $question->questionId) {
        $answersHold[] = $value;
    }
}

if (!$answersHold) { ?>
        <p>Tyvärr, tomt på Svar! Kanske kan du hjälpa till?</p> <?php
}

$replyHolder = [];
foreach ($comments as $value) {
    if ($value->answerId) {
        $replyHolder[] = $value;
    }
}


    foreach ($answersHold as $item) : ?>
    <tr>
        <td>
            <img class="gravatarpic" src="https://www.gravatar.com/avatar/<?= md5($item->email) ?>?s=30&d=mm">
            <a href="<?= url("user/userpage/{$item->userId}"); ?>"><?= $item->username ?></a><i> sa:</i>
            <?= $filter->parse($item->answer, ["markdown"])->text ?><br><p class="commentReply">
            <?php foreach ($replyHolder as $key) {
                if ($key->answerId == $item->answerId) { ?>
                    <a href="<?= url("user/userpage/{$key->userId}"); ?>"><?= $key->username ?></a><i> kommenterade:</i>
                    <?= $filter->parse($key->comment, ["markdown"])->text ?><br><?php
                }
            } ?></p>
            <a href="<?= url("comments/createReply/{$item->questionId}"); ?>" class="button">Kommentera svar</a><br><br>
        </td>
    </tr>
    <?php endforeach; ?>
</p>
