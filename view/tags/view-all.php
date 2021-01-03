<?php
namespace Anax\View;

//var_dump($tags);
?>

<article class="article" style="min-height:360px;">
    <h1>Här finns aktuella taggar</h1>
    <?php
    if (!$tags) { ?>
            <p>Tyvärr, tomt taggar,  kanske dags att skapa en fråga?</p> <?php
    }

    ?>
    <p>
        <?php foreach ($tags as $item) : ?>
            <a href="<?= url("tags/view-tag/{$item->tagId}"); ?>"><?= $item->tag ?></a><br>
        <?php endforeach; ?>
    </p>
</article>
