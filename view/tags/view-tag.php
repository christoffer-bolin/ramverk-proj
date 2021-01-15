<?php
namespace Anax\View;

//var_dump($tags);
// var_dump($tagId);
//var_dump($questions);
//var_dump($tagId);
?>


<article class="article">
    <h1>Här finns aktuella frågor med din tagg!</h1>

<?php

$questionHolder = [];

foreach ($tags as $value) {
    if (intval($value->tagId) == $tagId) {
        $questionHolder[] = $value->questionId;
    }
}

//var_dump($questionHolder);

?>


<p>
<?php
$questionGrab = [];
foreach ($questions as $value) {
    if (in_array($value->questionId, $questionHolder)) {
        $questionGrab[] = $value;
    }
}

//var_dump($questionGrab);

foreach ($questionGrab as $value) { ?>
    <div class="tagDiv">
        <a href="<?= url("forum/viewquestion/{$value->questionId}"); ?>"><?= $value->rubrik ?></a>
    </div><br>
<?php } ?>


</p>
</article>
