<?php

namespace Anax\View;

$answerQuestion = " <a href=" . url("answers/create/" . $question->questionId) ."><button type='button'><b>Svara på fråga</b></button></a>";
$commentQuestion = " <a href=" . url("comments/create/" . $question->questionId) ."><button type='button'><b>Kommentera fråga</b></button></a>";
/**
 * View to display all books.
 */
// Show all incoming variables/functions
//var_dump(get_defined_functions());
//echo showEnvironment(get_defined_vars());

// Gather incoming variables and use default values if not set


?><h1><?= $question->rubrik ?> <i>av: <?= $user->username ?><img class="gravatarpic" src="https://www.gravatar.com/avatar/<?= md5($user->email) ?>?s=100&d=mm"></i></h1>
<p><?=  $question->question ?><br><br><?= $answerQuestion ?><br><br><?= $commentQuestion ?><p>

<h3>Kommentarer</h3>
<p>Här ska kommentarer som redan gjorts visas</p>

<h3>Tidigare svar</h3>
<p>Här ska svar som redan gjorts visas<br><?= $commentQuestion ?>
<br>
Här kommer kommentarer som gjorts på svaret visas</p>
