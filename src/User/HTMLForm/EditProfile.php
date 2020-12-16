<?php

namespace Anax\User\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Anax\User\User;

/**
 * Form to update an item.
 */
class EditProfile extends FormModel
{
    public $userId;
    /**
     * Constructor injects with DI container and the id to update.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     * @param integer             $id to update
     */
    public function __construct(ContainerInterface $di, $id)
    {
        parent::__construct($di);
        $this->userId = $id;
        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $user->find("userId", $id);

        $this->form->create(
            [
                "userId" => __CLASS__,
                "legend" => "Uppdatera profil",
            ],
            [
                "userId" => [
                    "label" => "AnvändarId",
                    "type" => "text",
                    "readonly" => true,
                    "value" => $user->userId,
                ],

                "username" => [
                    "label" => "Användarnamn",
                    "type" => "text",
                    "value" => $user->username,
                    "readonly" => true,
                ],

                "new-password" => [
                    "type" => "password",
                    "label" => "Nytt lösenord:"
                ],

                "re-password" => [
                    "type" => "password",
                    "label" => "Repetera nytt lösenord:"
                ],

                "email" => [
                    "type" => "email",
                    "value" => $user->email,
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Spara",
                    "callback" => [$this, "callbackSubmit"]
                ],

                // "reset" => [
                //     "type"      => "reset",
                // ],
            ]
        );
    }



    /**
     * Get details on item to load form with.
     *
     * @param integer $id get details on item with id.
     *
     * @return Book
     */
    // public function getItemDetails($id) : object
    // {
    //     $book = new Book();
    //     $book->setDb($this->di->get("dbqb"));
    //     $book->find("id", $id);
    //     return $book;
    // }



    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return bool true if okey, false if something went wrong.
     */
    public function callbackSubmit() : bool
    {
        // spara värden från formuläret (CreateForm.php Book)
        $username       = $this->form->value("username");
        $newpassword    = $this->form->value("new-password");
        $repassword     = $this->form->value("re-password");
        $email          = $this->form->value("email");
        $userId         = $this->form->value("userId");



        // Check password matches
        if ($newpassword != $repassword) {
            $this->form->rememberValues();
            $this->form->addOutput("Nya lösenordet matcher ej.");
            return false;
        }

         $user = new User();
         $user->setDb($this->di->get("dbqb"));
         $user->find("userId", $this->form->value("userId"));

         $this->form->addOutput("Profilen för " . $username . " är ändrad.");

        if ($newpassword) {
            $user->setPassword($newpassword);
        }

        $user->username = $this->form->value("username");
        if ($email) {
            $user->email = $this->form->value("email");
        }


         $user->save();
         return true;
    }



    // /**
    //  * Callback what to do if the form was successfully submitted, this
    //  * happen when the submit callback method returns true. This method
    //  * can/should be implemented by the subclass for a different behaviour.
    //  */
    public function callbackSuccess()
    {
        $this->di->get("response")->redirect("user/userpage/" . $this->userId)->send();
        //$this->di->get("response")->redirect("book/update/{$book->id}");
    }



    // /**
    //  * Callback what to do if the form was unsuccessfully submitted, this
    //  * happen when the submit callback method returns false or if validation
    //  * fails. This method can/should be implemented by the subclass for a
    //  * different behaviour.
    //  */
    // public function callbackFail()
    // {
    //     $this->di->get("response")->redirectSelf()->send();
    // }
}
