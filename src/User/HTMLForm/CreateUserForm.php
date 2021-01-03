<?php

namespace Anax\User\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Anax\User\User;

/**
 * Example of FormModel implementation.
 */
class CreateUserForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di)
    {
        parent::__construct($di);
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Skapa användare",
            ],
            [
                "username" => [
                    "type"        => "text",
                    "label" => "Användarnamn:",
                    "validation" => ["not_empty"],
                ],

                "password" => [
                    "type"        => "password",
                    "label" => "Lösenord:",
                    "validation" => ["not_empty"],
                ],

                "password-again" => [
                    "type"        => "password",
                    "label"       => "Repetera lösenord:",
                    "validation" => [
                        "match" => "password"
                    ],
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Submit",
                    "callback" => [$this, "callbackSubmit"]
                ],
            ]
        );
    }



    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return boolean true if okey, false if something went wrong.
     */
    public function callbackSubmit()
    {
        // spara värden från formuläret (CreateForm.php Book)
        $username = $this->form->value("username");
        $password = $this->form->value("password");
        $passwordAgain = $this->form->value("password-again");


        // Check password matches
        if ($password !== $passwordAgain) {
            $this->form->rememberValues();
            $this->form->addOutput("Password did not match.");
            return false;
        }


        // ny Userklass
        $user = new User();

        //koppla upp mot db (CreateForm.php Book)
        $user->setDb($this->di->get("dbqb"));

        //lägg in username och password samt sätt userID var
        $user->username = $username;
        $user->setPassword($password);
        $user->save();
        $this->userId = $user->userId;

        return true;
    }

    /**
    * Callback what to do if the form was successfully submitted, this
    * happen when the submit callback method returns true. This method
    * can/should be implemented by the subclass for a different behaviour.
    * Redirect till login när användaren skapas om allt är ok
    */
    public function callbackSuccess()
    {
        $this->di->get("response")->redirect("user/login")->send();
    }
}
