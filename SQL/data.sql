USE jrcsalter;

INSERT INTO `users`    (first_name, last_name, username, email, password)   VALUES ('John', 'Salter', 'JRCSalter', 'jrc@jrcsalter.com', 'vrdsvfdsv');
INSERT INTO `users`    (first_name, last_name, username, email, password)   VALUES ('Stuart', 'Salter', 'SDSalter', 'sds@jrcsalter.com', 'bhuhibkibjh');
INSERT INTO `posts`    (title, content, user_id)      VALUES ('First Post', 'This is a post about stuff', 1);
INSERT INTO `posts`    (title, content, user_id)      VALUES ('Second Post', 'This is another post about different stuff', 2);
INSERT INTO `comments` (content, user_id, post_id)    VALUES ('FIRST!!!!', 1, 2);
INSERT INTO `comments` (content, user_id, post_id)    VALUES ('A comment', 2, 1);