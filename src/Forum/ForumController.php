<?php

namespace Anax\Forum;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Anax\Forum\HTMLForm\CreateForm;
use Anax\User\User;
use Anax\Tags\Tag2Forum;
use Anax\Tags\Tags;
use Anax\Comments\Comments;
use Anax\Answers\Answers;

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

        $data = [
            "questions" => $forum->joinForumandUser(),
        ];


        $page->add("forum/view-all", $data);

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


        $comments = new Comments();
        $comments->setDb($this->di->get("dbqb"));
        $commentHolder = $comments->findAllWhere("Comments.entryId = ?", $id);




        $tag2forum = new Tag2Forum();
        $tag2forum->setDb($this->di->get("dbqb"));
        $tagsHere = $tag2forum->findAllWhere("Tag2Forum.questionId = ?", $id);

        $answers = new Answers();
        $answers->setDb($this->di->get("dbqb"));
        $answers->find("questionId", $id);

        $data = [
            "question" => $question,
            "user" => $user,
            "tags" => $tagsHere,
            "comments" => $question->joinCommentandUser(),
            "answers" => $question->joinAnswersandUser(),
        ];


        $page->add("forum/viewquestion", $data);

        return $page->render([
            "title" => "Fråga"
        ]);
    }
}
