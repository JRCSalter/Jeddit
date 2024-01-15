<?php

declare(strict_types=1);

namespace JRCS;

use Core\Database;

/**
 * Contains methods and properties for a post.
 */
class Post
{
    /** @var Database The database connection */
    protected ?Database $db;

    public function __construct(?Database $db = NULL)
    {
        $this->db = $db;
    }

    /**
     * Gets the post with the relevant ID
     * 
     * Fields retrieved: id, title, content, name, user_id.
     * 
     * @param int $id The id to be retrieved.
     * 
     * @return object
     */
    public function get(int $id): object
    {
        return $this->db->query(
            "SELECT
                p.id,
                p.title,
                p.content,
                u.username,
                p.user_id
            FROM v_posts p
            INNER JOIN v_users u
            ON p.user_id = u.id
            WHERE p.id = :id",
            ['id' => $id]
        )->findClass("JRCS\Post");
    }
}