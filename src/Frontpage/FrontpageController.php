<?php

namespace Anax\Frontpage;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Anax\User\User;
use Anax\Forum\Forum;
use Anax\Tags\Tags;
// use Anax\User\HTMLForm\UserLoginForm;
// use Anax\User\HTMLForm\CreateUserForm;
// use Anax\User\HTMLForm\EditProfile;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class FrontpageController implements ContainerInjectableInterface
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
     * Description.
     *
     *INDEX finns inte med på sidan
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function indexActionGet() : object
    {
        // var_dump($this->di);
        $page = $this->di->get("page");
        $title = "Startsida";

        $question = new Forum();
        $question->setDb($this->di->get("dbqb"));

        $tag = new Tags();
        $tag->setDb($this->di->get("dbqb"));
        $tags = $tag->countTags();

        $user = new User();
        $user->setDb($this->di->get("dbqb"));

        $mostQuestionsAsked = $user->findMostActiveFrontpage("Forum", "Forum.userId = User.userId");
        $mostReplysPosted = $user->findMostActiveFrontpage("Answers", "Answers.userId = User.userId");
        $mostCommentsMade = $user->findMostActiveFrontpage("Comments", "Comments.userId = User.userId");


        $page->add("frontpage/frontpage", [
            "latestQuestions" => $question->joinTwoTables("User", "Forum.userId = User.userId", "Forum.questionId DESC LIMIT 3"),
            "popularTags" => $tags,
            "mostQuestionsAsked" => $mostQuestionsAsked,
            "mostReplysPosted" => $mostReplysPosted,
            "mostCommentsMade" => $mostCommentsMade
        ]);


        return $page->render([
            "title" => $title,
        ]);
    }

}
