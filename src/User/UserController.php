<?php

namespace Anax\User;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Anax\User\HTMLForm\UserLoginForm;
use Anax\User\HTMLForm\CreateUserForm;
use Anax\User\HTMLForm\EditProfile;
use Anax\Forum\Forum;
use Anax\Answers\Answers;
use Anax\Comments\Comments;
use Anax\TextFilter\TextFilter;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class UserController implements ContainerInjectableInterface
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
        $page = $this->di->get("page");

        $page->add("anax/v2/article/default", [
            "content" => "An index page",
        ]);

        return $page->render([
            "title" => "A index page",
        ]);
    }



    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function loginAction() : object
    {
        $page = $this->di->get("page");
        $form = new UserLoginForm($this->di);
        $form->check();

        $page->add("anax/v2/article/default", [
            "content" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Logga in",
        ]);
    }

    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function createAction() : object
    {
        $page = $this->di->get("page");
        $form = new CreateUserForm($this->di);
        $form->check();

        $page->add("anax/v2/article/default", [
            "content" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Skapa användare",
        ]);
    }

    /**
     * edit route.
     *
     * @param int $id for user you want to change
     *
     * @return object as a response object
     */
    public function editAction(int $id) : object
    {
        $page = $this->di->get("page");
        $userId = $this->di->get("session")->get("userId");
        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $user->find("userId", $userId);

        $form = new EditProfile($this->di, $id);
        $form->check();

        $page->add("anax/v2/article/default", [
            "content" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Redigera användare",
        ]);
    }

    public function userpageAction(int $id) : object
    {
        $page = $this->di->get("page");

        //$userId = $this->di->get("session")->get("userId");
        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $user->find("userId", $id);


        $forum = new Forum();
        $forum->setDb($this->di->get("dbqb"));
        $questions = $forum->findAllWhere("forum.userId = ?", $id);


        $comments = new Comments();
        $comments->setDb($this->di->get("dbqb"));
        $userComments = $comments->findAllWhere("Comments.userId = ?", $id);

        //var_dump($questions);
        $data = [
            "user" => $user,
            "questions" => $questions,
            "comments" => $userComments,
            "filter" => new TextFilter(),
        ];


        $page->add("user/userpage", $data);
        //var_dump($data);

        return $page->render([
            "title" => "Profil"
        ]);
    }

    /**
     * Logout route
     * gör inget mer än tar bort session och redirectar. ingen 'fysisk' sida
     */
    public function logoutAction() : object
    {
        $this->di->get("session")->delete("userId");
        $this->di->get("response")->redirect("user/login");
    }
}
