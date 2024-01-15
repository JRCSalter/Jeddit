<?php

declare(strict_types=1);

namespace JRCS;

use Core\Database;

/**
 * Defines the comments
 */
class Comment
{
    /** @var Database The database to connect to. */
    //protected ?Database $db;

    /** @var string The name of the user. */
    protected string $username;

    /** @var array The comment data. */
    protected array $data;

    public function __construct(protected ?Database $db = NULL)
    {
        //$this->db = $db;
    }

    /**
     * Gets the specified information about the comment.
     * 
     * @param string $key The key to retrieve.
     * 
     * @return string
     */
    public function __get(string $key): string
    {
        return $this->data[$key];
    }

    /**
     * Sets the specified information about the comment.
     * 
     * @param string $key   The key to set.
     * @param string $value The value to set for the key.
     * 
     * @return void
     */
    public function __set(string $key, string $value): void
    {
        $this->data[$key] = $value;
    }

    /**
     * Returns the user's name.
     * 
     * @return string
     */
    public function author(): string
    {
        return $this->username;
    }

    /**
     * Gets all the comments for the specified post.
     * 
     * Fields retrieved: name, content.
     * 
     * @param int $id The ID of the post.
     * 
     * @return array
     */
    public function getAllForPost(int $id): array
    {
        return $this->db->query(
            "SELECT
                u.username,
                c.created_at,
                c.content
            FROM v_comments c
            INNER JOIN v_users u
            ON u.id = c.user_id
            WHERE c.post_id = :id",
            ['id' => $id]
        )->getClass("JRCS\Comment");
    }
}