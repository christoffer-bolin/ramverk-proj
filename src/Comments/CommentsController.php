<?php

namespace Anax\Comments;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Anax\Comments\HTMLForm\CreateForm;
use Anax\User\User;
use Anax\Forum\Forum;
use Anax\Comments\HTMLForm\CreateReplyForm;
// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class CommentsController implements ContainerInjectableInterface
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
        $comments = new Comments();
        $comments->setDb($this->di->get("dbqb"));

        $page->add("comments/view-all", [
            "items" => $comments->findAll(),
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
    public function createAction(int $id) : object
    {

        $userId = $this->di->get("session")->get("userId");

        $page = $this->di->get("page");
        $form = new CreateForm($this->di, $id);
        $form->check();


        $forum = new Forum();
        $forum->setDb($this->di->get("dbqb"));

        $page->add("comments/create", [
            "form" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Kommentar",
        ]);
    }

    /**
     * Handler with form to create a new item.
     *
     * @return object as a response object
     */
    public function createReplyAction(int $id) : object
    {

        $userId = $this->di->get("session")->get("userId");

        $page = $this->di->get("page");
        $form = new CreateReplyForm($this->di, $id);
        $form->check();


        $forum = new Forum();
        $forum->setDb($this->di->get("dbqb"));

        $page->add("comments/createReply", [
            "form" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Kommentar",
        ]);
    }

}
