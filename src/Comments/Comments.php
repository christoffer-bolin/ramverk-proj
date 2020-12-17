<?php

namespace Anax\Comments;

use Anax\DatabaseActiveRecord\ActiveRecordModel;

/**
 * A database driven model using the Active Record design pattern.
 */
class Comments extends ActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "Comments";
    protected $tableIdColumn = "commentId"


    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $commentId;
    public $questionId;
    public $userId;
    public $answerId;
    public $comment;
}
