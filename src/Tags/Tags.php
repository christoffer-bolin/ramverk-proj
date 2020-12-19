<?php

namespace Anax\Tags;

use Anax\DatabaseActiveRecord\ActiveRecordModel;

/**
 * A database driven model using the Active Record design pattern.
 */
class Tags extends ActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "Tags";
    protected $tableIdColumn = "tagId";



    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $tagId;
    public $tag;

    public function joinTagsandTag2Forum()
    {
        $this->checkDb();
        return $this->db->connect()
                        ->select()
                        ->from("Tag2Forum")
                        ->join("Tags", "Tag2Forum.tagId = Tags.tagId")
                        ->execute()
                        ->fetchAllClass(get_class($this));
    }
}
