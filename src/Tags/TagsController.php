<?php

namespace Anax\Tags;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Anax\Tags\HTMLForm\CreateForm;
use Anax\Tags\Tag2Forum;
use Anax\Forum\Forum;
use Anax\User\User;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class TagsController implements ContainerInjectableInterface
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
        $tags = new Tags();
        $tags->setDb($this->di->get("dbqb"));


        $page->add("tags/view-all", [
            "tags" => $tags->findAll(),
        ]);

        return $page->render([
            "title" => "A collection of items",
        ]);
    }

    /**
     * Show all items.
     *
     * @return object as a response object
     */
    public function viewTagAction(int $id) : object
    {
        $page = $this->di->get("page");
        $tags = new Tags();
        $tags->setDb($this->di->get("dbqb"));

        $tagsforum = new Tag2Forum();
        $tagsforum->setDb($this->di->get("dbqb"));


        $tagArray = $tags->joinTagsandTag2Forum();


        $questions = new Forum();
        $questions->setDb($this->di->get("dbqb"));
        $questionHolder = $questions->findAll();

        $data = [
            "tags" => $tagArray,
            "tagId" => $id,
            "questions" => $questionHolder,
        ];

        //var_dump($data);

        $page->add("tags/view-tag", $data);

        return $page->render([
            "title" => "Linkat till tagg",
        ]);
    }
}
