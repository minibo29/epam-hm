
-- Select all active posts
SELECT posts.*, users.first_name, users.last_name FROM posts
	JOIN users on posts.autor_id = users.id
	WHERE posts.active = 1
    ORDER BY posts.createAt desc
    LIMIT 10
    ;
-- Select all "need to review" posts
SELECT * FROM blog.posts WHERE reviewed = 0;

-- Count fo users posts
SELECT COUNT(posts.id) as count,users.id, users.first_name, users.last_name, email  FROM posts
	JOIN users on posts.autor_id = users.id
	WHERE posts.active = 1
    GROUP BY id;

-- Select all active posts of users
SELECT posts.*, users.first_name, users.last_name FROM posts
	JOIN users on posts.autor_id = users.id
	WHERE posts.active = 1 and posts.autor_id IN (SELECT id FROM users WHERE id IN (2, 3))
    ORDER BY posts.createAt desc
    ;

SELECT title, text, active, createAt, updateAt
   FROM posts
   UNION
   SELECT first_name as title, last_name as text, active, createAt, updateAt
   FROM users
   ;

-- Select all active posts
SELECT COUNT(posts.id) as count, users.first_name, users.last_name FROM posts
	JOIN users on posts.autor_id = users.id
	WHERE posts.active = 1
	GROUP BY first_name, last_name
    HAVING count > 2
    ;
