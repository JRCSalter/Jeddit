USE `jrcsalter`;

DROP ROLE IF EXISTS `public_role`;

CREATE ROLE IF NOT EXISTS `public_role`;

DROP ROLE IF EXISTS `pw_role`;

CREATE ROLE IF NOT EXISTS `pw_role`;

GRANT
    SELECT
ON `jrcsalter`.v_users
TO `public_role`;

GRANT
    SELECT
ON `jrcsalter`.users
TO `pw_role`;

GRANT
    SELECT
ON `jrcsalter`.v_posts
TO `public_role`;

GRANT
    SELECT
ON `jrcsalter`.v_comments
TO `public_role`;

GRANT
    INSERT,
    UPDATE,
    DELETE
ON `jrcsalter`.users
TO `public_role`;

GRANT
    INSERT,
    UPDATE,
    DELETE
ON `jrcsalter`.posts
TO `public_role`;

GRANT
    INSERT,
    UPDATE,
    DELETE
ON `jrcsalter`.comments
TO `public_role`;

DROP USER IF EXISTS `public`;

CREATE USER IF NOT EXISTS `public`;

DROP USER IF EXISTS `pw_user`;

CREATE USER IF NOT EXISTS `pw_user`;

GRANT `public_role` TO `public`;

SET DEFAULT ROLE `public_role` TO `public`;

GRANT `pw_role` TO `pw_user`;

SET DEFAULT ROLE `pw_role` TO `pw_user`;