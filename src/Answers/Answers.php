<?php

namespace Anax\Answers;

use Anax\DatabaseActiveRecord\ActiveRecordModel;

/**
 * A database driven model using the Active Record design pattern.
 */
class Answers extends ActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "Answers";
    protected $tableIdColumn = "answerId";


    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $answerId;
    public $answer;
    public $questionId;
}
