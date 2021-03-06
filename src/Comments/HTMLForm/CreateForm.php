<?php

namespace Anax\Comments\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Anax\Comments\Comments;

/**
 * Form to create an item.
 */
class CreateForm extends FormModel
{

    public $entryId;


    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di, $entryId)
    {
        parent::__construct($di);
        $this->entryId = $entryId;
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Kommentera",
            ],
            [
                "comment" => [
                    "type" => "text",
                    "label" => "Kommentar",
                    "validation" => ["not_empty"],
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Posta kommentar",
                    "callback" => [$this, "callbackSubmit"]
                ],
            ]
        );
    }



    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return bool true if okey, false if something went wrong.
     */
    public function callbackSubmit() : bool
    {
        $comments = new Comments();
        $comments->setDb($this->di->get("dbqb"));
        $comments->comment = $this->form->value("comment");
        $comments->entryId = $this->entryId;
        $comments->userId = $this->di->get("session")->get("userId");

        $comments->save();
        return true;
    }



    /**
     * Callback what to do if the form was successfully submitted, this
     * happen when the submit callback method returns true. This method
     * can/should be implemented by the subclass for a different behaviour.
     */
    public function callbackSuccess()
    {
        $this->di->get("response")->redirect("forum/viewquestion/" . $this->entryId)->send();
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
