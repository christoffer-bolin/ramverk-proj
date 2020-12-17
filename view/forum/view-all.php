<?php

namespace Anax\View;

/**
 * View to display all books.
 */
// Show all incoming variables/functions
//var_dump(get_defined_functions());
//echo showEnvironment(get_defined_vars());

// Gather incoming variables and use default values if not set
$items = isset($items) ? $items : null;

// Create urls for navigation
$urlToCreate = url("forum/create");

//se om någon är inloggad
$idCheck = $this->di->get("session")->get("userId");

?><h1>Alla frågor</h1>

<?php if ($idCheck) { ?>
    <p>
        <a href="<?= $urlToCreate ?>">Ställ en fråga</a>
    </p>
<?php } ?>


<?php if (!$items) : ?>
    <p>Tyvärr, tomt på frågor! Ställ en?</p>
<?php
    return;
endif;
?>

<table>
    <tr>
        <th>Rubriker</th>
    </tr>
    <?php foreach ($items as $item) : ?>
    <tr>
        <td>
            <a href="<?= url("forum/viewquestion/{$item->questionId}"); ?>"><?= $item->rubrik ?></a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
