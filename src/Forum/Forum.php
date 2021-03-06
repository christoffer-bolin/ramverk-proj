<?php

namespace Anax\Forum;

use Anax\DatabaseActiveRecord\ActiveRecordModel;

/**
 * A database driven model using the Active Record design pattern.
 */
class Forum extends ActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "Forum";
    protected $tableIdColumn = "questionId";


    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $questionId;
    public $rubrik;
    public $question;
    public $userId;


    // public function joinTagandForum()
    // {
    //     $this->checkDb();
    //     return $this->db->connect()
    //                     ->select()
    //                     ->from($this->tableName)
    //                     ->join("Tag2Forum", "Forum.questionId = Tag2Forum.questionId")
    //                     ->join("Tags", "Tag2Forum.tagId = Tags.tagId")
    //                     ->execute()
    //                     ->fetchAllClass(get_class($this));
    // }

    public function joinForumandUser()
    {
        $this->checkDb();
        return $this->db->connect()
                        ->select()
                        ->from($this->tableName)
                        ->join("User", "Forum.userId = User.userId")
                        ->execute()
                        ->fetchAllClass(get_class($this));
    }

    public function joinCommentandUser()
    {
        $this->checkDb();
        return $this->db->connect()
                        ->select()
                        ->from("User")
                        ->join("Comments", "User.userId = Comments.userId")
                        ->execute()
                        ->fetchAllClass(get_class($this));
    }

    public function joinAnswersandUser()
    {
        $this->checkDb();
        return $this->db->connect()
                        ->select()
                        ->from("User")
                        ->join("Answers", "User.userId = Answers.userId")
                        ->execute()
                        ->fetchAllClass(get_class($this));
    }

    public function joinTagsandTag2Forum($id)
    {
        $this->checkDb();
        $params = is_array($id) ? $id : [$id];
        return $this->db->connect()
                        ->select()
                        ->from("Tag2Forum")
                        ->where("Tag2Forum.questionId = ?")
                        ->join("Forum", "Tag2Forum.questionId = Forum.questionId")
                        ->join("Tags", "Tag2Forum.tagId = Tags.tagId")
                        ->execute($params)
                        ->fetchAllClass(get_class($this));
    }


    public function joinTwoTables($joinTable, $where, $orderBy = null)
    {
        $this->checkDb();
        return $this->db->connect()
                        ->select()
                        ->from($this->tableName)
                        ->join($joinTable, $where)
                        ->orderBy($orderBy)
                        ->execute()
                        ->fetchAllClass(get_class($this));
    }

    public function joinCommentsandUserandAnswers()
    {
        $this->checkDb();
        return $this->db->connect()
                        ->select()
                        ->from("Comments")
                        ->join("Answers", "Comments.answerId = Answers.answerId")
                        ->execute()
                        ->fetchAllClass(get_class($this));
    }
}
