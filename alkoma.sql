-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 29 sep. 2021 à 08:06
-- Version du serveur :  8.0.21
-- Version de PHP : 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `alkoma`
--
CREATE DATABASE IF NOT EXISTS `alkoma` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `alkoma`;

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  `idUsers` int NOT NULL,
  `idPosts` int NOT NULL,
  `author` varchar(255) NOT NULL,
  `datePublish` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `isValid` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `comments_posts_id_fk` (`idPosts`),
  KEY `comments_users_id_fk` (`idUsers`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`id`, `title`, `comment`, `idUsers`, `idPosts`, `author`, `datePublish`, `isValid`) VALUES
(9, 'Privacy Policy', 'Donec lacinia, velit eu finibus interdum, sem felis ultricies nibh, non rhoncus massa leo nec ligula. Quisque accumsan erat vestibulum sem accumsan venenatis. Vestibulum feugiat, nibh in pretium pulvinar, nunc mauris sollicitudin orci, in bibendum nisl nibh at metus. Pellentesque consequat rhoncus auctor. Curabitur elementum elit a varius aliquet. Cras nulla odio, imperdiet eget faucibus non, placerat ac arcu. Donec turpis nunc, interdum id semper vel, bibendum imperdiet lectus. In non nisi lacinia metus porttitor sollicitudin nec sed orci. Suspendisse blandit, sapien eu auctor feugiat, velit orci laoreet leo, vitae facilisis justo elit sed eros.', 2, 2, 'Abdel ATOKOU', '2021-09-29 09:52:01', 0),
(10, 'Nunc blandit mauris', 'Praesent gravida, tellus a imperdiet tempor, erat ipsum rutrum risus, nec scelerisque magna nisl id felis. Pellentesque bibendum pellentesque neque ac cursus. Nunc blandit mauris et fringilla tincidunt. Nullam a faucibus quam, et efficitur purus. Fusce tristique bibendum ultricies. Integer et sodales ipsum, et rutrum enim. Morbi volutpat ut sem a suscipit. Pellentesque placerat diam quis rhoncus mattis. Aliquam luctus, nulla et fringilla mollis, enim sapien convallis risus, ac gravida lectus urna interdum nunc. Mauris tempus erat vitae neque dictum cursus. Integer ultrices diam rhoncus nisl blandit dapibus. Mauris odio nisl, suscipit ac porttitor sed, hendrerit ut risus. Donec ac lacinia augue. Praesent ut metus porta, fermentum ipsum ut, finibus nisi. Suspendisse eget feugiat lorem.', 2, 4, 'Abdel ATOKOU', '2021-09-29 09:53:21', 0),
(11, 'Nullam quis accumsan', 'Nullam quis accumsan leo, accumsan egestas neque. Etiam purus risus, tempor nec porttitor a, pretium commodo nisl. Quisque et interdum tortor. Nunc commodo sit amet mi eu consequat. Mauris non enim magna. Praesent in felis sit amet nisl cursus pretium ultricies nec justo. Proin ornare libero libero, et accumsan sapien hendrerit ut. Nunc eu imperdiet lacus. Pellentesque vitae purus sed nisl auctor semper ac in erat. Donec scelerisque tincidunt orci sit amet tempor. Etiam congue urna enim, non auctor lectus posuere eget. Etiam efficitur lectus ac imperdiet pretium.', 2, 3, 'Abdel ATOKOU', '2021-09-29 09:53:48', 0),
(12, 'Sed hendrerit non ', 'Ut in lorem lacus. Proin rhoncus congue interdum. Fusce egestas sem et risus ultricies, at molestie ante dapibus. Cras sodales metus et neque ultricies mollis. Vivamus dignissim imperdiet lorem id laoreet. Curabitur massa lorem, placerat malesuada gravida quis, ornare eget urna. Aliquam et ornare sapien. Sed hendrerit non metus vel sodales. Vestibulum egestas bibendum purus id ullamcorper.', 2, 16, 'Abdel ATOKOU', '2021-09-29 09:54:17', 1),
(13, 'Ut in lorem lacus. Proin', 'Nullam quis accumsan leo, accumsan egestas neque. Etiam purus risus, tempor nec porttitor a, pretium commodo nisl. Quisque et interdum tortor. Nunc commodo sit amet mi eu consequat. Mauris non enim magna. Praesent in felis sit amet nisl cursus pretium ultricies nec justo. Proin ornare libero libero, et accumsan sapien hendrerit ut. Nunc eu imperdiet lacus. Pellentesque vitae purus sed nisl auctor semper ac in erat. Donec scelerisque tincidunt orci sit amet tempor. Etiam congue urna enim, non auctor lectus posuere eget. Etiam efficitur lectus ac imperdiet pretium.&#13;&#10;&#13;&#10;Ut in lorem lacus. Proin rhoncus congue interdum. Fusce egestas sem et risus ultricies, at molestie ante dapibus. Cras sodales metus et neque ultricies mollis. Vivamus dignissim imperdiet lorem id laoreet. Curabitur massa lorem, placerat malesuada gravida quis, ornare eget urna. Aliquam et ornare sapien. Sed hendrerit non metus vel sodales. Vestibulum egestas bibendum purus id ullamcorper.&#13;&#10;&#13;&#10;Curabitur tempus justo id eros pretium, sit amet eleifend justo laoreet. Fusce vehicula elit ut ligula fringilla, et tincidunt odio dictum. Aenean a augue placerat, blandit metus eu, consectetur nunc. Vestibulum scelerisque ipsum nec nibh eleifend, vel iaculis sapien malesuada. Vestibulum tempus sapien at orci ultrices dapibus. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Praesent non porta ligula, sed gravida orci. Suspendisse malesuada auctor sem, sed cursus velit faucibus eget.', 2, 15, 'Abdel ATOKOU', '2021-09-29 09:54:54', 1);

-- --------------------------------------------------------

--
-- Structure de la table `me`
--

DROP TABLE IF EXISTS `me`;
CREATE TABLE IF NOT EXISTS `me` (
  `id` int NOT NULL AUTO_INCREMENT,
  `myName` varchar(255) NOT NULL,
  `occupation` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phoneNumber` varchar(255) NOT NULL,
  `emailAddress` varchar(255) NOT NULL,
  `facebookLink` varchar(255) NOT NULL,
  `instagramLink` varchar(255) NOT NULL,
  `linkedinLink` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `me`
--

INSERT INTO `me` (`id`, `myName`, `occupation`, `address`, `phoneNumber`, `emailAddress`, `facebookLink`, `instagramLink`, `linkedinLink`) VALUES
(1, 'ALKOMA JUNIOR', 'Dev Symfony', '12 Rue de Lausanne, Strasbourg-France', '+22899535906', 'alkomajunior@outlook.com', 'https://www.facebook.com/komialog', 'https://www.instagram.com/alkomajunior', 'https://www.linkedin.com/in/aim%C3%A9-alognikou-6265a7215');

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `emailAddress` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `sendDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `isRead` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`id`, `name`, `emailAddress`, `subject`, `message`, `sendDate`, `isRead`) VALUES
(5, 'Lorem Ipsum', 'help@lipsum.com', 'Ceci est un test ', 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#39;t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn&#39;t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.', '2021-09-25 12:21:24', 1),
(6, 'MAWUSE KOMI AIME ALOGNIKOU', 'aimealognikou@outlook.com', 'Ceci est un test ', 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#39;t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn&#39;t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.', '2021-09-25 20:27:40', 1);

-- --------------------------------------------------------

--
-- Structure de la table `portfolio`
--

DROP TABLE IF EXISTS `portfolio`;
CREATE TABLE IF NOT EXISTS `portfolio` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `client` varchar(255) NOT NULL,
  `objective` text NOT NULL,
  `description` text NOT NULL,
  `datePublish` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `portfolio`
--

INSERT INTO `portfolio` (`id`, `title`, `client`, `objective`, `description`, `datePublish`, `image`) VALUES
(1, 'H. Rackham', 'AMAZON', 'But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful.', 'But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise, except to obtain some advantage from it? But who has any right to find fault with a man who chooses to enjoy a pleasure that has no annoying consequences, or one who avoids a pain that produces no resultant pleasure ?', '2021-09-17 11:43:58', '5'),
(2, 'Section 1.10.32', 'CDISCOUNT', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur ?', '2021-09-17 11:54:42', '6'),
(3, 'Rackham', 'DELL', 'On the other hand, we denounce with righteous indignation and dislike men who are so beguiled and demoralized by the charms of pleasure of the moment, so blinded by desire, that they cannot foresee the pain and trouble that are bound to ensue; and equal blame belongs to those who fail in their duty through weakness of will, which is the same as saying through shrinking from toil and pain. These cases are perfectly simple and easy to distinguish.', 'On the other hand, we denounce with righteous indignation and dislike men who are so beguiled and demoralized by the charms of pleasure of the moment, so blinded by desire, that they cannot foresee the pain and trouble that are bound to ensue; and equal blame belongs to those who fail in their duty through weakness of will, which is the same as saying through shrinking from toil and pain. These cases are perfectly simple and easy to distinguish. In a free hour, when our power of choice is untrammelled and when nothing prevents our being able to do what we like best, every pleasure is to be welcomed and every pain avoided. But in certain circumstances and owing to the claims of duty or the obligations of business it will frequently occur that pleasures have to be repudiated and annoyances accepted. The wise man therefore always holds in these matters to this principle of selection: he rejects pleasures to secure other greater pleasures, or else he endures pains to avoid worse pains.', '2021-09-17 13:34:20', '1'),
(4, 'Finibus Bonorum', 'LDLC', 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio.', 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.', '2021-09-17 13:36:34', '2'),
(6, 'The standard Lorem', 'BYLL BORIS', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2021-09-24 08:48:34', '9');

-- --------------------------------------------------------

--
-- Structure de la table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `datePublish` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id` int NOT NULL AUTO_INCREMENT,
  `caption` text NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `posts`
--

INSERT INTO `posts` (`title`, `description`, `datePublish`, `id`, `caption`, `image`) VALUES
('Why do we use it?', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#39;Content here, content here&#39;, making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for &#39;lorem ipsum&#39; will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).', '2021-09-06 16:41:39', 2, 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#39;Content here.', '4'),
('Where can I get some?', 'If you are going to use a passage of Lorem Ipsum, you need to be sure there isn&#39;t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.', '2021-09-17 20:27:46', 3, 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#39;t look even slightly believable.', '3'),
('Lorem Ipsum', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur aliquet dolor vitae ante convallis, et vehicula dui efficitur. Ut imperdiet, ex in pulvinar suscipit, metus ipsum molestie justo, in tincidunt urna turpis accumsan mi. Nullam rhoncus nunc non elit pulvinar, a euismod dui rutrum. Etiam commodo laoreet felis, at bibendum libero auctor at. Donec aliquet arcu quis lacus rutrum fermentum. Fusce ut est ullamcorper sapien consequat luctus. Sed semper elementum nisl eu vulputate. Aenean scelerisque arcu et erat suscipit blandit. Praesent suscipit dignissim dolor sit amet venenatis. Nullam eget porttitor nisi, vel lacinia erat. Vestibulum vitae nibh erat. Donec et neque facilisis, cursus diam nec, vulputate erat. Integer bibendum augue ante, id commodo nunc pharetra in. Vivamus varius lacus ut ante placerat sagittis.', '2021-09-23 15:46:59', 4, 'Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...&#13;&#10;There is no one who loves pain itself, who seeks after it and wants to have it, simply because it is pain...&#13;&#10;', '7'),
('Where does it come from?', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of &#34;de Finibus Bonorum et Malorum&#34; (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, &#34;Lorem ipsum dolor sit amet..&#34;, comes from a line in section 1.10.32.', '2021-09-23 18:42:39', 15, 'The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from &#34;de Finibus Bonorum et Malorum&#34; by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.', '4'),
('The standard Lorem Ipsum passage, used since the 1500s', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur ?', '2021-09-23 18:43:41', 16, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '8');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `emailAddress` varchar(255) NOT NULL,
  `phoneNumber` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `datePublish` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `firstName`, `lastName`, `emailAddress`, `phoneNumber`, `password`, `role`, `datePublish`) VALUES
(1, 'Junior', 'ALKOMA', 'admin@alkoma.com', '+22899535906', '$argon2id$v=19$m=16,t=2,p=1$ZjVWQjlVd1FSVll2Z1d3dw$HgRUK1h4YshrqtK9MQpLlQ', 'ADMIN', '2021-09-25 16:49:28'),
(2, 'Abdel', 'ATOKOU', 'a.atokou@gmail.com', '+22874568314', '$argon2id$v=19$m=65536,t=4,p=1$MS84a2dubTNKQVEwMnJqYg$/ipD8DfsmcgAATKWdAR22MWvG/Kd0SSjsi8DyHh86wg', 'USER', '2021-09-25 16:49:28');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
