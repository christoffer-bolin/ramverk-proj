<?php

namespace Anax\View;

/**
 * View to create a new book.
 */
// Show all incoming variables/functions
//var_dump(get_defined_functions());
//echo showEnvironment(get_defined_vars());

// Gather incoming variables and use default values if not set
$items = isset($items) ? $items : null;

// Create urls for navigation
$urlToViewItems = url("forum/view-all");



?><h1>Ställ en fråga!</h1>

<?= $form ?>

<p>
    <a href="<?= $urlToViewItems ?>">Se alla frågor</a>
</p>
