<?php

namespace Anax\User\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Anax\User\User;


/**
 * Example of FormModel implementation.
 */
class UserLoginForm extends FormModel
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
                "legend" => "Logga in"
            ],
            [
                "username" => [
                    "type"        => "text",
                    "label"        => "Användarnamn:"
                    //"description" => "Here you can place a description.",
                    //"placeholder" => "Here is a placeholder",
                ],

                "password" => [
                    "type"        => "password",
                    "label"        => "Lösenord:"
                    //"description" => "Here you can place a description.",
                    //"placeholder" => "Here is a placeholder",
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Login",
                    "callback" => [$this, "callbackSubmit"]
                ],

                "create" => [
                    "type" => "submit",
                    "value" => "Registrera",
                    "callback" => [$this, "callbackRegister"]
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

        // ny Userklass
        $user = new User();

        //koppla upp mot db (CreateForm.php Book)
        $user->setDb($this->di->get("dbqb"));

        //kontrollera så att anv + pw matchar
        $pwController = $user->passwordController($username, $password);


        //om pwController är false, avbryt
        //se exempel med $password & $passwordAgain för konstruktion
        if (!$pwController) {
            $this->form->rememberValues();
            $this->form->addOutput("Fel användarnamn eller lösenord.");
            $this->di->get("session")->delete("username");
            return false;
        }

        //test för att se så den hittar IDt även om man inte har kvar IDt från
        //sessionen i createUser
        //$this->di->get("session")->delete("userId");

        //om de är ok så lägg userId i sessionen
        $this->di->get("session")->set("userId", $user->userId);
        return true;
    }

    /**
    * Om man inte har skapat användare och väljer Registrera, redirect
    */
    public function callbackRegister()
    {
        $this->di->get("response")->redirect("user/create");
    }

    /**
    * Om allt är OK, skickas till sin användarprofil
    */
    public function callbackSuccess()
    {
        $this->di->get("response")->redirect("om")->send();
    }
}
