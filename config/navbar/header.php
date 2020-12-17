<?php
/**
 * Supply the basis for the navbar as an array.
 */
global $di;

$userId = $di->get("session")->get("userId");

$navbar = [
    // Use for styling the menu
    "wrapper" => null,
    "class" => "my-navbar rm-default rm-desktop",

    // Here comes the menu items
    "items" => [
        [
            "text" => "Hem",
            "url" => "",
            "title" => "Första sidan, börja här.",
        ],
        [
            "text" => "Forum",
            "url" => "forum",
            "title" => "Forum.",
        ],
    ],
];

$loginOrOut = [
    "text" => "Logga in",
    "url" => "user/login",
    "title" => "Logga in."
];
if ($userId) {
    $profil = [
        "text" => 'Profil',
        "url" => "user/userpage/" . $userId,
        "title" => "Profil",
    ];
    $loginOrOut = [
        "text" => "Logga ut",
        "url" => "user/logout",
        "title" => "Logga ut."
    ];
    array_push($navbar["items"], $profil);
};
array_push($navbar["items"], $loginOrOut);

return $navbar;
