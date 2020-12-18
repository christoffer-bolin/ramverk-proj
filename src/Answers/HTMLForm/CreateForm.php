<?php

namespace Anax\Answers\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Anax\Answers\Answers;
use Anax\Forum\Forum;
/**
 * Form to create an item.
 */
class CreateForm extends FormModel
{
    public $questionId;
    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di, $id)
    {
        parent::__construct($di);
        $this->questionId = $id;
        $this->form->create(
            [
                "answerId" => __CLASS__,
                "legend" => "Svar",
            ],
            [
                "answer" => [
                    "label" => "Skriv ditt svar",
                    "type" => "text",
                    "validation" => ["not_empty"],
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Create item",
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
        $answers = new Answers();
        $answers->setDb($this->di->get("dbqb"));
        $answers->answer  = $this->form->value("answer");

        $question = new Forum();
        $question->setDb($this->di->get("dbqb"));
        $question->find("questionId", $this->questionId);

        $answers->questionId = $question->questionId;
        $answers->userId = $this->di->get("session")->get("userId");
        $answers->save();
        return true;
    }



    /**
     * Callback what to do if the form was successfully submitted, this
     * happen when the submit callback method returns true. This method
     * can/should be implemented by the subclass for a different behaviour.
     */
    public function callbackSuccess()
    {
        $this->di->get("response")->redirect("forum")->send();
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
