<?php

namespace Anax\Forum\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Anax\Forum\Forum;
use Anax\User\User;
use Anax\Tags\Tags;
use Anax\Tags\Tag2Forum;

/**
 * Form to create an item.
 */
class CreateForm extends FormModel
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
                "questionId" => __CLASS__,
                "legend" => "Fråga",
            ],
            [
                "rubrik" => [
                    "type" => "text",
                    "label" => "Rubrik",
                    "validation" => ["not_empty"],
                ],

                "question" => [
                    "type" => "text",
                    "label" => "Fråga",
                    "validation" => ["not_empty"],
                ],

                "tags" => [
                    "type" => "text",
                    "label" => "Tags",
                    "description" => "Vid flera taggar, separera med mellanrum ex: svart vit blå",
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Posta din fråga",
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
        $forum = new Forum();
        $forum->setDb($this->di->get("dbqb"));
        $forum->rubrik  = $this->form->value("rubrik");
        $forum->question = $this->form->value("question");
        $forum->userId = $this->di->get("session")->get("userId");
        $forum->save();


        // handle tags
        $tags = explode(' ', $this->form->value("tags"));
        foreach ($tags as $tag) {
            $tagHolder = new Tags();
            $tag2forum = new Tag2Forum();
            $tagHolder->setDb($this->di->get("dbqb"));
            $tagHolder->find("tag", $tag);
            if (!$tagHolder->tagId && $tag != "") {
                $tagHolder->tag = $tag;
                $tagHolder->save();
                $tagHolder->find("tag", $tag);
            }
            $tag2forum->setDb($this->di->get("dbqb"));
            $tag2forum->tagId = $tagHolder->tagId;
            $tag2forum->questionId = $forum->questionId;
            $tag2forum->save();
        }
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
