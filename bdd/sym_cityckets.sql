-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 25 mai 2022 à 12:48
-- Version du serveur :  5.7.31
-- Version de PHP : 7.4.9
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */
;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */
;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */
;
/*!40101 SET NAMES utf8mb4 */
;
--
-- Base de données : `sym_cityckets`
--
CREATE DATABASE IF NOT EXISTS `sym_cityckets` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `sym_cityckets`;
-- --------------------------------------------------------
--
-- Structure de la table `departement`
--
DROP TABLE IF EXISTS `departement`;
CREATE TABLE IF NOT EXISTS `departement` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB AUTO_INCREMENT = 31 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
--
-- Déchargement des données de la table `departement`
--
INSERT INTO `departement` (`id`, `name`)
VALUES (21, 'Clerc'),
    (22, 'Ollivier'),
    (23, 'Collin S.A.S.'),
    (24, 'Jacquet Lenoir SA'),
    (25, 'Le Roux Devaux S.A.R.L.'),
    (26, 'Chevalier Vidal S.A.S.'),
    (27, 'Gilbert Leconte SARL'),
    (28, 'Hubert'),
    (29, 'Bertrand'),
    (30, 'Deschamps');
-- --------------------------------------------------------
--
-- Structure de la table `doctrine_migration_versions`
--
DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
    `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
    `executed_at` datetime DEFAULT NULL,
    `execution_time` int(11) DEFAULT NULL,
    PRIMARY KEY (`version`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci;
--
-- Déchargement des données de la table `doctrine_migration_versions`
--
INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`)
VALUES (
        'DoctrineMigrations\\Version20220523115919',
        '2022-05-23 12:05:12',
        261
    ),
    (
        'DoctrineMigrations\\Version20220524075121',
        '2022-05-24 08:02:12',
        2004
    ),
    (
        'DoctrineMigrations\\Version20220524112754',
        '2022-05-24 11:28:34',
        596
    ),
    (
        'DoctrineMigrations\\Version20220525090349',
        '2022-05-25 09:05:17',
        269
    );
-- --------------------------------------------------------
--
-- Structure de la table `ticket`
--
DROP TABLE IF EXISTS `ticket`;
CREATE TABLE IF NOT EXISTS `ticket` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `message` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
    `comment` longtext COLLATE utf8mb4_unicode_ci,
    `is_active` tinyint(1) NOT NULL,
    `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
    `finished_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
    `object` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `departement_id` int(11) NOT NULL,
    PRIMARY KEY (`id`),
    KEY `IDX_97A0ADA3CCF9E01E` (`departement_id`)
) ENGINE = InnoDB AUTO_INCREMENT = 103 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
--
-- Déchargement des données de la table `ticket`
--
INSERT INTO `ticket` (
        `id`,
        `message`,
        `comment`,
        `is_active`,
        `created_at`,
        `finished_at`,
        `object`,
        `departement_id`
    )
VALUES (
        69,
        'Non dolorem rerum quis adipisci asperiores eaque quod dolor. Sint expedita est qui aliquam aut quia est. Perspiciatis nam pariatur laborum fugit rem. Maiores ullam consectetur ut voluptatem sapiente nihil omnis cumque.',
        'In aut excepturi doloribus. Officia similique iusto eligendi rerum assumenda laborum quod. Enim voluptatibus et ratione maxime.',
        0,
        '2022-05-25 09:59:33',
        '2022-10-23 23:18:54',
        'Delectus tempora cumque ea et sunt.',
        23
    ),
    (
        70,
        'Et vitae aut ut voluptatem voluptates nulla sapiente inventore. Temporibus voluptas facere voluptatem sit amet illum accusantium. Provident atque et voluptate accusantium voluptatem cum ab quia.',
        'Totam pariatur aut quidem magni qui quod expedita. Fugiat ab placeat alias dolore maxime. Et dignissimos quia eum quibusdam non eligendi qui at.',
        1,
        '2022-05-25 09:59:33',
        NULL,
        'Et dignissimos facere praesentium soluta omnis aliquid itaque.',
        28
    ),
    (
        71,
        'Quisquam consectetur suscipit at non quas fugit aperiam. Dolorem quibusdam hic labore impedit porro minus atque. Libero autem in est dolor id architecto voluptas. Expedita deleniti optio ut quasi.',
        'Officiis vitae enim unde qui voluptas. Dolores dolorem ipsa et expedita minus distinctio rem. Aperiam dolorem voluptatem asperiores.',
        0,
        '2022-05-25 09:59:33',
        '2022-10-18 00:51:01',
        'Consequatur quis tempore animi tenetur.',
        27
    ),
    (
        72,
        'Eveniet velit nemo blanditiis error iste recusandae qui. Dolorum ipsum mollitia iusto aut. Eligendi doloremque maxime exercitationem labore quod doloremque. Error id error occaecati tempora quam deleniti.',
        'Vitae voluptas ut totam possimus saepe amet. Inventore dolorum sed qui dicta doloremque voluptatum. Mollitia voluptas veritatis illum atque. Id voluptas labore nisi cumque beatae cum.',
        1,
        '2022-05-25 09:59:33',
        NULL,
        'Et molestiae voluptatibus iure dolores et.',
        25
    ),
    (
        73,
        'Dolor tempore minus exercitationem officia et et et. Eius distinctio tempora eaque fugit et deserunt similique. Id id molestiae enim assumenda odit recusandae ea dolore. Omnis molestiae sed quia consequatur.',
        'Veniam eos veritatis ut officiis enim eaque est. Natus commodi quis possimus dignissimos. Qui consequuntur natus praesentium consectetur provident.',
        1,
        '2022-05-25 09:59:33',
        NULL,
        'Non velit exercitationem reiciendis molestias mollitia nulla.',
        28
    ),
    (
        74,
        'Nulla magni officia et eligendi quia. Voluptatibus repudiandae distinctio id et amet. Dolore vel mollitia sint voluptas. Ad fuga maxime occaecati temporibus ex et unde.',
        'Autem temporibus delectus facilis quia. Eos laborum accusamus corrupti architecto enim et. Quas voluptates sint aut dolores qui. Ut odio dolores est quibusdam quasi.',
        1,
        '2022-05-25 09:59:33',
        NULL,
        'Molestiae similique ut tempora ipsum vel aut.',
        23
    ),
    (
        75,
        'A quis natus sapiente atque. Mollitia veniam possimus assumenda rerum. Reprehenderit ea occaecati qui aperiam minima accusantium. Sed dolor quis molestias vitae beatae animi ullam.',
        'Consequatur voluptates eos voluptates et similique. Aspernatur a vitae cumque eligendi enim quam. Fuga rerum iste molestiae reprehenderit sed earum. Ab quas ex inventore in rerum aliquid amet.',
        1,
        '2022-05-25 09:59:33',
        NULL,
        'Qui et et aut nihil qui.',
        25
    ),
    (
        76,
        'A dolore sit recusandae. Alias consequuntur aut iure est veritatis illum sit ex.',
        'Vel nihil nisi iure. Debitis beatae rerum recusandae ut expedita. Qui pariatur maxime incidunt quas error quis optio. Minus eveniet et sapiente corporis quia consequatur explicabo consequatur. Totam et qui dolor labore quasi ipsa.',
        0,
        '2022-05-25 09:59:33',
        '2022-10-20 09:44:54',
        'Saepe provident accusamus aut ut ducimus.',
        23
    ),
    (
        77,
        'Sit quaerat aut et ut voluptatibus minima aliquam. Voluptatum voluptatibus ab et quia necessitatibus. Autem dolores odit minus est repellendus qui sint reprehenderit. Beatae impedit delectus eos ut in ex quas qui.',
        'Similique voluptatem possimus asperiores. Vero quis nulla aut officiis velit totam. Eligendi fugiat sed assumenda corporis sequi dolor. Sit et aliquid fugit eveniet possimus porro ducimus qui.',
        1,
        '2022-05-25 09:59:33',
        NULL,
        'Et consectetur sit dolor et delectus.',
        28
    ),
    (
        78,
        'Perferendis saepe quae et voluptatem nesciunt in itaque. Qui doloremque dicta nemo voluptatibus ullam. Est quidem ullam alias esse dolores. Id aliquam dolore magni.',
        'Nesciunt dolor eum omnis commodi iusto similique enim recusandae. Ipsa est debitis reprehenderit officiis. Voluptate consequatur facere corporis eos aspernatur incidunt praesentium. Iste repellat dolores quo eligendi.',
        0,
        '2022-05-25 09:59:33',
        '2022-08-11 12:20:25',
        'Corporis vel odio maiores aliquid.',
        21
    ),
    (
        79,
        'Non repellendus consequatur dolorem omnis. Architecto repellendus quia voluptas ab nam nihil. Est earum labore non velit animi consectetur.',
        'Tenetur quo sequi ut magni officiis. Nostrum dolor non totam autem.',
        1,
        '2022-05-25 09:59:33',
        NULL,
        'Qui quia dolore libero nihil quaerat delectus vel.',
        23
    ),
    (
        80,
        'Et voluptatem molestias optio laboriosam. Voluptatem et illo rerum. Laborum dolorum eum modi architecto.',
        'Consequatur reiciendis possimus id debitis. Voluptatem molestiae eius voluptatem cupiditate aliquam est. Ea distinctio provident quos aut.',
        0,
        '2022-05-25 09:59:33',
        '2022-06-17 03:15:15',
        'Dolorem esse veritatis vero distinctio ipsam sunt.',
        29
    ),
    (
        81,
        'Est occaecati harum fugiat culpa accusantium ipsam. Ipsum ullam odio tempore adipisci eligendi praesentium expedita voluptatum. Et cum sit repellat ut repellendus eaque suscipit dolorum. Omnis cum voluptas sit porro quia.',
        'Amet ullam suscipit eius aliquid eos hic iusto. Expedita nisi nulla magnam non sapiente aperiam. Ad provident vero dolore aperiam nisi numquam modi aspernatur. Et est molestiae quis totam beatae quod.',
        1,
        '2022-05-25 09:59:33',
        NULL,
        'Hic provident reiciendis nisi voluptas.',
        26
    ),
    (
        82,
        'Ut aut odio in sed ab sint modi vel. Laboriosam et sed perferendis quis rerum molestiae dolorem sed. Autem cupiditate quis quis similique natus dolor qui.',
        'Voluptatem neque dolorem fuga ducimus. Eum necessitatibus iusto et placeat. Cupiditate exercitationem quo beatae minima.',
        1,
        '2022-05-25 09:59:33',
        NULL,
        'Eos consequatur beatae nihil ea sit veritatis voluptas.',
        28
    ),
    (
        83,
        'Dicta molestias quia nemo consequatur odit totam accusantium facere. Facere eum architecto autem sit. Autem reiciendis eaque repellat non possimus enim ut cum.',
        'Iure consequuntur sed tempore voluptate. Tempora velit voluptatem totam ad. Molestiae cum explicabo harum fugit nihil asperiores. Occaecati et et est quo.',
        1,
        '2022-05-25 09:59:33',
        NULL,
        'Quia ipsa sequi necessitatibus et minima voluptas.',
        24
    ),
    (
        84,
        'Atque ut atque sunt est dolore recusandae voluptas est. Quis ratione doloribus neque incidunt voluptas. Est optio quasi incidunt inventore quas tempore. Aspernatur dolore illum consectetur neque dolor delectus consequatur.',
        'Voluptatem facere inventore possimus quaerat. Autem est dolore commodi fugiat voluptatem eveniet. Veritatis ex cupiditate quis non et quo ut. Dicta amet et sit provident dolores minima. Eius eum aut sunt voluptatem quae asperiores.',
        0,
        '2022-05-25 09:59:33',
        '2022-07-01 05:56:00',
        'A earum iusto illum dolores.',
        27
    ),
    (
        85,
        'Ipsa facere quia labore. Animi repellat nihil ea. Nobis cum aut ea sed perspiciatis aut ipsa.',
        'Repellat perferendis doloribus voluptas praesentium aut. Aut quos deleniti ullam velit sint neque. Repellendus reiciendis non autem ea ipsum quam et. Totam voluptatem voluptatem eum pariatur ut ducimus molestias inventore.',
        1,
        '2022-05-25 09:59:33',
        NULL,
        'Autem eaque explicabo debitis aperiam et.',
        26
    ),
    (
        86,
        'Impedit aut blanditiis nihil. Iste nobis animi ipsam quia alias perspiciatis amet eaque. Dolorum voluptas recusandae ea laboriosam voluptas. Ut et fugit commodi nisi perspiciatis incidunt animi voluptate. Voluptas voluptas perspiciatis in molestiae sunt.',
        'Ad sit quas delectus quia voluptatem. Eos fugiat exercitationem voluptas est sit architecto. Harum ipsa itaque nihil atque reprehenderit nam. Nesciunt nesciunt et eligendi qui quisquam unde.',
        0,
        '2022-05-25 09:59:33',
        '2022-11-05 17:13:59',
        'Aspernatur in quis cupiditate labore dolores explicabo quidem fugiat.',
        23
    ),
    (
        87,
        'Et exercitationem sed accusantium in quod et doloremque. Repellendus veniam ratione non ut quia quas placeat in. Quidem ea corporis occaecati quidem vel dolorem id. Quia perferendis tenetur veritatis non aut quod.',
        'Quos cumque minima sit sed corrupti ipsum maiores eveniet. Aspernatur vero aut suscipit autem doloribus.',
        0,
        '2022-05-25 09:59:33',
        '2022-10-27 03:38:39',
        'Soluta ea id provident blanditiis facilis.',
        29
    ),
    (
        88,
        'Vero tempore qui deleniti natus. Dolor impedit similique vitae et iure sequi atque. Odit sit similique saepe aut. Veniam quae numquam iusto provident. Deleniti voluptatem et aliquam beatae.',
        'Voluptas et blanditiis sit quis velit. Quia dolor inventore nobis maxime expedita illum ut. Reiciendis est rerum rerum repellat.',
        0,
        '2022-05-25 09:59:33',
        '2022-09-16 19:11:32',
        'Vel vel aliquam nulla quaerat omnis voluptas similique vel.',
        30
    ),
    (
        89,
        'Itaque iure ad itaque qui maiores rerum quisquam. Magni officia exercitationem repellat incidunt aut suscipit aut. Laudantium itaque sapiente nemo omnis et. Sed qui dolorem est quo.',
        'Placeat molestiae ipsam dolor voluptas neque. Rerum enim ut et magnam. Asperiores aut autem inventore rem tempore quisquam.',
        1,
        '2022-05-25 09:59:33',
        NULL,
        'Ab nemo rerum aut dolores reiciendis.',
        22
    ),
    (
        90,
        'Quo minima ut sed quod. Consequatur tenetur quibusdam et ea accusantium omnis. Qui velit accusamus atque aliquid.',
        'Rerum quia ut dicta numquam. Accusamus velit voluptatem minima voluptate.',
        1,
        '2022-05-25 09:59:33',
        NULL,
        'Et libero accusamus nesciunt.',
        26
    ),
    (
        91,
        'Quo tempora ipsum officiis enim repellendus temporibus consequuntur libero. Quam deserunt modi corrupti aut est omnis consequatur. Provident corporis ullam enim sit consequatur laborum ipsum. Assumenda non et ipsa fugiat ut. Molestiae eius perspiciatis nisi non eligendi voluptas.',
        'Ea placeat nihil officiis dolore saepe. Assumenda rerum facere aspernatur quibusdam soluta rem eos. Voluptas qui et magni dolorum repellendus est. Error quia rerum accusamus sit doloribus doloremque blanditiis.',
        0,
        '2022-05-25 09:59:33',
        '2022-06-28 05:39:46',
        'Quisquam ab dolorem neque ut minima ea excepturi.',
        23
    ),
    (
        92,
        'Sapiente doloremque corrupti recusandae. Pariatur voluptas pariatur laborum fugit nihil minima odit. Quibusdam accusantium recusandae tenetur nisi esse vero amet. Non quos hic totam consequuntur quis.',
        'Aliquid unde et quo accusantium rem. Soluta dolore facere esse alias delectus quae. Repudiandae aut ullam eaque. Asperiores quo placeat distinctio voluptatum sit nemo quod.',
        1,
        '2022-05-25 09:59:33',
        NULL,
        'Qui est magnam ut modi natus.',
        29
    ),
    (
        93,
        'Praesentium consequatur quam veniam. Quia quia id qui aut dignissimos. Necessitatibus iste ut fugiat.',
        'Odit non aliquam sunt. Nulla non dolorem pariatur quaerat deserunt assumenda. Quia repudiandae et error unde voluptatem omnis et id.',
        0,
        '2022-05-25 09:59:33',
        '2022-07-22 23:16:09',
        'Nihil ullam et in esse ut quia sapiente.',
        23
    ),
    (
        94,
        'Aliquid reiciendis alias quibusdam voluptates molestias et quo ducimus. Dolorem rerum rerum unde. Ad consequatur officia provident dignissimos eum perferendis quasi.',
        'Similique fugit ad quibusdam omnis iusto fugit. Quibusdam deserunt officia est. Quia ducimus et ut numquam autem voluptatem. Ut similique et neque sit nihil aperiam.',
        1,
        '2022-05-25 09:59:33',
        NULL,
        'Repellendus dolor expedita voluptatibus autem.',
        27
    ),
    (
        95,
        'Eos qui quae rerum ullam. Voluptate odio voluptate et ab eos. Quis atque minima aut officiis. Quia ut reiciendis praesentium temporibus numquam optio.',
        'Nulla saepe explicabo quia quisquam voluptas consequatur porro. Saepe aut illo commodi facere enim sit. In unde iure veniam placeat et et.',
        1,
        '2022-05-25 09:59:33',
        NULL,
        'Velit accusantium quam et consequatur.',
        28
    ),
    (
        96,
        'Omnis eum est laudantium laudantium. Aliquam dolores quia cum. Ut repudiandae minus consequatur quia. Consectetur sint beatae odit fuga eos quia. Id repudiandae mollitia praesentium aspernatur iste.',
        'Veniam explicabo asperiores et voluptate voluptas quaerat cum minus. Nemo aut sequi tempora deleniti quisquam ut.',
        1,
        '2022-05-25 09:59:33',
        NULL,
        'Enim quia inventore ratione perferendis reprehenderit quas.',
        26
    ),
    (
        97,
        'Itaque et aut nostrum. Recusandae officiis et omnis. Error temporibus laudantium minima atque.',
        'Officia velit aliquid rem et ea. Voluptates qui quis ex et ex rerum. Eligendi rem aspernatur voluptatibus consequuntur modi.',
        1,
        '2022-05-25 09:59:33',
        NULL,
        'Quo eos voluptatum labore dolores.',
        25
    ),
    (
        98,
        'Aliquid laborum eligendi tempore omnis. Voluptatum est omnis pariatur aliquam. Similique explicabo et temporibus id quia.',
        'Possimus iusto consequatur eum. Odio corporis ex natus id atque.',
        0,
        '2022-05-25 09:59:33',
        '2022-07-07 14:54:08',
        'Illo vitae ea necessitatibus optio aut reiciendis magnam.',
        26
    ),
    (
        99,
        'Impedit sapiente dignissimos est tempora soluta ducimus adipisci. Delectus voluptate aperiam et delectus sequi aut. Quidem corporis et veniam.',
        'Maiores labore eaque velit ut dicta adipisci voluptas. Voluptatem aliquid reprehenderit impedit culpa. Error numquam cum laborum est veniam. Quasi quaerat et odio unde quia quis nisi error.',
        1,
        '2022-05-25 09:59:33',
        NULL,
        'Neque totam eum sequi et.',
        23
    ),
    (
        100,
        'Accusamus quam ipsam non ut. Dicta non aliquid suscipit quia numquam sed voluptatum omnis. Ipsum ratione modi incidunt minus blanditiis. Quos aut quas facere autem.',
        'Sed omnis eveniet officiis modi cum. Et nostrum molestias est doloremque. Illum sunt aliquid voluptatibus quas et. Quaerat accusamus et ut molestias in qui repudiandae.',
        1,
        '2022-05-25 09:59:33',
        NULL,
        'Quam vitae ipsum animi est quia neque illum.',
        24
    ),
    (
        101,
        'Suscipit neque eos qui laborum dolor hic officiis cumque. Aut qui et sit dolores nihil enim autem. Doloremque ad non nihil omnis explicabo vitae. Nostrum voluptatem aut omnis maxime.',
        'Error ut eius sit iure. Qui quam deserunt ut qui provident tenetur eligendi. Consequuntur natus qui molestiae.',
        1,
        '2022-05-25 09:59:33',
        NULL,
        'Quam quae nostrum magni consequatur.',
        25
    ),
    (
        102,
        'Sit mollitia voluptate molestias id nulla at illum. Aliquam modi vero optio. Similique et inventore eum non.',
        'Quia necessitatibus necessitatibus quia perferendis. Libero voluptas qui labore. Amet voluptas ab non non fugiat deserunt sit qui.',
        0,
        '2022-05-25 09:59:33',
        '2022-11-15 08:01:43',
        'Delectus adipisci error sunt quas voluptates.',
        23
    );
-- --------------------------------------------------------
--
-- Structure de la table `user`
--
DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
    `roles` json NOT NULL,
    `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE = InnoDB AUTO_INCREMENT = 6 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
--
-- Déchargement des données de la table `user`
--
INSERT INTO `user` (`id`, `email`, `roles`, `password`, `name`)
VALUES (
        1,
        'admin@test.bzh',
        '[\"ROLE_ADMIN\"]',
        '$2y$13$E/UoIEvv.tr3mpseahxCSOnwIuytOT57ED1TPJzahozYO2znjN8Pi',
        'Hugues Daniel-Charrier'
    ),
    (
        2,
        'user1@test.bzh',
        '[]',
        '$2y$13$3Htsu1PRv/i0C5Re8J.Xr.8FSE/X.yDDPVqVApkwHLtHnWGBoxs72',
        'Grégoire-Édouard Dupont'
    ),
    (
        3,
        'user2@test.bzh',
        '[]',
        '$2y$13$eGUFFck/jrd9yVah32sDougiVwxzWMddY/oc7tSaha21XyLYoIeQi',
        'Jules Vallee'
    ),
    (
        4,
        'user3@test.bzh',
        '[]',
        '$2y$13$MEyIcNtvmu5D4Q5xBLYtpOWM7jmcz2OozRpeYaEfXN/KTvyOkFfyC',
        'Maryse Lelievre'
    ),
    (
        5,
        'user4@test.bzh',
        '[]',
        '$2y$13$68CBYZ91yWEoY6aIuNJjoeANU3vMYGJPEL2TFZePzgIOfS/WInzo2',
        'Juliette Martel'
    );
--
-- Contraintes pour les tables déchargées
--
--
-- Contraintes pour la table `ticket`
--
ALTER TABLE `ticket`
ADD CONSTRAINT `FK_97A0ADA3CCF9E01E` FOREIGN KEY (`departement_id`) REFERENCES `departement` (`id`);
COMMIT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */
;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */
;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */
;