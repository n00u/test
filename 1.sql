
-- 1
CREATE TABLE `users` (
  `id` int AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(255)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Users';

CREATE TABLE `user_friends` (
  `id` int AUTO_INCREMENT PRIMARY KEY,
  `user_id` int,
  `friend_id` int,
  FOREIGN KEY (`user_id`) REFERENCES users(`id`),
  FOREIGN KEY (`friend_id`) REFERENCES users(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='User Friends'

-- 1.1
SELECT name 
FROM `users` u 
LEFT JOIN user_friends ON u.id = user_id 
GROUP BY u.id 
HAVING COUNT(user_id) > 5

-- 1.2
SELECT u1.name, u2.name 
FROM `user_friends` uf1,`user_friends` uf2
LEFT JOIN users u1 ON uf2.user_id = u1.id
LEFT JOIN users u2 ON uf2.friend_id = u2.id
WHERE uf1.friend_id = uf2.user_id AND uf2.friend_id = uf1.user_id AND uf1.user_id < uf2.user_id



