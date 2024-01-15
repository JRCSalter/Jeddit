USE jrcsalter;

DROP VIEW IF EXISTS v_users;

CREATE VIEW v_users AS
    SELECT
        id,
        username,
        first_name,
        last_name,
        email,
        birthday,
        created_at,
        updated_at
    FROM users;

DROP VIEW IF EXISTS v_posts;

CREATE VIEW v_posts AS
    SELECT
        id,
        title,
        content,
        user_id,
        created_at,
        updated_at
    FROM posts;

DROP VIEW IF EXISTS v_comments;

CREATE VIEW v_comments AS
    SELECT
        id,
        content,
        user_id,
        post_id,
        created_at,
        updated_at
    FROM comments;