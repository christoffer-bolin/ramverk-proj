<?php

namespace Anax\View;

?>


<article class="article" style="text-align:center; min-height:300px;">
    <h1>Välkommen!</h1>
<br>
<p>Du har hittat rätt.. om du nu var ute efter den bästa sidan just nu för mineraler! Här kört vi 'stenhårt' på alla de olika mineralerna. Ibland är det lite som skor<i>stenen</i>, dvs ihåligt i forumet. Så hoppa gärna in och skriv något.</p>


    <div class="frontpagediv">
        <h5>3 senaste inläggen</h5>

        <?php foreach ($latestQuestions as $question) {
            ?> <li class="frontpageli"><a href="<?= url("forum/viewquestion/{$question->questionId}"); ?>"><?= $question->rubrik ?></a></li> <?php
        } ?>
    </div>

    <div class="frontpagediv">
        <h5>3 mest populära taggarna</h5>

        <?php foreach ($popularTags as $tag) {
            ?> <li class="frontpageli"><a href="<?= url("tags/view-tag/{$tag->tagId}"); ?>"><?= $tag->tag ?></a></li> <?php
        } ?>
    </div>

    <div class="frontpagesinglediv">
        <h4>3 mest aktiva användarna</h4>

        <div class="mfu">
            <h5>Inlägg</h5>
            <?php foreach ($mostQuestionsAsked as $mqa) {
                ?> <li class="frontpageli"><a href="<?= url("user/userpage/{$mqa->userId}"); ?>"><?= $mqa->username ?></a></li> <?php
            } ?>
        </div>

        <div class="mfu">
            <h5>Svar</h5>
            <?php foreach ($mostReplysPosted as $mrp) {
                ?> <li class="frontpageli"><a href="<?= url("user/userpage/{$mrp->userId}"); ?>"><?= $mrp->username ?></a></li> <?php
            } ?>
        </div>

        <div class="mfu">
            <h5>Kommentarer</h5>
            <?php foreach ($mostCommentsMade as $mcm) {
                ?> <li class="frontpageli"><a href="<?= url("user/userpage/{$mcm->userId}"); ?>"><?= $mcm->username ?></a></li> <?php
            } ?>
        </div>

    </div>
</article>
