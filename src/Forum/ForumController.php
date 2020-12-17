<?php

namespace Anax\Forum;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Anax\Forum\HTMLForm\CreateForm;
use Anax\User\User;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class ForumController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;



    /**
     * @var $data description
     */
    //private $data;



    // /**
    //  * The initialize method is optional and will always be called before the
    //  * target method/action. This is a convienient method where you could
    //  * setup internal properties that are commonly used by several methods.
    //  *
    //  * @return void
    //  */
    // public function initialize() : void
    // {
    //     ;
    // }



    /**
     * Show all items.
     *
     * @return object as a response object
     */
    public function indexActionGet() : object
    {
        $page = $this->di->get("page");
        $forum = new Forum();
        $forum->setDb($this->di->get("dbqb"));

        $page->add("forum/view-all", [
            "items" => $forum->findAll(),
        ]);

        return $page->render([
            "title" => "A collection of items",
        ]);
    }



    /**
     * Handler with form to create a new item.
     *
     * @return object as a response object
     */
    public function createAction() : object
    {
        $page = $this->di->get("page");
        $form = new CreateForm($this->di);
        $form->check();

        $page->add("forum/create", [
            "form" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Create a item",
        ]);
    }

    /**
     * Handler with form to create a new item.
     *
     * @return object as a response object
     */
    public function viewQuestionAction(int $id) : object
    {
        $page = $this->di->get("page");

        $question = new Forum();
        $question->setDb($this->di->get("dbqb"));
        $question->find("questionId", $id);

        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $user->find("userId", $question->userId);

        $data = [
            "question" => $question,
            "user" => $user
        ];


        $page->add("forum/viewquestion", $data);

        return $page->render([
            "title" => "Fråga"
        ]);
    }
}
