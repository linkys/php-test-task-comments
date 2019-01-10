-- Adminer 4.6.2 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `comments` (`id`, `name`, `email`, `message`, `created_at`) VALUES
(3,	'Vlad',	'mihailyukov.vlad@gmail.com',	'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad atque culpa eaque illo illum inventore ipsam iusto libero maiores minima nesciunt, nihil non nostrum numquam reprehenderit suscipit, tempore ullam veritatis.',	'2019-01-08 12:21:54'),
(4,	'Joshua',	'z3fcn@gmail.com',	'Architecto aut eius obcaecati quisquam quos tempora voluptatum! Ad animi aperiam atque autem culpa cum dignissimos dolore dolores dolorum eius esse expedita fuga illo impedit in maiores, molestias necessitatibus nemo neque nesciunt nihil non, numquam quasi rem repellat, saepe sed similique sint sunt ullam veniam voluptas voluptates voluptatum! Accusantium consequatur, corporis debitis enim ex fuga id ipsum laborum mollitia neque nobis placeat quam quos reprehenderit vitae?',	'2019-01-09 17:38:31');

-- 2019-01-10 00:02:40
