/*
 Navicat Premium Data Transfer

 Source Server         : Localhost
 Source Server Type    : MySQL
 Source Server Version : 50733
 Source Host           : localhost:3306
 Source Schema         : the_black_hand

 Target Server Type    : MySQL
 Target Server Version : 50733
 File Encoding         : 65001

 Date: 19/09/2026 15:37:19
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for comments
-- ----------------------------
DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `full_name` varchar(191) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'Nombre completo',
  `email` varchar(191) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'correo electronico',
  `comment` longblob NULL COMMENT 'comentario',
  `answered` tinyint(1) NULL DEFAULT NULL COMMENT 'Respondido',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of comments
-- ----------------------------

-- ----------------------------
-- Table structure for countries
-- ----------------------------
DROP TABLE IF EXISTS `countries`;
CREATE TABLE `countries`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `code_phone` int(11) NULL DEFAULT NULL,
  `code_iso2` char(2) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `code_iso3` char(3) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `is_active` tinyint(1) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 32 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of countries
-- ----------------------------
INSERT INTO `countries` VALUES (1, 'Argentina', NULL, 'AR', 'ARG', 1, '2026-02-20 21:48:37', '2026-02-20 21:48:37');
INSERT INTO `countries` VALUES (2, 'Bolivia', NULL, 'BO', 'BOL', 1, '2026-02-20 21:48:37', '2026-02-20 21:48:37');
INSERT INTO `countries` VALUES (3, 'Brasil', NULL, 'BR', 'BRA', 1, '2026-02-20 21:48:37', '2026-02-20 21:48:37');
INSERT INTO `countries` VALUES (4, 'Chile', NULL, 'CL', 'CHL', 1, '2026-02-20 21:48:37', '2026-02-20 21:48:37');
INSERT INTO `countries` VALUES (5, 'Colombia', 57, 'CO', 'COL', 1, '2026-02-20 21:48:37', '2026-02-20 21:48:37');
INSERT INTO `countries` VALUES (6, 'Costa Rica', NULL, 'CR', 'CRI', 1, '2026-02-20 21:48:37', '2026-02-20 21:48:37');
INSERT INTO `countries` VALUES (7, 'Cuba', NULL, 'CU', 'CUB', 1, '2026-02-20 21:48:37', '2026-02-20 21:48:37');
INSERT INTO `countries` VALUES (8, 'Ecuador', NULL, 'EC', 'ECU', 1, '2026-02-20 21:48:37', '2026-02-20 21:48:37');
INSERT INTO `countries` VALUES (9, 'El Salvador', NULL, 'SV', 'SLV', 1, '2026-02-20 21:48:37', '2026-02-20 21:48:37');
INSERT INTO `countries` VALUES (10, 'Guatemala', NULL, 'GT', 'GTM', 1, '2026-02-20 21:48:37', '2026-02-20 21:48:37');
INSERT INTO `countries` VALUES (11, 'Haití', NULL, 'HT', 'HTI', 1, '2026-02-20 21:48:37', '2026-02-20 21:48:37');
INSERT INTO `countries` VALUES (12, 'Honduras', NULL, 'HN', 'HND', 1, '2026-02-20 21:48:37', '2026-02-20 21:48:37');
INSERT INTO `countries` VALUES (13, 'México', NULL, 'MX', 'MEX', 1, '2026-02-20 21:48:37', '2026-02-20 21:48:37');
INSERT INTO `countries` VALUES (14, 'Nicaragua', NULL, 'NI', 'NIC', 1, '2026-02-20 21:48:37', '2026-02-20 21:48:37');
INSERT INTO `countries` VALUES (15, 'Panamá', NULL, 'PA', 'PAN', 1, '2026-02-20 21:48:37', '2026-02-20 21:48:37');
INSERT INTO `countries` VALUES (16, 'Paraguay', NULL, 'PY', 'PRY', 1, '2026-02-20 21:48:37', '2026-02-20 21:48:37');
INSERT INTO `countries` VALUES (17, 'Perú', NULL, 'PE', 'PER', 1, '2026-02-20 21:48:37', '2026-02-20 21:48:37');
INSERT INTO `countries` VALUES (18, 'Puerto Rico', NULL, 'PR', 'PRI', 1, '2026-02-20 21:48:37', '2026-02-20 21:48:37');
INSERT INTO `countries` VALUES (19, 'República Dominicana', NULL, 'DO', 'DOM', 1, '2026-02-20 21:48:37', '2026-02-20 21:48:37');
INSERT INTO `countries` VALUES (20, 'Uruguay', NULL, 'UY', 'URY', 1, '2026-02-20 21:48:37', '2026-02-20 21:48:37');
INSERT INTO `countries` VALUES (21, 'Venezuela', 58, 'VE', 'VEN', 1, '2026-02-20 21:48:37', '2026-02-20 21:48:37');
INSERT INTO `countries` VALUES (22, 'Estados Unidos', 1, 'US', 'USA', 1, '2026-02-20 21:48:37', '2026-02-20 21:48:37');
INSERT INTO `countries` VALUES (23, 'España', 34, 'ES', 'ESP', 1, '2026-02-20 21:48:37', '2026-02-20 21:48:37');
INSERT INTO `countries` VALUES (24, 'Alemania', 49, 'DE', 'DEU', 1, '2026-02-20 21:48:37', '2026-02-20 21:48:37');
INSERT INTO `countries` VALUES (25, 'Francia', 33, 'FR', 'FRA', 1, '2026-02-20 21:48:37', '2026-02-20 21:48:37');
INSERT INTO `countries` VALUES (26, 'Italia', 39, 'IT', 'ITA', 1, '2026-02-20 21:48:37', '2026-02-20 21:48:37');
INSERT INTO `countries` VALUES (27, 'Reino Unido', 44, 'GB', 'GBR', 1, '2026-02-20 21:48:37', '2026-02-20 21:48:37');
INSERT INTO `countries` VALUES (28, 'Portugal', 351, 'PT', 'PRT', 1, '2026-02-20 21:48:37', '2026-02-20 21:48:37');
INSERT INTO `countries` VALUES (29, 'Países Bajos', 31, 'NL', 'NLD', 1, '2026-02-20 21:48:37', '2026-02-20 21:48:37');
INSERT INTO `countries` VALUES (30, 'Suiza', 41, 'CH', 'CHE', 1, '2026-02-20 21:48:37', '2026-02-20 21:48:37');
INSERT INTO `countries` VALUES (31, 'Bélgica', 32, 'BE', 'BEL', 1, '2026-02-20 21:48:37', '2026-02-20 21:48:37');

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `failed_jobs_uuid_unique`(`uuid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for frequently_asked_questions
-- ----------------------------
DROP TABLE IF EXISTS `frequently_asked_questions`;
CREATE TABLE `frequently_asked_questions`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `question` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` blob NOT NULL,
  `orden` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL COMMENT 'Si no está activo no se muestra en el frontend',
  `language` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of frequently_asked_questions
-- ----------------------------
INSERT INTO `frequently_asked_questions` VALUES (1, '¿qué es exactamente la terminal analítica de la mano negra?', 0x457320756E20736F667477617265207072656469637469766F20706174656E7461646F2071756520657363616E656120666C756A6F73206465206361706974616C206D617369766F73207920766172696163696F6E657320656E206C61732063756F746173206465206F70657261646F72657320646520746F646F20656C206D756E646F20656E207469656D706F207265616C2E, 1, 1, 'es', '2026-07-07 01:14:42', '2026-07-07 01:14:42', NULL);
INSERT INTO `frequently_asked_questions` VALUES (2, '¿cómo se entregan las alertas analíticas?', 0x446570656E6469656E646F206465207475206E6976656C206465206C6963656E6369612C206C6173207365C3B1616C657320736520646573706C696567616E206465207472657320666F726D61732064697374696E7461733A20612074726176C3A9732064656C2064617368626F6172642077656220646564696361646F2028636F6E20576562536F636B6574732064652062616A61206C6174656E636961292C206D656469616E7465206E6F74696669636163696F6E6573205075736820656E207469656D706F207265616C2C206F20706F72206D6564696F20646520756E2063616E616C207072696F7269746172696F206175746F6D6174697A61646F20656E2054656C656772616D2070617261206C6963656E6369617320416C7068612050726F207920426C61636B205649502E, 2, 1, 'es', '2026-07-07 01:15:58', '2026-07-07 01:15:58', NULL);
INSERT INTO `frequently_asked_questions` VALUES (3, '¿cuánto tiempo tarda en activarse mi licencia tras el pago?', 0x4C612076616C6964616369C3B36E207365207265616C697A6120706F72207061736172656C6173206175746F6D6174697A616461732063696672616461732E205475206964656E746966696361646F72206465207265642073652073696E63726F6E697A6172C3A120646520666F726D61206175746F6DC3A17469636120656E20756E2072616E676F206DC3A178696D6F2064652031383020736567756E646F732074726173206C6120636F6E6669726D616369C3B36E206465206C6120636164656E61206465207061676F2E2052656369626972C3A1732074757320636C61766573206465206465736369667261646F207920656C2061636365736F20616C2041504920646972656374616D656E746520706F7220652D6D61696C2E, 3, 1, 'es', '2026-07-07 01:16:47', '2026-07-07 01:16:47', NULL);
INSERT INTO `frequently_asked_questions` VALUES (4, 'What exactly is the black hand\'s analytical terminal?', 0x49742069732070726F7072696574617279207072656469637469766520736F6674776172652074686174207363616E73206D617373697665206361706974616C20666C6F777320616E6420666C756374756174696F6E7320696E206F6464732066726F6D20626F6F6B6D616B65727320776F726C647769646520696E207265616C2074696D652E, 1, 1, 'en', '2026-08-16 19:43:29', '2026-08-16 19:48:33', NULL);
INSERT INTO `frequently_asked_questions` VALUES (5, 'How are analytical alerts delivered?', 0x56616C69646174696F6E2069732063617272696564206F757420766961206175746F6D617465642C20656E637279707465642067617465776179732E20596F7572206E6574776F726B206964656E7469666965722077696C6C206175746F6D61746963616C6C792073796E6368726F6E697A652077697468696E2061206D6178696D756D206F6620313830207365636F6E647320666F6C6C6F77696E6720636F6E6669726D6174696F6E206F6620746865207061796D656E74207472616E73616374696F6E2E20596F752077696C6C207265636569766520796F75722064656372797074696F6E206B65797320616E642041504920616363657373206469726563746C792076696120656D61696C2E, 2, 1, 'en', '2026-08-16 19:46:19', '2026-08-16 19:46:19', NULL);
INSERT INTO `frequently_asked_questions` VALUES (6, 'How long does it take for my license to activate after payment?', 0x56616C69646174696F6E2069732063617272696564206F757420766961206175746F6D617465642C20656E637279707465642067617465776179732E20596F7572206E6574776F726B206964656E7469666965722077696C6C206175746F6D61746963616C6C792073796E6368726F6E697A652077697468696E2061206D6178696D756D206F6620313830207365636F6E647320666F6C6C6F77696E6720636F6E6669726D6174696F6E206F6620746865207061796D656E74207472616E73616374696F6E2E20596F752077696C6C207265636569766520796F75722064656372797074696F6E206B65797320616E642041504920616363657373206469726563746C792076696120656D, 3, 1, 'en', '2026-08-16 19:47:39', '2026-08-16 19:47:39', NULL);

-- ----------------------------
-- Table structure for jobs
-- ----------------------------
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED NULL DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `jobs_queue_index`(`queue`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of jobs
-- ----------------------------

-- ----------------------------
-- Table structure for logs
-- ----------------------------
DROP TABLE IF EXISTS `logs`;
CREATE TABLE `logs`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `logs_user_id_foreign`(`user_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of logs
-- ----------------------------

-- ----------------------------
-- Table structure for menus
-- ----------------------------
DROP TABLE IF EXISTS `menus`;
CREATE TABLE `menus`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` int(10) NULL DEFAULT NULL,
  `name` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `icono` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `position` int(11) NULL DEFAULT NULL,
  `parent` int(11) NULL DEFAULT 0,
  `route` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `is_active` int(11) NULL DEFAULT 0,
  `language` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 67 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of menus
-- ----------------------------
INSERT INTO `menus` VALUES (1, 1, 'Operaciones', 'fas fa-calculator', 1, 0, NULL, 1, 'es', '2023-01-13 03:24:09', '2026-01-06 14:23:42', NULL);
INSERT INTO `menus` VALUES (2, 1, 'Reportes', 'fas fa-table', 4, 0, NULL, 1, 'es', '2023-01-13 03:27:18', '2023-01-13 03:27:18', NULL);
INSERT INTO `menus` VALUES (3, 1, 'Configuraciones', 'fas fa-cog', 5, 0, NULL, 1, 'es', '2023-01-13 03:27:38', '2023-01-13 03:27:38', NULL);
INSERT INTO `menus` VALUES (4, NULL, 'Roles', NULL, 0, 3, 'rol.index', 1, 'es', '2023-01-13 03:49:28', '2026-01-06 14:23:15', NULL);
INSERT INTO `menus` VALUES (5, NULL, 'Usuarios', NULL, 0, 3, 'user.index', 1, 'es', '2023-01-13 03:49:43', '2026-01-06 14:23:36', NULL);
INSERT INTO `menus` VALUES (6, 2, 'menús', NULL, 0, 3, 'menu.index', 1, 'es', '2023-01-14 15:09:35', '2023-01-14 15:09:35', NULL);
INSERT INTO `menus` VALUES (7, 2, 'sub menú', NULL, 0, 3, 'submenu.index', 1, 'es', '2023-01-18 18:13:53', '2023-01-18 18:13:53', NULL);
INSERT INTO `menus` VALUES (8, 1, 'Registros', 'fas fa-edit', 2, 0, NULL, 1, 'es', '2024-08-02 15:59:13', '2024-08-02 15:59:13', NULL);
INSERT INTO `menus` VALUES (18, 2, 'Parámetros', NULL, 0, 3, 'parameter.index', 1, 'es', '2026-01-06 14:37:24', '2026-01-06 14:37:24', NULL);
INSERT INTO `menus` VALUES (19, 1, 'contenido Web', 'fas fa-copy', 3, 0, NULL, 1, 'es', '2026-01-15 14:58:40', '2026-01-15 14:58:40', NULL);
INSERT INTO `menus` VALUES (20, 2, 'Preguntas Frecuentes', NULL, 0, 19, 'faq.index', 1, 'es', '2026-01-15 16:18:05', '2026-01-15 16:18:05', NULL);
INSERT INTO `menus` VALUES (21, 2, 'Páginas Estáticas', NULL, 0, 19, 'staticpage.index', 1, 'es', '2026-01-16 01:08:40', '2026-01-16 01:08:40', NULL);
INSERT INTO `menus` VALUES (26, 1, 'Mis Datos', 'fas fa-user', 6, 0, NULL, 1, 'es', '2026-02-03 18:46:10', '2026-02-03 18:46:10', NULL);
INSERT INTO `menus` VALUES (27, 2, 'Perfil de Usuario', NULL, 0, 26, 'profile', 1, 'es', '2026-02-03 18:46:33', '2026-02-03 18:46:33', NULL);
INSERT INTO `menus` VALUES (28, 1, 'Mis Operaciones', 'fas fa-calculator', 7, 0, NULL, 1, 'es', '2026-02-03 18:47:05', '2026-02-03 18:47:05', NULL);
INSERT INTO `menus` VALUES (31, 1, 'Mis Reportes', 'fas fa-table', 8, 0, NULL, 1, 'es', '2026-02-03 18:48:13', '2026-02-03 18:48:13', NULL);
INSERT INTO `menus` VALUES (32, 2, 'Actualizar Acceso', NULL, 0, 26, 'change.password', 1, 'es', '2026-02-04 04:26:33', '2026-02-04 04:26:33', NULL);
INSERT INTO `menus` VALUES (35, 2, 'Comentarios', NULL, 0, 19, 'staticpage.contacts', 1, 'es', '2026-02-05 03:56:57', '2026-02-05 03:56:57', NULL);
INSERT INTO `menus` VALUES (36, 2, 'Perfil Cliente', NULL, 0, 26, 'profile', 1, 'es', '2026-02-06 18:57:18', '2026-02-06 18:57:18', NULL);
INSERT INTO `menus` VALUES (39, 2, 'Clientes', NULL, 0, 2, 'get.report.user', 1, 'es', '2026-02-16 20:26:44', '2026-02-16 20:26:44', NULL);
INSERT INTO `menus` VALUES (48, 2, 'Suscripción', NULL, 0, 26, 'subscription', 1, 'es', '2026-02-24 16:28:27', '2026-02-24 16:28:27', NULL);
INSERT INTO `menus` VALUES (49, 2, 'Planes', NULL, 0, 8, 'plan.index', 1, 'es', '2026-02-26 02:25:13', '2026-02-26 02:25:13', NULL);
INSERT INTO `menus` VALUES (50, 2, 'Suscripciones', NULL, 0, 2, 'get.user.subscription', 1, 'es', '2026-03-01 20:25:03', '2026-03-01 20:25:03', NULL);
INSERT INTO `menus` VALUES (60, 2, 'Suscripciones', NULL, 0, 1, 'get.subscription', 1, 'es', '2026-05-17 19:17:16', '2026-05-17 19:17:16', NULL);
INSERT INTO `menus` VALUES (61, 2, 'Pick', NULL, 0, 1, 'pick.index', 1, 'es', '2026-08-02 10:38:27', '2026-08-02 10:38:27', NULL);
INSERT INTO `menus` VALUES (62, 2, 'Suscripción Web', NULL, 0, 1, 'get.web.subscription', 1, 'es', '2026-08-13 22:49:39', '2026-08-13 22:49:39', NULL);
INSERT INTO `menus` VALUES (63, 2, 'Client Profile', NULL, 0, 66, 'profile', 1, 'en', '2026-08-19 21:21:16', '2026-08-19 21:21:16', NULL);
INSERT INTO `menus` VALUES (64, 2, 'Subscription', NULL, 0, 66, 'subscription', 1, 'en', '2026-08-19 21:22:02', '2026-08-19 21:22:02', NULL);
INSERT INTO `menus` VALUES (65, 2, 'Update Access', NULL, 0, 66, 'change.password', 1, 'en', '2026-08-19 21:26:13', '2026-08-19 21:26:13', NULL);
INSERT INTO `menus` VALUES (66, 1, 'My Details', 'fas fa-user', 1, 0, NULL, 1, 'en', '2026-08-19 22:02:55', '2026-08-19 22:02:55', NULL);

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '2026_07_28_223855_create_payments_table', 1);
INSERT INTO `migrations` VALUES (3, '2026_08_02_080549_create_picks_table', 2);
INSERT INTO `migrations` VALUES (5, '2026_08_02_081509_create_send_mail_picks_table', 3);

-- ----------------------------
-- Table structure for parameters
-- ----------------------------
DROP TABLE IF EXISTS `parameters`;
CREATE TABLE `parameters`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Parametros Facturas',
  `company` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'Nombre d ela empresa',
  `identification` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'Rif',
  `phone` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'Telefono',
  `address` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'Dirección',
  `dollar_rate` decimal(10, 2) NOT NULL COMMENT 'Tasa del dolar',
  `vat_value` int(11) NULL DEFAULT NULL COMMENT 'Valor del IVA',
  `invoice_number` bigint(20) NULL DEFAULT NULL COMMENT 'Numero principal de la factura',
  `igtf` int(11) NULL DEFAULT NULL COMMENT 'IGTF porcentaje valor en dolares',
  `logo_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'Url del logo',
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `social_network_instagram` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `social_network_facebook` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `social_network_tiktok` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `bank_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `identity_mobile_payment` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `phone_mobile_payment` bigint(20) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `bank_id`(`bank_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of parameters
-- ----------------------------
INSERT INTO `parameters` VALUES (1, 'Atrévete', 'J29559409-1', '584121234567', 'Urb. Jose Feliz Ribas sector 5, Avenida 10, Número 37. Maracay Aragua', 417.36, 16, 7, 3, 'logo-1767704318.jpg', 'atrevete.ve2025@gmail.com', 'Atrevete_ve', 'Atrevete_ve', '@Atrevete_ve', 50, 'V-15739242', 584121234567, '2022-12-11 15:57:30', '2026-02-27 16:33:00');

-- ----------------------------
-- Table structure for payments
-- ----------------------------
DROP TABLE IF EXISTS `payments`;
CREATE TABLE `payments`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `payment_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `substatus` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `total` decimal(10, 2) NOT NULL,
  `currency` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `paid_at` timestamp(0) NULL DEFAULT NULL,
  `whop_user_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `plan_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `card_brand` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `card_last4` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `website_plan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `website_user_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `send_email` tinyint(1) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `payments_payment_id_unique`(`payment_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of payments
-- ----------------------------
INSERT INTO `payments` VALUES (1, 'pay_1Ma9jQYG5Anbpq', 'paid', 'succeeded', 30.00, 'usd', '2026-08-22 00:35:59', 'user_uNe3r67JDxqBb', 'ushor', 'plan_GBbr47qQ6yOAM', 'biz_PsXPVJLlAAZvUZ', 'visa', '4242', NULL, 3, NULL, '2026-08-21 20:35:59', '2026-08-21 20:36:03');
INSERT INTO `payments` VALUES (2, 'pay_NM4ghXT5p4N0Ns', 'paid', 'succeeded', 30.00, 'usd', '2026-08-22 00:46:29', 'user_uNe3r67JDxqBb', 'ushor', 'plan_GBbr47qQ6yOAM', 'biz_PsXPVJLlAAZvUZ', 'visa', '4242', NULL, 3, NULL, '2026-08-21 20:46:29', '2026-08-21 20:46:38');
INSERT INTO `payments` VALUES (3, 'pay_i11Yd1a63tQHOU', 'open', 'incomplete', 50.00, 'usd', '2026-08-22 14:06:16', 'user_qUqTLoNtKZoFa', 'jesus1e', 'plan_bqk6QxgvxxUZy', 'biz_PsXPVJLlAAZvUZ', NULL, NULL, NULL, 2, NULL, '2026-08-22 10:06:18', '2026-08-22 10:06:18');
INSERT INTO `payments` VALUES (4, 'pay_AfQCwLSyCcYsXC', 'open', 'incomplete', 30.00, 'usd', '2026-08-23 20:23:06', 'user_jMLjfCtneoG8u', 'jesuse5', 'plan_GBbr47qQ6yOAM', 'biz_PsXPVJLlAAZvUZ', NULL, NULL, NULL, 2, NULL, '2026-08-23 16:23:07', '2026-08-23 16:23:07');
INSERT INTO `payments` VALUES (6, 'pay_8xP5AkN46bjYTX', 'paid', 'succeeded', 33.74, 'usd', '2026-08-23 23:09:30', 'user_yhDp4RC2QCRrS', 'manonegrasportbets', 'plan_WEeYGzI0MCWXw', 'biz_w0VayXahdtaiqF', 'mastercard', '8355', 'elite', 3, NULL, '2026-08-23 19:09:35', '2026-08-23 19:09:35');
INSERT INTO `payments` VALUES (7, 'pay_ptzBuoNEiKoG4G', 'open', 'failed', 33.74, 'usd', '2026-08-24 23:46:42', 'user_yhDp4RC2QCRrS', 'manonegrasportbets', 'plan_WEeYGzI0MCWXw', 'biz_w0VayXahdtaiqF', NULL, NULL, 'elite', 4, NULL, '2026-08-24 19:46:51', '2026-08-24 19:46:51');
INSERT INTO `payments` VALUES (8, 'pay_u9TSrDWGHYXXAp', 'paid', 'succeeded', 33.74, 'usd', '2026-08-24 23:48:14', 'user_yhDp4RC2QCRrS', 'manonegrasportbets', 'plan_WEeYGzI0MCWXw', 'biz_w0VayXahdtaiqF', 'mastercard', '8355', 'elite', 4, NULL, '2026-08-24 19:48:18', '2026-08-24 19:48:18');

-- ----------------------------
-- Table structure for picks
-- ----------------------------
DROP TABLE IF EXISTS `picks`;
CREATE TABLE `picks`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `plan_id` bigint(20) UNSIGNED NOT NULL COMMENT 'ID plan',
  `body` longblob NULL COMMENT 'Contenido',
  `source` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'Origen',
  `right` tinyint(1) NULL DEFAULT NULL COMMENT 'Acertado',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `picks_plan_id_foreign`(`plan_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 35 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of picks
-- ----------------------------
INSERT INTO `picks` VALUES (32, 1, 0x3C703E3C623E506C616E3A20C3894C4954453C2F623E3C2F703E3C703E3C623E5245414C204D4144524944204F56455220322E3520474F4C4553266E6273703B3C2F623E3C2F703E3C703E3C623E43554F5441202D3132373C2F623E3C2F703E, 'SUSCRIPTION', 0, '2026-09-06 20:48:07', '2026-09-06 20:49:17', NULL);
INSERT INTO `picks` VALUES (33, 1, 0x3C703E3C623E506C616E3A20C3894C4954453C2F623E3C2F703E3C703E3C623E5245414C204D4144524944204F56455220322E3520474F4C4553266E6273703B3C2F623E3C2F703E3C703E3C623E43554F5441202D3132383C2F623E3C2F703E, 'SUSCRIPTION', 0, '2026-09-06 20:53:22', '2026-09-06 20:58:37', NULL);
INSERT INTO `picks` VALUES (34, 1, 0x3C703E3C623E506C616E3A20C3894C4954453C2F623E3C2F703E3C703E3C623E5245414C204D4144524944204F56455220322E3520474F4C4553266E6273703B3C2F623E3C2F703E3C703E3C623E43554F5441202D3132393C2F623E3C2F703E, 'SUSCRIPTION', 0, '2026-09-06 21:01:26', '2026-09-06 21:06:30', '2026-09-06 21:06:30');

-- ----------------------------
-- Table structure for plans
-- ----------------------------
DROP TABLE IF EXISTS `plans`;
CREATE TABLE `plans`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'nombre',
  `price` decimal(10, 2) NULL DEFAULT NULL COMMENT 'precio',
  `is_active` tinyint(1) NULL DEFAULT NULL COMMENT 'estatus',
  `description` longblob NULL COMMENT 'descripcion',
  `recommended` tinyint(1) NULL DEFAULT NULL COMMENT 'recomendacion',
  `type_plan_id` bigint(20) UNSIGNED NULL DEFAULT NULL COMMENT 'dia, mes, semana',
  `source` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `currency` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'Moneda',
  `duration_days` int(11) NULL DEFAULT NULL COMMENT 'duracion',
  `language` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `type_plan_id`(`type_plan_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of plans
-- ----------------------------
INSERT INTO `plans` VALUES (1, 'ÉLITE', 30.00, 0, 0x3C703E2D2032204A75676164617320C3A96C69746520646961726961732E3C2F703E3C703E3C7370616E207374796C653D22666F6E742D73697A653A20312E303172656D3B223E2D2032206A7567616461732056495020646961726961732E266E6273703B3C2F7370616E3E3C2F703E3C703E2D2053656775726F2064656C2061706F737461646F723C2F703E3C703E2D20536F706F727465207072696F7269746172696F2032342F373C2F703E, 0, 1, 'elite', 'usd', 0, 'es', '2026-02-26 02:50:51', '2026-09-06 20:47:20', NULL);
INSERT INTO `plans` VALUES (2, 'SUSCRIPCIÓN', 50.00, 1, 0x3C703E2D2032204A7567616461732065636F6EC3B36D6963617320646961726961732E3C2F703E3C703E2D2041637475616C697A6163696F6E657320636F6E7374616E7465732E3C2F703E3C703E2D20496E7665727369C3B36E20616363657369626C6520792072656E7461626C652E3C2F703E3C703E2D20536F706F72746520657374C3A16E6461723C2F703E, 1, 2, 'suscripcion', 'usd', 30, 'es', '2026-02-26 02:53:36', '2026-06-24 15:00:27', NULL);
INSERT INTO `plans` VALUES (4, 'VIP', 100.00, 1, 0x3C703E2D2032204A756167616461732056495020646961726961732E3C2F703E3C703E2D2032204A7567616461732065636F6EC3B36D6963617320646961726961732E3C2F703E3C703E2D2041637475616C697A6163696F6E657320636F6E7374616E74652E3C2F703E3C703E2D20536F706F727465207072696F7269746172696F2E3C2F703E, 0, 3, 'vip', 'usd', 7, 'es', '2026-02-26 02:55:50', '2026-06-24 15:01:50', NULL);

-- ----------------------------
-- Table structure for role_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE `role_has_permissions`  (
  `id_menu` int(10) UNSIGNED NOT NULL,
  `parent` int(11) NULL DEFAULT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `new` tinyint(4) NULL DEFAULT NULL,
  `edit` tinyint(4) NULL DEFAULT NULL,
  `delet` tinyint(4) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id_menu`, `role_id`) USING BTREE,
  INDEX `role_id`(`role_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of role_has_permissions
-- ----------------------------
INSERT INTO `role_has_permissions` VALUES (1, 0, 1, 1, 1, 1, '2026-08-23 18:09:47', '2026-08-23 18:09:47');
INSERT INTO `role_has_permissions` VALUES (1, 0, 2, 1, 1, 1, '2026-02-23 01:10:40', '2026-02-23 01:10:40');
INSERT INTO `role_has_permissions` VALUES (2, 0, 1, 1, 1, 1, '2026-08-23 18:09:47', '2026-08-23 18:09:47');
INSERT INTO `role_has_permissions` VALUES (2, 0, 2, 1, 1, 1, '2026-02-23 01:10:40', '2026-02-23 01:10:40');
INSERT INTO `role_has_permissions` VALUES (3, 0, 1, 1, 1, 1, '2026-08-23 18:09:47', '2026-08-23 18:09:47');
INSERT INTO `role_has_permissions` VALUES (4, 3, 1, 1, 1, 1, '2026-08-23 18:09:47', '2026-08-23 18:09:47');
INSERT INTO `role_has_permissions` VALUES (5, 3, 1, 1, 1, 1, '2026-08-23 18:09:47', '2026-08-23 18:09:47');
INSERT INTO `role_has_permissions` VALUES (6, 3, 1, 1, 1, 1, '2026-08-23 18:09:47', '2026-08-23 18:09:47');
INSERT INTO `role_has_permissions` VALUES (7, 3, 1, 1, 1, 1, '2026-08-23 18:09:47', '2026-08-23 18:09:47');
INSERT INTO `role_has_permissions` VALUES (8, 0, 1, 1, 1, 1, '2026-08-23 18:09:47', '2026-08-23 18:09:47');
INSERT INTO `role_has_permissions` VALUES (8, 0, 2, 1, 1, 1, '2026-02-23 01:10:40', '2026-02-23 01:10:40');
INSERT INTO `role_has_permissions` VALUES (18, 3, 1, 1, 1, 1, '2026-08-23 18:09:47', '2026-08-23 18:09:47');
INSERT INTO `role_has_permissions` VALUES (19, 0, 1, 1, 1, 1, '2026-08-23 18:09:47', '2026-08-23 18:09:47');
INSERT INTO `role_has_permissions` VALUES (19, 0, 2, 1, 1, 1, '2026-02-23 01:10:40', '2026-02-23 01:10:40');
INSERT INTO `role_has_permissions` VALUES (20, 19, 1, 1, 1, 1, '2026-08-23 18:09:47', '2026-08-23 18:09:47');
INSERT INTO `role_has_permissions` VALUES (20, 19, 2, 1, 1, 1, '2026-02-23 01:10:40', '2026-02-23 01:10:40');
INSERT INTO `role_has_permissions` VALUES (21, 19, 1, 1, 1, 1, '2026-08-23 18:09:47', '2026-08-23 18:09:47');
INSERT INTO `role_has_permissions` VALUES (21, 19, 2, 1, 1, 1, '2026-02-23 01:10:40', '2026-02-23 01:10:40');
INSERT INTO `role_has_permissions` VALUES (26, 0, 3, 1, 1, 1, '2026-08-19 22:09:40', '2026-08-19 22:09:40');
INSERT INTO `role_has_permissions` VALUES (28, 0, 3, 1, 1, 1, '2026-08-19 22:09:40', '2026-08-19 22:09:40');
INSERT INTO `role_has_permissions` VALUES (32, 26, 3, 1, 1, 1, '2026-08-19 22:09:40', '2026-08-19 22:09:40');
INSERT INTO `role_has_permissions` VALUES (35, 19, 1, 1, 1, 1, '2026-08-23 18:09:47', '2026-08-23 18:09:47');
INSERT INTO `role_has_permissions` VALUES (35, 19, 2, 1, 1, 1, '2026-02-23 01:10:40', '2026-02-23 01:10:40');
INSERT INTO `role_has_permissions` VALUES (36, 26, 3, 1, 1, 1, '2026-08-19 22:09:40', '2026-08-19 22:09:40');
INSERT INTO `role_has_permissions` VALUES (39, 2, 1, 1, 1, 1, '2026-08-23 18:09:47', '2026-08-23 18:09:47');
INSERT INTO `role_has_permissions` VALUES (39, 2, 2, 1, 1, 1, '2026-02-23 01:10:40', '2026-02-23 01:10:40');
INSERT INTO `role_has_permissions` VALUES (48, 26, 3, 1, 1, 1, '2026-08-19 22:09:40', '2026-08-19 22:09:40');
INSERT INTO `role_has_permissions` VALUES (49, 8, 1, 1, 1, 1, '2026-08-23 18:09:47', '2026-08-23 18:09:47');
INSERT INTO `role_has_permissions` VALUES (60, 1, 1, 1, 1, 1, '2026-08-23 18:09:47', '2026-08-23 18:09:47');
INSERT INTO `role_has_permissions` VALUES (61, 1, 1, 1, 1, 1, '2026-08-23 18:09:47', '2026-08-23 18:09:47');
INSERT INTO `role_has_permissions` VALUES (62, 1, 1, 1, 1, 1, '2026-08-23 18:09:47', '2026-08-23 18:09:47');
INSERT INTO `role_has_permissions` VALUES (63, 66, 3, 1, 1, 1, '2026-08-19 22:09:40', '2026-08-19 22:09:40');
INSERT INTO `role_has_permissions` VALUES (64, 66, 3, 1, 1, 1, '2026-08-19 22:09:40', '2026-08-19 22:09:40');
INSERT INTO `role_has_permissions` VALUES (65, 66, 3, 1, 1, 1, '2026-08-19 22:09:40', '2026-08-19 22:09:40');
INSERT INTO `role_has_permissions` VALUES (66, 0, 3, 1, 1, 1, '2026-08-19 22:09:40', '2026-08-19 22:09:40');

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'Nombre del rol',
  `is_active` tinyint(1) NULL DEFAULT NULL COMMENT '0=Inactive; 1=Active',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES (1, 'administrador', 1, '2022-12-01 14:28:30', '2026-02-12 00:20:21', NULL);
INSERT INTO `roles` VALUES (2, 'operador', 1, '2023-01-02 18:59:29', '2026-02-23 01:10:39', NULL);
INSERT INTO `roles` VALUES (3, 'cliente', 1, '2026-01-15 14:28:50', '2026-02-15 21:28:04', NULL);
INSERT INTO `roles` VALUES (4, 'prueba', 1, '2026-07-09 14:05:18', '2026-07-09 14:05:18', NULL);

-- ----------------------------
-- Table structure for send_mail_picks
-- ----------------------------
DROP TABLE IF EXISTS `send_mail_picks`;
CREATE TABLE `send_mail_picks`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pick_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `send_date` date NOT NULL,
  `sent_at` datetime(0) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `send_mail_picks_send_date_index`(`send_date`) USING BTREE,
  INDEX `send_mail_picks_sent_at_index`(`sent_at`) USING BTREE,
  INDEX `send_mail_picks_pick_id_foreign`(`pick_id`) USING BTREE,
  INDEX `send_mail_picks_user_id_foreign`(`user_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of send_mail_picks
-- ----------------------------

-- ----------------------------
-- Table structure for static_pages
-- ----------------------------
DROP TABLE IF EXISTS `static_pages`;
CREATE TABLE `static_pages`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `source` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `body` longblob NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `file_pdf` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `language` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 64 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of static_pages
-- ----------------------------
INSERT INTO `static_pages` VALUES (54, '¿quiénes somos?', 'quienes-somos', 0x4E6F20736F6D6F7320677572C3BA732C2074697073746572732C206E69206E6F7320626173616D6F7320656E206C612022696E7475696369C3B36E2064656C2076657374756172696F222E20536F6D6F7320756E20636F6C65637469766F20696E646570656E6469656E746520636F6D70756573746F20706F72206369656E74C3AD6669636F73206465206461746F732C20696E67656E6965726F7320646520736F6674776172652065782D6846542028486967682D4672657175656E63792054726164696E67292079206D6174656DC3A17469636F732061706C696361646F7320657370656369616C697A61646F7320656E20696E6566696369656E636961732064656C206D65726361646F206465706F727469766F20676C6F62616C2E0D0A3C62723E3C62723E0D0A4E756573747261206D65746F646F6C6F67C3AD612073652066756E64616D656E746120656E206169736C617220656C20727569646F206D656469C3A17469636F2079206C6173206D61736173206972726163696F6E616C657320612074726176C3A97320646520616C676F7269746D6F732070726F706965746172696F7320646520666174696761207920666C756A6F7320766F6C756DC3A9747269636F732E2044697365C3B1616D6F73206520696D706C656D656E74616D6F7320736F66747761726520717565206175646974612063756F74617320656E207469656D706F207265616C2C206F706572616E646F20636F6E206C61206D69736D612072696775726F7369646164206672C3AD6120792063616C63756C61646F72612071756520756E61206D65736120646520617262697472616A652064652057616C6C205374726565742E0D0A3C62723E0D0A3C62723E0D0A3C68723E0D0A3C62723E0D0A0D0A3C70207374796C653D22636F6C6F723A23613365363335223E2F2F204F424A455449564F3C2F703E0D0A4578747261657220656C206DC3A178696D6F2072656E64696D69656E746F206375616E746974617469766F206465206C617320696E6566696369656E63696173206D6174656DC3A17469636173206465206C6173206F70657261646F7261732E0D0A3C62723E3C62723E0D0A3C70207374796C653D22636F6C6F723A23613365363335223E2F2F2046494C4F534F46C38D413C2F703E0D0A5369206E6F206573206D656469626C652C207265676973747261626C65207920746573746561626C65206D656469616E7465206261636B74657374696E67206573746164C3AD737469636F2C206E6F206578697374652E, 1, 'WHO_WE_ARE', NULL, NULL, 'es', '2026-07-05 18:50:11', '2026-07-07 01:04:50', NULL);
INSERT INTO `static_pages` VALUES (58, 'Luis robert jr. completó tercer juego de rehabilitación', 'luis-robert-jr-completo-tercer-juego-de-rehabilitacion', 0x3C7020636C6173733D2277702D626C6F636B2D70617261677261706822207374796C653D226D617267696E3A20307078206175746F20323670783B206F766572666C6F772D777261703A20627265616B2D776F72643B206C696E652D6865696768743A20312E382021696D706F7274616E743B223E456C206A617264696E65726F2063656E7472616C206465206C6F73204D657473206465204E7565766120596F726B2C204C75697320526F62657274204A722E2C2066696E616C697AC3B320737520746572636572207061727469646F206465207265686162696C6974616369C3B36E20656E20656C2065717569706F20547269706C652D41206465205379726163757365207061726120696E74656E7461722072656772657361722061206C6173204772616E646573204C696761732E3C2F703E3C7020636C6173733D2277702D626C6F636B2D70617261677261706822207374796C653D226D617267696E3A20307078206175746F20323670783B206F766572666C6F772D777261703A20627265616B2D776F72643B206C696E652D6865696768743A20312E382021696D706F7274616E743B223E457374612061637475616369C3B36E206C612076696F20656E206C6120766963746F72696120706F7220362D352064652073752065717569706F20616E7465206C6F7320576F726365737465722052656420536F782C20646F6E64652073652066756520646520342D30207472617320706567617220646F7320656C657661646F73207920646F7320726F6C6574617A6F73207061726120656C206F75742E3C2F703E3C7020636C6173733D2277702D626C6F636B2D70617261677261706822207374796C653D226D617267696E3A20307078206175746F20323670783B206F766572666C6F772D777261703A20627265616B2D776F72643B206C696E652D6865696768743A20312E382021696D706F7274616E743B223E41207065736172206465206D6F737472617273652073616E6F2C20526F62657274206E6F20686120636F6E65637461646F2068697420656E2073757320C3BA6C74696D6F73206E75657665207475726E6F7320616C20626174652C207369656E646F20737520C3BA6E69636F2073656E63696C6C6F20656E20656C207072696D6572207475726E6F206465207375207265686162696C6974616369C3B36E2064656C207061727469646F2064656C206D61727465732E3C2F703E3C7020636C6173733D2277702D626C6F636B2D70617261677261706822207374796C653D226D617267696E3A20307078206175746F20323670783B206F766572666C6F772D777261703A20627265616B2D776F72643B206C696E652D6865696768743A20312E382021696D706F7274616E743B223E4C65652074616D6269C3A96E3A203C6120687265663D2268747470733A2F2F7777772E6C69646572656E6465706F727465732E636F6D2F77702D61646D696E2F706F73742E7068703F706F73743D3233323939393226616D703B616374696F6E3D6564697422207374796C653D22706F696E7465722D6576656E74733A206175746F3B223E56656E657A75656C612C20636F6E2063756174726F20726570726573656E74616E74657320656E20656C204A7565676F2064652045737472656C6C61733C2F613E3C2F703E3C7020636C6173733D2277702D626C6F636B2D70617261677261706822207374796C653D226D617267696E3A20307078206175746F20323670783B206F766572666C6F772D777261703A20627265616B2D776F72643B206C696E652D6865696768743A20312E382021696D706F7274616E743B223E5265636F7264656D6F732071756520656C206D616E6167657220696E746572696E6F206465206C6F73204D6574732C20416E647920477265656E2C20617365677572C3B32071756520526F626572742065737461626120C2AB65766F6C7563696F6E616E646F206269656EC2BB206465206C61206865726E69612064697363616C206C756D62617220717565206C6F20656E7669C3B32061206C61206C69737461206465206C6573696F6E61646F732E3C2F703E3C7020636C6173733D2277702D626C6F636B2D70617261677261706822207374796C653D226D617267696E3A20307078206175746F20323670783B206F766572666C6F772D777261703A20627265616B2D776F72643B206C696E652D6865696768743A20312E382021696D706F7274616E743B223EC2AB416D626F7320636869636F7320746F646176C3AD61207469656E656E206D7563686F73207061727469646F73206465206C69676173206D656E6F72657320706F722064656C616E7465C2BB2C2064696A6F20477265656E20726566697269C3A96E646F7365206120526F626572742079204A6F72676520506F6C616E636F2E3C2F703E3C7020636C6173733D2277702D626C6F636B2D70617261677261706822207374796C653D226D617267696E3A20307078206175746F20323670783B206F766572666C6F772D777261703A20627265616B2D776F72643B206C696E652D6865696768743A20312E382021696D706F7274616E743B223E526F62657274204A72206E6F2076652061636369C3B36E20656E206C6173204772616E646573204C6967617320646573646520656C2070617361646F20323620646520616272696C2C20646973707574616E646F206170656E6173203234207061727469646F7320656E206C6F73207175652064656AC3B320756E2070726F6D6564696F206465202E3232342070726F647563746F20646520646F73206A6F6E726F6E65732079206F63686F20636172726572617320696D70756C73616461732E3C2F703E, 1, 'BLOG', 'photo-58-1783267487.jpg', NULL, 'es', '2026-07-05 19:04:47', '2026-07-06 13:18:30', NULL);
INSERT INTO `static_pages` VALUES (59, 'Miguel cabrera inició su leyenda hace 23 años', 'miguel-cabrera-inicio-su-leyenda-hace-23-anos', 0x3C7020636C6173733D2277702D626C6F636B2D70617261677261706822207374796C653D226D617267696E3A20307078206175746F20323670783B206F766572666C6F772D777261703A20627265616B2D776F72643B206C696E652D6865696768743A20312E382021696D706F7274616E743B223E4D696775656C204361627265726120696E696369C3B320737520657869746F736120747261796563746F7269612064652032312074656D706F726164617320656E206C6173204772616E646573204C696761732C20686163652032332061C3B16F732C206375616E646F20656C20766965726E6573203230206465206A756E696F2064652032303033206465627574C3B320636F6E206C6F73204D61726C696E7320646520466C6F7269646120636F6D6F206F637461766F20626174652079206A617264696E65726F20697A7175696572646F20616E7465206C6F7320526179732064652054616D7061204261792E3C2F703E3C7020636C6173733D2277702D626C6F636B2D70617261677261706822207374796C653D226D617267696E3A20307078206175746F20323670783B206F766572666C6F772D777261703A20627265616B2D776F72643B206C696E652D6865696768743A20312E382021696D706F7274616E743B223E456C2061726167C3BC65C3B16F2C20717569656E20636F6E7461626120636F6E2032302061C3B16F7320792036332064C3AD61732C20736520706F6E6368C3B320656E207375207072696D6572207475726E6F20636F6E74726120526F622042656C6C20656E20656C2074657263657220657069736F64696F2E3C2F703E3C7020636C6173733D2277702D626C6F636B2D70617261677261706822207374796C653D226D617267696E3A20307078206175746F20323670783B206F766572666C6F772D777261703A20627265616B2D776F72643B206C696E652D6865696768743A20312E382021696D706F7274616E743B223E53696E20656D626172676F2C20656E20656C20756E64C3A963696D6F20696E6E696E672C20636F6E656374C3B3206A6F6E72C3B36E20706F7220656C206A617264C3AD6E2063656E7472616C2064656C2050726F20506C61796572205374616469756D206465204D69616D6920616E746520416C204C6576696E6520636F6E2073752070616973616E6F20C3816C657820476F6E7AC3A16C657A206120626F72646F20706172612064656A617220656E20656C2074657272656E6F20612054616D70612042617920332D312E3C2F703E3C7020636C6173733D2277702D626C6F636B2D70617261677261706822207374796C653D226D617267696E3A20307078206175746F20323670783B206F766572666C6F772D777261703A20627265616B2D776F72643B206C696E652D6865696768743A20312E382021696D706F7274616E743B223E4573746120667565207375207072696D657261206772616E2064656D6F737472616369C3B36E20792C20616C2066696E616C20646520737520636172726572612C20736520636F6E7669727469C3B320656E20756E6F206465206C6F73206A756761646F726573206DC3A1732070726F6475637469766F7320656E206C6120686973746F726961206465206C6173206D61796F7265732E3C2F703E3C7020636C6173733D2277702D626C6F636B2D70617261677261706822207374796C653D226D617267696E3A20307078206175746F20323670783B206F766572666C6F772D777261703A20627265616B2D776F72643B206C696E652D6865696768743A20312E382021696D706F7274616E743B223E506F72207265636F6D656E64616369C3B36E2064656C20636F61636820646520746572636572612C20656C206372696F6C6C6F204F7377616C646F204775696C6CC3A96E2C206C6F73204D61726C696E73207375626965726F6E206120436162726572612C20717565206669726DC3B320706F722024312E38206D696C6C6F6E657320656C2032206465206A756C696F20646520313939392E3C2F703E3C7020636C6173733D2277702D626C6F636B2D70617261677261706822207374796C653D226D617267696E3A20307078206175746F20323670783B206F766572666C6F772D777261703A20627265616B2D776F72643B206C696E652D6865696768743A20312E382021696D706F7274616E743B223E456E207375207072696D6572612063616D7061C3B1612C204D696767792062617465C3B3202E32363820286465203331342D38342920636F6E203132206375616472616E67756C617265732C20363220726179697461732072656D6F6C6361646173207920333920616E6F74616461732E3C2F703E3C7020636C6173733D2277702D626C6F636B2D70617261677261706822207374796C653D226D617267696E3A20307078206175746F20323670783B206F766572666C6F772D777261703A20627265616B2D776F72643B206C696E652D6865696768743A20312E382021696D706F7274616E743B223E3C62723E4C6F73204D61726C696E732067616E61726F6E206573652061C3B16F206C61205365726965204D756E6469616C2C20656E2073656973206A7565676F7320616E74652059616E717569732E20436162726572612061706F7274C3B32034206A6F6E726F6E657320656E2065736120706F7374656D706F726164612C20696E636C7569646F20756E6F20616E746520526F67657220436C656D656E7320656E206C6120534D2E3C2F703E3C7020636C6173733D2277702D626C6F636B2D70617261677261706822207374796C653D226D617267696E3A20307078206175746F20323670783B206F766572666C6F772D777261703A20627265616B2D776F72643B206C696E652D6865696768743A20312E382021696D706F7274616E743B223E456C20736C7567676572206D61726163617965726F206C7565676F20706173C3B32061206C6F732054696772657320646520446574726F697420656E20656C20323030382E20436F6E2065736520636C7562206F627475766F2063756174726F2074C3AD74756C6F732064652063616D7065C3B36E2062617465206465206C61204C69676120416D65726963616E612C20756E6120547269706C6520436F726F6E6120646520426174656F207920646F732074726F66656F73206465204A756761646F72204DC3A1732056616C696F736F2C20656E747265206F747261732064697374696E63696F6E65732E3C2F703E3C68322069643D22747269706C652D636F726F6E61646F2220636C6173733D2277702D626C6F636B2D68656164696E6722207374796C653D226D617267696E3A2033307078206175746F20323070783B206C696E652D6865696768743A20333870783B223E547269706C6520636F726F6E61646F3C2F68323E3C7020636C6173733D2277702D626C6F636B2D70617261677261706822207374796C653D226D617267696E3A20307078206175746F20323670783B206F766572666C6F772D777261703A20627265616B2D776F72643B206C696E652D6865696768743A20312E382021696D706F7274616E743B223E4375616E646F2043616272657261206C69646572C3B3206C6173206D61796F72657320636F6E20756E2070726F6D6564696F20646520626174656F206465202E3333302C203434206A6F6E726F6E65732079203133392072656D6F6C636164617320656E20323031322C20736520636F6E7669727469C3B320656E20656C207072696D65726F20656E2067616E6172206C6120547269706C6520436F726F6E6120646573646520717565204361726C2059617374727A656D736B69206C6F206C6F6772C3B320656E203139363720636F6E206C6F73204D656469617320526F6A617320646520426F73746F6E2E3C2F703E3C7020636C6173733D2277702D626C6F636B2D70617261677261706822207374796C653D226D617267696E3A20307078206175746F20323670783B206F766572666C6F772D777261703A20627265616B2D776F72643B206C696E652D6865696768743A20312E382021696D706F7274616E743B223E4D6967677920657320656C20C3BA6C74696D6F2064652032362070656C6F7465726F73207175652068612067616E61646F206C6120547269706C6520436F726F6E6120656E204D4C4220646573646520313837382E3C2F703E3C7020636C6173733D2277702D626C6F636B2D70617261677261706822207374796C653D226D617267696E3A20307078206175746F20323670783B206F766572666C6F772D777261703A20627265616B2D776F72643B206C696E652D6865696768743A20312E382021696D706F7274616E743B223E4C6565722074616D6269C3A96E3A203C6120687265663D2268747470733A2F2F7777772E6C69646572656E6465706F727465732E636F6D2F6E6F7469636961732F76656E657A6F6C616E6F732D6D6C622F6D61726C696E732D6D616E7469656E656E2D73752D6772616E2D6D6F6D656E746F2D64652D6A756E696F2D616C2D6261727265722D612D6C6F732D676967616E7465732F22207374796C653D22706F696E7465722D6576656E74733A206175746F3B223E4D61726C696E73206D616E7469656E656E207375206772616E206D6F6D656E746F206465206A756E696F20616C206261727265722061206C6F7320476967616E7465733C2F613E3C2F703E3C68322069643D22636C75622D64652D6C6579656E6461732220636C6173733D2277702D626C6F636B2D68656164696E6722207374796C653D226D617267696E3A2033307078206175746F20323070783B206C696E652D6865696768743A20333870783B223E436C7562206465206C6579656E6461733C2F68323E3C7020636C6173733D2277702D626C6F636B2D70617261677261706822207374796C653D226D617267696E3A20307078206175746F20323670783B206F766572666C6F772D777261703A20627265616B2D776F72643B206C696E652D6865696768743A20312E382021696D706F7274616E743B223E4D696775656C20436162726572612C20656C20696E6D6F7274616C2048616E6B204161726F6E207920656C20646F6D696E6963616E6F20416C626572742050756A6F6C7320736F6E206C6F73207472657320C3BA6E69636F732070656C6F7465726F73206465204D4C4220636F6E20616C206D656E6F7320332E30303020696D70617261626C65732C20353030206A6F6E726F6E657320792036303020646F626C65732E3C2F703E3C7020636C6173733D2277702D626C6F636B2D70617261677261706822207374796C653D226D617267696E3A20307078206175746F20323670783B206F766572666C6F772D777261703A20627265616B2D776F72643B206C696E652D6865696768743A20312E382021696D706F7274616E743B223E456C206372696F6C6C6F2066756520756E20416C6C2D5374617220656E206361646120756E61206465207375732063756174726F2074656D706F726164617320636F6D706C6574617320656E20466C6F726964612C206672616E717569636961207175652C20617365646961646120706F72207375732066696E616E7A61732C20646563696469C3B3207472617370617361726C6F2061206C6F732054696772657320656E20323030372E3C2F703E3C7020636C6173733D2277702D626C6F636B2D70617261677261706822207374796C653D226D617267696E3A20307078206175746F20323670783B206F766572666C6F772D777261703A20627265616B2D776F72643B206C696E652D6865696768743A20312E382021696D706F7274616E743B223E4675652067616C6172646F6E61646F20636F6D6F20656C204A756761646F72204DC3A1732056616C696F736F206465206C61204C69676120416D65726963616E6120656E2032303132207920323031332E20436162726572612067616EC3B32063696E636F2064652073757320736965746520426174657320646520506C61746120656E20446574726F69742E2046756520656C207072696D657220746F6C657465726F20656E20616D626173206C6967617320656E20656E6C617A617220747265732074C3AD74756C6F7320646520626174656F20646573646520526F6765727320486F726E736279206120636F6D69656E7A6F73206465206C612064C3A96361646120646520313932302E3C2F703E3C68322069643D226C7563652D6772616E64652D706172612D656E747261722D616C2D73616CC3B36E2D64652D6C612D66616D612220636C6173733D2277702D626C6F636B2D68656164696E6722207374796C653D226D617267696E3A2033307078206175746F20323070783B206C696E652D6865696768743A20333870783B223E4C756365206772616E6465207061726120656E7472617220616C2053616CC3B36E206465206C612046616D613C2F68323E3C7020636C6173733D2277702D626C6F636B2D70617261677261706822207374796C653D226D617267696E3A20307078206175746F20323670783B206F766572666C6F772D777261703A20627265616B2D776F72643B206C696E652D6865696768743A20312E382021696D706F7274616E743B223E4D696775656C2043616272657261206972C3A12061207375207072696D65722061C3B16F20646520656C65676962696C6964616420656E20656C20323032392C20656E20627573636120646520636F6E766572746972736520656E20656C20736567756E646F2076656E657A6F6C616E6F20656E20656C2053616CC3B36E206465206C612046616D61206A756E746F20616C206578746F7270656465726F207A756C69616E6F204C75697320417061726963696F2E20456C2061726167C3BC65C3B16F2066696E616C697AC3B3207375206361727265726120636F6E20332E31373420696D70617261626C6573207920353131206375616472616E67756C617265732C20636F6E7669727469C3A96E646F736520656E20656C2073C3A97074696D6F206A756761646F72206465204D4C4220656E206163756D756C617220332E3030302068697473207920353030206A6F6E726F6E65732E20456E7472652065736F732073696574652C206E61646965207475766F20756E2070726F6D6564696F20646520626174656F20646520706F722076696461206DC3A17320616C746F20717565204361627265726120282E333036292E20456E2032312074656D706F7261646173207920322E373937206A7565676F7320646520726F6E646120726567756C61722C204D6967677920636F6E656374C3B32074616D6269C3A96E203632372074756265796573207920313720747269706C65732E2054616D6269C3A96E20656D70756AC3B320312E3838312063617272657261732C207920616E6F74C3B320312E3535312E20456C206D61726163617965726F20656E636162657A612061206C6F732076656E657A6F6C616E6F7320656E206C61206C697374612068697374C3B37269636120656E206361736920746F646F73206C6F732072656E676C6F6E6573206F66656E7369766F732E204361627265726120646973707574C3B320737520C3BA6C74696D6F206A7565676F20656C2031C2B0206465206F637475627265206465203230323320636F6E74726120436C6576656C616E6420656E20756E612064657370656469646120656E20446574726F69742E3C2F703E, 1, 'BLOG', 'photo-59-1783268261.png', NULL, 'es', '2026-07-05 19:17:41', '2026-07-06 13:23:27', NULL);
INSERT INTO `static_pages` VALUES (60, 'Portugal - españa: un duelo de viejas conocidas con cuentas pendientes', 'portugal-espana-un-duelo-de-viejas-conocidas-con-cuentas-pendientes', 0x3C6836207374796C653D2270616464696E673A203070783B206D617267696E3A203070782030707820312E35656D3B206C696E652D6865696768743A20312E353B2220636C6173733D22223E3C2F68363E3C6836207374796C653D222220636C6173733D22223E456C20506F72747567616C2D45737061C3B16120796120657374C3A120617175C3AD2E20456C206475656C6F206962C3A97269636F2C20756E207061727469646F20657370657261646F20656E2065737465204D756E6469616C2C206861206C6C656761646F20656E206F637461766F732064652066696E616C2C207175697AC3A17320616E746573206465206C6F20657370657261646F207061726120756E20656E6375656E74726F2071756520706F6472C3AD612064617273652070657266656374616D656E746520656E206C612066696E616C2E20556E61206465206C6173206772616E646573206661766F726974617320616C2074C3AD74756C6F20736520717565646172C3A120656E206C612063756E65746120616E746573206465206C6F20707265766973746F20656E20756E2063686F71756520636F6E20616972657320646520726576616E6368612074726173206C6120766963746F72696120706F727475677565736120656E206C612066696E616C206465206C61204E6174696F6E73204C65616775652064656C2061C3B16F2070617361646F2E3C2F68363E3C6836207374796C653D222220636C6173733D22223E3C62723E456C2064652065737465206C756E657320656E2044616C6C61732065732064652065736F73207061727469646F732070617261206C6F732071756520657320646966C3AD63696C20686163657220756E2070726F6EC3B3737469636F206F20656C6567697220756E206661766F7269746F2E20416D626F7320636F6E6A756E746F73206C6C6567616E20747261732068616265722074656E69646F20616C746962616A6F7320656E207375206A7565676F20792073696E206C61206272696C6C616E74657A2071756520706F6472C3AD612065737065726172736520616E7465732064656C20696E6963696F2064656C2063616D70656F6E61746F2E20456C207175652067616E652C2065736F2073C3AD2C2072656369626972C3A120756E6120696E7965636369C3B36E206D6F72616C2071756520706F6472C3AD612073657220636C617665207061726120656C207472616D6F2066696E616C206465206C6120436F70612064656C204D756E646F2E3C2F68363E3C6836207374796C653D222220636C6173733D22223E3C62723E45737061C3B1612C206465206D656E6F732061206DC3A173207920636F6E2073656E73616369C3B36E206465206D656A6F7261204C612073656C65636369C3B36E2065737061C3B16F6C61206C6C6567612061206C612063697461206465206F637461766F7320636F6E206C61206D6F72616C20706F72206C6173206E756265732074726173206C6120676F6C6561646120616E746520417573747269612028332D30292E204C6120526F6A61207265616C697AC3B320756E207061727469646F207265646F6E646F2C20656C206D656A6F7220656E206C6F2071756520766120646520746F726E656F2C2079206469736970C3B3206C61732064756461732067656E65726164617320656E206661736520646520677275706F732E204C612073656E73616369C3B36E2067656E6572616C206573207175652045737061C3B161207365206163657263C3B32C20706F722066696E2C2061206C61207665727369C3B36E20717565206C65206C6C6576C3B320612070726F636C616D617273652063616D70656F6E61206465204575726F706120656E20323032342E3C2F68363E3C6836207374796C653D222220636C6173733D22223E3C62723E556E61692053696DC3B36E207265636F6E6F6369C3B320656E207275656461206465207072656E73612071756520736520657374C3A16E206170726F78696D616E646F206120657365206E6976656C2C2061756E71756520616C63616E7A61726C6F20657320756E61206D65746120636F6D706C69636164613A202245736520746F726E656F206675652062617374616E746520636F6D706C65746F2C206C6C657661646F2061206C61207065726665636369C3B36E2E2054656E657220657365206F626A657469766F207369656D707265206573206275656E6F2E20506172612067616E6172206120506F72747567616C2074656E656D6F73207175652074656E657220657365206E6976656C222E20204D696B656C204D6572696E6F2C20706F722073752070617274652C20617365677572C3B320717565206C61732073656E736163696F6E65732064656E74726F2064656C2076657374756172696F20227369656D7072652068616E207369646F206275656E6173222C207065736520612071756520656C20696E6963696F2064656C2063616D70656F6E61746F2066756520636F6D706C696361646F2E3C2F68363E, 1, 'BLOG', 'photo-60-1783332042.png', NULL, 'es', '2026-07-06 13:00:42', '2026-07-06 13:23:48', NULL);
INSERT INTO `static_pages` VALUES (61, 'Términos y condiciones', 'terminos-y-condiciones', 0x3C70207374796C653D22636F6C6F723A23613365363335223E3C623E312E204143455054414349C3934E204445204C4F532054C389524D494E4F533C2F623E3C2F703E3C62723E0D0A3C703E416C20616363656465722C206E6176656761722C2072656769737472617273652C20616471756972697220756E6120737573637269706369C3B36E206F207574696C697A6172206375616C717569657220736572766963696F206F6672656369646F20706F72204D616E6F4E6567726153706F7274426574732C20656C207573756172696F206465636C617261206861626572206C65C3AD646F2C20636F6D7072656E6469646F207920616365707461646F206573746F732054C3A9726D696E6F73207920436F6E646963696F6E657320656E20737520746F74616C696461642E3C2F703E0D0A3C62723E0D0A3C703E536920656C207573756172696F206E6F20657374C3A1206465206163756572646F20636F6E206375616C717569657261206465206C617320646973706F736963696F6E657320617175C3AD2065737461626C6563696461732C206465626572C3A12061627374656E65727365206465207574696C697A6172206E75657374726F7320736572766963696F732E3C2F703E0D0A3C62723E0D0A3C68723E0D0A3C62723E3C62723E0D0A0D0A3C70207374796C653D22636F6C6F723A23613365363335223E3C623E322E204E41545552414C455A412044454C20534552564943494F3C2F623E3C2F703E3C62723E0D0A3C703E4D616E6F4E6567726153706F727442657473206F667265636520636F6E74656E69646F206469676974616C2072656C6163696F6E61646F20636F6E206170756573746173206465706F7274697661732C20696E636C7579656E646F2C207065726F2073696E206C696D69746172736520613A3C2F703E3C62723E0D0A3C703E2D2050726F6EC3B3737469636F73206465706F727469766F732E3C2F703E0D0A3C703E2D20416EC3A16C69736973206573746164C3AD737469636F732E3C2F703E0D0A3C703E2D204F70696E696F6E6573206465206D65726361646F2E3C2F703E0D0A3C703E2D2054656E64656E63696173206465706F7274697661732E3C2F703E0D0A3C703E2D20496E666F726D616369C3B36E2065647563617469766120736F627265206765737469C3B36E2064652062616E63612E3C2F703E0D0A3C703E2D20496E666F726D616369C3B36E20736F6272652063756F7461732079206D6F76696D69656E746F73206465206CC3AD6E6561732E3C2F703E0D0A3C62723E0D0A3C703E546F6461206C6120696E666F726D616369C3B36E2070726F706F7263696F6E61646120636F6E7374697475796520C3BA6E6963616D656E746520756E61206F70696E69C3B36E20696E666F726D61746976612079206564756361746976612E3C2F703E3C62723E0D0A3C703E42616A6F206E696E67756E612063697263756E7374616E636961204D616E6F4E6567726153706F72744265747320616374C3BA6120636F6D6F20617365736F722066696E616E636965726F2C20617365736F7220646520696E76657273696F6E6573206F676172616E746520646520726573756C7461646F73206465706F727469766F732E3C2F703E0D0A0D0A3C62723E0D0A3C68723E0D0A3C62723E3C62723E0D0A0D0A3C70207374796C653D22636F6C6F723A23613365363335223E3C623E332E2052455155495349544F20444520454441443C2F623E3C2F703E3C62723E0D0A3C703E4C6F7320736572766963696F73206465204D616E6F4E6567726153706F72744265747320657374C3A16E20646972696769646F73206578636C75736976616D656E7465206120706572736F6E6173206D61796F7265732064652031382061C3B16F73206F2061206C6165646164206DC3AD6E696D61206C6567616C206578696769646120656E206C61206A757269736469636369C3B36E2064656C207573756172696F2070617261207061727469636970617220656E2061637469766964616465732072656C6163696F6E6164617320636F6E6170756573746173206465706F7274697661732E3C2F703E3C62723E0D0A3C703E456C207573756172696F206465636C617261207920676172616E74697A612063756D706C697220657374652072657175697369746F20616C207574696C697A6172206E75657374726F7320736572766963696F732E3C2F703E0D0A0D0A3C62723E0D0A3C68723E0D0A3C62723E3C62723E0D0A0D0A3C70207374796C653D22636F6C6F723A23613365363335223E3C623E342E20415553454E43494120444520474152414E54C38D41533C2F623E3C2F703E3C62723E0D0A3C703E4C6173206170756573746173206465706F72746976617320696D706C6963616E20756E20616C746F206E6976656C2064652072696573676F2066696E616E636965726F2E3C2F703E0D0A3C703E456C207573756172696F207265636F6E6F6365207920616365707461207175653A3C2F703E0D0A3C703E2D204E696E67756E61206170756573746120707565646520676172616E74697A61722067616E616E636961732E3C2F703E0D0A3C703E2D204C6F7320726573756C7461646F732070617361646F73206E6F20676172616E74697A616E20726573756C7461646F732066757475726F732E3C2F703E0D0A3C703E2D204E6F206578697374652073697374656D6120696E66616C69626C652064652061707565737461732E3C2F703E0D0A3C703E2D20546F6461206170756573746120707565646520726573756C746172207065726465646F72612E3C2F703E0D0A3C62723E0D0A3C703E4D616E6F4E6567726153706F727442657473206E6F20676172616E74697A613A3C2F703E0D0A3C703E2D2047616E616E636961732065636F6EC3B36D696361732E3C2F703E0D0A3C703E2D2052656E746162696C696461642E3C2F703E0D0A3C703E2D2052656375706572616369C3B36E2064652070C3A97264696461732E3C2F703E0D0A3C703E2D20506F7263656E74616A6573206465206163696572746F206573706563C3AD6669636F732E3C2F703E0D0A3C703E2D2042656E65666963696F732066757475726F732E3C2F703E0D0A0D0A3C62723E0D0A3C68723E0D0A3C62723E3C62723E0D0A0D0A3C70207374796C653D22636F6C6F723A23613365363335223E3C623E352E20524553504F4E534142494C494441442044454C205553554152494F3C2F623E3C2F703E3C62723E0D0A3C703E43616461207573756172696F20657320656C20C3BA6E69636F20726573706F6E7361626C652064653A3C2F703E0D0A3C703E2D20537573206465636973696F6E657320646520617075657374612E3C2F703E0D0A3C703E4C61206765737469C3B36E2064652073752062616E6B726F6C6C2E3C2F703E0D0A3C703E2D20456C2075736F20616465637561646F206465206C6120696E666F726D616369C3B36E2072656369626964612E3C2F703E0D0A3C703E2D20566572696669636172206C61206C6567616C69646164206465206C6173206170756573746173206465706F72746976617320656E207375207061C3AD732C2065737461646F206F206A757269736469636369C3B36E2E3C2F703E0D0A3C62723E0D0A3C703E456C207573756172696F206163657074612061706F7374617220C3BA6E6963616D656E74652064696E65726F20717565207075656461207065726D697469727365207065726465722E3C2F703E0D0A0D0A3C62723E0D0A3C68723E0D0A3C62723E3C62723E0D0A0D0A3C70207374796C653D22636F6C6F723A23613365363335223E3C623E362E20504C414E45532059205355534352495043494F4E45533C2F623E3C2F703E3C62723E0D0A3C703E4D616E6F4E6567726153706F72744265747320706F6472C3A1206F6672656365722064697374696E746F7320706C616E65732064652061636365736F2C20696E636C7579656E646F3A3C2F703E3C62723E0D0A3C703E3C623E506C616E20537573637269706369C3B36E3C2F623E3C2F703E0D0A3C703E2D2041636365736F2061206A7567616461732065636F6EC3B36D696361732E3C2F703E0D0A3C703E2D20566967656E636961206D656E7375616C2E3C2F703E0D0A3C62723E0D0A3C703E3C623E506C616E205649503C2F623E3C2F703E0D0A3C703E2D2041636365736F2061206A7567616461732056495020792065636F6EC3B36D696361732E3C2F703E0D0A3C703E2D20566967656E6369612073656D616E616C2E3C2F703E0D0A3C62723E0D0A3C703E3C623E506C616E20C3896C6974653C2F623E3C2F703E0D0A3C703E2D2041636365736F2061206A75676164617320C3896C6974652C2056495020792065636F6EC3B36D696361732E3C2F703E0D0A3C703E2D20496E636C7579652053656775726F2064652041706F737461646F722E3C2F703E0D0A3C703E2D20566967656E636961206469617269612E3C2F703E0D0A3C62723E0D0A3C703E4C6173206361726163746572C3AD7374696361732C2070726563696F7320792062656E65666963696F7320706F6472C3A16E206D6F64696669636172736520656E206375616C7175696572206D6F6D656E746F2073696E2070726576696F20617669736F2E3C2F703E0D0A0D0A3C62723E0D0A3C68723E0D0A3C62723E3C62723E0D0A0D0A3C70207374796C653D22636F6C6F723A23613365363335223E3C623E372E20504F4CC38D54494341204445205041474F532059205245454D424F4C534F533C2F623E3C2F703E3C62723E0D0A3C703E546F646F73206C6F732070726F647563746F73207920736572766963696F7320636F6D65726369616C697A61646F7320706F72204D616E6F4E6567726153706F72744265747320736F6E20636F6E736964657261646F732070726F647563746F736469676974616C65732E3C2F703E3C62723E0D0A3C703E44656269646F2061206C61206E61747572616C657A6120696E6D6564696174612064656C2061636365736F20616C20636F6E74656E69646F3A3C2F703E0D0A3C703E2D204E6F207365207265616C697A616E206465766F6C7563696F6E65732064652064696E65726F2E3C2F703E0D0A3C703E2D204E6F207365207265616C697A616E207265656D626F6C736F73207061726369616C65732E3C2F703E0D0A3C703E2D204E6F207365207265616C697A616E206372C3A96469746F73206D6F6E65746172696F732E3C2F703E0D0A3C703E2D204E6F207365207265616C697A616E20636F6D70656E736163696F6E65732065636F6EC3B36D696361732E3C2F703E3C62723E0D0A3C703E556E612076657A2070726F63657361646F20656C207061676F207920636F6E63656469646F20656C2061636365736F20616C20736572766963696F2C206C612076656E746120736520636F6E73696465726120646566696E69746976612E3C2F703E0D0A0D0A3C62723E0D0A3C68723E0D0A3C62723E3C62723E0D0A0D0A3C70207374796C653D22636F6C6F723A23613365363335223E3C623E382E2053454755524F2044452041504F535441444F523C2F623E3C2F703E3C62723E0D0A3C703E456C2053656775726F2064652041706F737461646F7220657320756E2062656E65666963696F206578636C757369766F2070617261207573756172696F732061637469766F732064656C20506C616E20C3896C6974652E3C2F703E3C62723E0D0A3C703E5369206C6173206A75676164617320636F72726573706F6E6469656E74657320616C2064C3AD612064656C20736572766963696F207465726D696E616E20636F6E20726573756C7461646F206E6567617469766F2C204D616E6F4E6567726153706F727442657473706F6472C3A1206F746F7267617220756E202831292064C3AD612061646963696F6E616C2064652061636365736F20677261747569746F20616C20506C616E20C3896C6974652E3C2F703E3C62723E0D0A3C703E456C2053656775726F2064652041706F737461646F723A3C2F703E0D0A3C703E2D204E6F20636F6E7374697475796520756E6120676172616E74C3AD612064652067616E616E636961732E3C2F703E0D0A3C703E2D204E6F20726570726573656E746120756E2073656775726F2066696E616E636965726F2E3C2F703E0D0A3C703E2D204E6F20696D706C696361206465766F6C756369C3B36E2064652064696E65726F2E3C2F703E0D0A3C703E2D204E6F20696D706C69636120636F6D70656E736163696F6E6573206D6F6E657461726961732E3C2F703E0D0A3C703E2D204E6F2063756272652070C3A9726469646173207265616C697A6164617320706F7220656C207573756172696F2E3C2F703E3C62723E0D0A3C703E4D616E6F4E6567726153706F727442657473207365207265736572766120656C206465726563686F206465206D6F646966696361722C2073757370656E646572206F20656C696D696E617220657374652062656E65666963696F20656E206375616C71756965726D6F6D656E746F2E3C2F703E0D0A0D0A3C62723E0D0A3C68723E0D0A3C62723E3C62723E0D0A0D0A0D0A3C70207374796C653D22636F6C6F723A23613365363335223E3C623E392E20444953504F4E4942494C49444144204445204CC38D4E4541532C2043554F5441532059204D45524341444F533C2F623E3C2F703E3C62723E0D0A3C703E4C6173206CC3AD6E6561732C2063756F7461732079206D65726361646F73207075626C696361646F732070756564656E2076617269617220736567C3BA6E3A3C2F703E3C62723E0D0A3C703E2D204C612063617361206465206170756573746173207574696C697A6164612E3C2F703E0D0A3C703E2D20456C207061C3AD73206F206A757269736469636369C3B36E2064656C207573756172696F2E3C2F703E0D0A3C703E2D20456C206D6F6D656E746F20656E20717565207365207265616C697A61206C6120617075657374612E3C2F703E0D0A3C703E2D2043616D62696F73206465206D65726361646F207265616C697A61646F7320706F72207465726365726F732E3C2F703E0D0A3C62723E0D0A3C703E4D616E6F4E6567726153706F727442657473206E6F20676172616E74697A6120717565206C61732073656C656363696F6E6573207075626C69636164617320657374C3A96E20646973706F6E69626C657320656E20746F646173206C617320636173617320646561707565737461732E3C2F703E3C62723E0D0A3C703E456C207573756172696F20657320726573706F6E7361626C6520646520766572696669636172206C6120646973706F6E6962696C69646164206465206361646120617075657374612E3C2F703E3C703E4E6F207365206F746F72676172C3A16E3A3C2F703E3C62723E0D0A3C703E2D205265656D626F6C736F732E3C2F703E0D0A3C703E2D204372C3A96469746F732E3C2F703E0D0A3C703E2D2044C3AD61732061646963696F6E616C65732E3C2F703E0D0A3C703E2D20436F6D70656E736163696F6E65732E3C2F703E0D0A3C62723E0D0A3C703E44656269646F2061206C612066616C746120646520646973706F6E6962696C6964616420646520756E61206CC3AD6E65612C2063756F7461206F206D65726361646F20656E206C6120706C617461666F726D61207574696C697A61646120706F7220656C207573756172696F2E3C2F703E0D0A0D0A3C62723E0D0A3C68723E0D0A3C62723E3C62723E0D0A0D0A0D0A3C70207374796C653D22636F6C6F723A23613365363335223E3C623E31302E2050524F50494544414420494E54454C45435455414C3C2F623E3C2F703E3C62723E0D0A3C703E546F646F20656C20636F6E74656E69646F207075626C696361646F20706F72204D616E6F4E6567726153706F7274426574732065732070726F706965646164206578636C7573697661206465206C6120656D70726573612E3C2F703E3C62723E0D0A3C703E496E636C7579652C20656E747265206F74726F733A3C2F703E0D0A3C703E2D2050726F6EC3B3737469636F732E3C2F703E0D0A3C703E2D204573746164C3AD7374696361732E3C2F703E0D0A3C703E2D2044697365C3B16F732E3C2F703E0D0A3C703E2D20496DC3A167656E65732E3C2F703E0D0A3C703E2D20566964656F732E3C2F703E0D0A3C703E2D205075626C69636163696F6E65732E3C2F703E0D0A3C703E2D204C6F676F7469706F732E3C2F703E0D0A3C703E2D204D6174657269616C2070726F6D6F63696F6E616C2E3C2F703E0D0A3C62723E0D0A3C703E51756564612065737472696374616D656E74652070726F68696269646F20636F706961722C20726570726F64756369722C20646973747269627569722C2076656E6465722C20636F6D706172746972206F206578706C6F74617220636F6D65726369616C6D656E7465646963686F20636F6E74656E69646F2073696E206175746F72697A616369C3B36E20657363726974612E3C2F703E0D0A0D0A3C62723E0D0A3C68723E0D0A3C62723E3C62723E0D0A0D0A3C70207374796C653D22636F6C6F723A23613365363335223E3C623E31312E2050524F484942494349C3934E20444520524556454E5441205920434F4D50415254494349C3934E3C2F623E3C2F703E3C62723E0D0A3C703E456C2061636365736F2061647175697269646F20657320706572736F6E616C206520696E7472616E7366657269626C652E3C2F703E3C62723E0D0A3C703E457374C3A12070726F68696269646F3A3C2F703E0D0A3C703E2D20436F6D70617274697220636170747572617320646520636F6E74656E69646F207072697661646F2E3C2F703E0D0A3C703E2D20526576656E64657220696E666F726D616369C3B36E2E3C2F703E3C703E446973747269627569722070726F6EC3B3737469636F732061207465726365726F732E3C2F703E0D0A3C703E2D205075626C6963617220636F6E74656E69646F206578636C757369766F20656E20677275706F732065787465726E6F732E3C2F703E0D0A3C62723E0D0A3C703E4C612076696F6C616369C3B36E206465206573746120636CC3A17573756C6120706F6472C3A120726573756C74617220656E206C612063616E63656C616369C3B36E20696E6D6564696174612064656C2061636365736F2073696E206465726563686F20617265656D626F6C736F2E3C2F703E0D0A0D0A3C62723E0D0A3C68723E0D0A3C62723E3C62723E0D0A0D0A0D0A3C70207374796C653D22636F6C6F723A23613365363335223E3C623E31322E204C494D4954414349C3934E20444520524553504F4E534142494C494441443C2F623E3C2F703E3C62723E0D0A3C703E4D616E6F4E6567726153706F727442657473206E6F20736572C3A120726573706F6E7361626C6520706F723A3C2F703E3C62723E0D0A3C703E2D2050C3A97264696461732065636F6EC3B36D696361732E3C2F703E0D0A3C703E2D204461C3B16F73206469726563746F73206F20696E6469726563746F732E3C2F703E0D0A3C703E2D204465636973696F6E657320746F6D6164617320706F7220656C207573756172696F2E3C2F703E0D0A3C703E2D204572726F726573206465207465726365726F732E3C2F703E0D0A3C703E2D204361C3AD64617320646520706C617461666F726D61732E3C2F703E0D0A3C703E2D2046616C6C6F7320646520696E7465726E65742E3C2F703E0D0A3C703E2D204572726F7265732064652063617361732064652061707565737461732E3C2F703E0D0A3C703E2D2043616D62696F732064652063756F746173206F206D65726361646F732E3C2F703E0D0A3C62723E0D0A3C703E456C207573756172696F20616365707461207574696C697A617220656C20736572766963696F2062616A6F2073752070726F70696F2072696573676F2E3C2F703E0D0A0D0A3C62723E0D0A3C68723E0D0A3C62723E3C62723E0D0A0D0A0D0A3C70207374796C653D22636F6C6F723A23613365363335223E3C623E31332E2043414E43454C414349C3934E2044454C20534552564943494F3C2F623E3C2F703E3C62723E0D0A3C703E4D616E6F4E6567726153706F72744265747320706F6472C3A12073757370656E646572206F2063616E63656C617220656C2061636365736F206465206375616C7175696572207573756172696F207175653A3C2F703E3C62723E0D0A3C703E2D20496E63756D706C61206573746F732074C3A9726D696E6F732E3C2F703E0D0A3C703E2D205265616C696365206672617564652E3C2F703E0D0A3C703E2D20526576656E646120636F6E74656E69646F2E3C2F703E0D0A3C703E2D20496E74656E7465207065726A756469636172206C6120636F6D756E696461642E3C2F703E0D0A3C62723E0D0A3C703E4C612063616E63656C616369C3B36E206E6F2067656E65726172C3A1206465726563686F2061207265656D626F6C736F2E3C2F703E0D0A0D0A3C62723E0D0A3C68723E0D0A3C62723E3C62723E0D0A0D0A0D0A0D0A3C70207374796C653D22636F6C6F723A23613365363335223E3C623E31342E204D4F44494649434143494F4E45533C2F623E3C2F703E3C62723E0D0A3C703E4D616E6F4E6567726153706F72744265747320706F6472C3A1206D6F64696669636172206573746F732054C3A9726D696E6F73207920436F6E646963696F6E657320656E206375616C7175696572206D6F6D656E746F2E3C2F703E3C62723E0D0A3C703E4C61207665727369C3B36E207075626C696361646120656E206C612070C3A167696E612077656220736572C3A120636F6E7369646572616461206C61207665727369C3B36E20766967656E746520792061706C696361626C652E3C2F703E0D0A0D0A3C62723E0D0A3C68723E0D0A3C62723E3C62723E0D0A0D0A0D0A3C70207374796C653D22636F6C6F723A23613365363335223E3C623E31352E204C454749534C414349C3934E2041504C494341424C453C2F623E3C2F703E3C62723E0D0A3C703E4573746F732054C3A9726D696E6F73207920436F6E646963696F6E6573207365207265676972C3A16E20706F72206C6173206C657965732061706C696361626C6573206465206C61206A757269736469636369C3B36E20646F6E6465206F706572654D616E6F4E6567726153706F7274426574732E3C2F703E3C62723E0D0A3C703E4375616C7175696572206469737075746120736572C3A12072657375656C746120636F6E666F726D65206120646963686173206C657965732E3C2F703E0D0A0D0A3C62723E0D0A3C68723E0D0A3C62723E3C62723E0D0A0D0A3C70207374796C653D22636F6C6F723A23613365363335223E3C623E31362E20434F4E544143544F204F46494349414C3C2F623E3C2F703E3C62723E0D0A3C703E496E7374616772616D3A20406D616E6F6E6567726173706F7274626574733C2F703E0D0A3C703E57686174734170703A2043616E616C206F66696369616C207075626C696361646F20656E206E75657374726173207265646573207920706C617461666F726D6173206175746F72697A616461732E3C2F703E0D0A3C703E436F7272656F20656C65637472C3B36E69636F3A20456C207075626C696361646F206F66696369616C6D656E746520706F72204D616E6F4E6567726153706F7274426574732E3C2F703E0D0A0D0A3C62723E0D0A3C68723E0D0A3C62723E3C62723E0D0A0D0A3C70207374796C653D22636F6C6F723A23613365363335223E3C623E415649534F204C4547414C3C2F623E3C2F703E3C62723E0D0A3C703E4C6173206170756573746173206465706F72746976617320696D706C6963616E2072696573676F2066696E616E636965726F20792070756564656E2067656E657261722070C3A97264696461732E204D616E6F4E6567726153706F72744265747370726F706F7263696F6E6120696E666F726D616369C3B36E20636F6E2066696E65732065647563617469766F73207920646520656E74726574656E696D69656E746F2E204E6F20676172616E74697A616D6F732067616E616E636961732C72656E746162696C69646164206E6920726573756C7461646F73206573706563C3AD6669636F732E20456C207573756172696F20657320656C20C3BA6E69636F20726573706F6E7361626C6520646520737573206465636973696F6E6573206465206170756573746120792064656C75736F206465206C6120696E666F726D616369C3B36E2070726F706F7263696F6E6164612E3C2F703E, 1, 'TERMS', NULL, NULL, 'es', '2026-07-06 13:55:36', '2026-07-06 14:26:15', NULL);
INSERT INTO `static_pages` VALUES (62, 'About us', 'about-us', 0x3C703E576520617265206E656974686572206775727573206E6F722074697073746572732C206E6F7220646F2077652072656C79206F6E20226C6F636B65722D726F6F6D20696E74756974696F6E2E222057652061726520616E20696E646570656E64656E7420636F6C6C65637469766520636F6D70726973696E67206461746120736369656E74697374732C20666F726D657220686967682D6672657175656E63792074726164696E6720284846542920736F66747761726520656E67696E656572732C20616E64206170706C696564206D617468656D6174696369616E73207370656369616C697A696E6720696E20676C6F62616C2073706F727473206D61726B657420696E656666696369656E636965732E3C2F703E0D0A0D0A3C703E4F7572206D6574686F646F6C6F67792069732067726F756E64656420696E2066696C746572696E67206F7574206D65646961206E6F69736520616E64206972726174696F6E616C2063726F7764206265686176696F72207573696E672070726F707269657461727920616C676F726974686D73207468617420747261636B206661746967756520616E6420766F6C756D6520666C6F77732E2057652064657369676E20616E6420696D706C656D656E7420736F667477617265207468617420617564697473206F64647320696E207265616C2074696D652C206F7065726174696E672077697468207468652073616D6520636F6C642C2063616C63756C6174696E6720707265636973696F6E20617320612057616C6C2053747265657420617262697472616765206465736B2E3C2F703E0D0A0D0A3C703E3C62723E3C2F703E0D0A0D0A3C70207374796C653D22636F6C6F723A23613365363335223E2F2F204F424A4543544956453C2F703E0D0A3C703E546F2065787472616374206D6178696D756D207175616E74697461746976652072657475726E732066726F6D206D617468656D61746963616C20696E656666696369656E6369657320666F756E6420696E2062657474696E67206F70657261746F72732E3C2F703E0D0A0D0A3C703E3C62723E3C2F703E0D0A3C70207374796C653D22636F6C6F723A23613365363335223E2F2F205048494C4F534F5048593C2F703E0D0A3C703E49662069742063616E6E6F74206265206D656173757265642C207265636F726465642C20616E64207665726966696564207468726F75676820737461746973746963616C206261636B74657374696E672C20697420646F6573206E6F742065786973742E3C2F703E, 1, 'WHO_WE_ARE', NULL, NULL, 'en', '2026-08-16 19:09:52', '2026-08-16 19:09:52', NULL);
INSERT INTO `static_pages` VALUES (63, 'Terms and conditions', 'terms-and-conditions', 0x3C70207374796C653D22636F6C6F723A23613365363335223E3C623E312E20414343455054414E4345204F46205445524D533C2F623E3C2F703E3C62723E0D0A3C703E427920616363657373696E672C2062726F7773696E672C207265676973746572696E672C2070757263686173696E67206120737562736372697074696F6E2C206F72207573696E6720616E792073657276696365206F666665726564206279204D616E6F4E6567726153706F7274426574732C207468652075736572206465636C6172657320746861742074686579206861766520726561642C20756E64657273746F6F642C20616E64206163636570746564207468657365205465726D7320616E6420436F6E646974696F6E7320696E20746865697220656E7469726574792E3C2F703E0D0A3C62723E0D0A3C703E496620746865207573657220646F6573206E6F74206167726565207769746820616E79206F66207468652070726F766973696F6E732065737461626C69736865642068657265696E2C2074686579206D757374207265667261696E2066726F6D207573696E67206F75722073657276696365732E3C2F703E0D0A3C62723E0D0A3C68723E0D0A3C62723E3C62723E0D0A0D0A3C70207374796C653D22636F6C6F723A23613365363335223E3C623E322E204E4154555245204F462054484520534552564943453C2F623E3C2F703E3C62723E0D0A3C703E4D616E6F4E6567726153706F727442657473206F6666657273206469676974616C20636F6E74656E742072656C6174656420746F2073706F7274732062657474696E672C20696E636C7564696E672C20627574206E6F74206C696D6974656420746F3A3C2F703E3C62723E0D0A3C703E2D2053706F7274732070726564696374696F6E732E3C2F703E0D0A3C703E2D20537461746973746963616C20616E616C797369732E3C2F703E0D0A3C703E2D204D61726B657420696E7369676874732E3C2F703E0D0A3C703E2D2053706F727473207472656E64732E3C2F703E0D0A3C703E2D20456475636174696F6E616C20696E666F726D6174696F6E206F6E2062616E6B726F6C6C206D616E6167656D656E742E3C2F703E0D0A3C703E2D20496E666F726D6174696F6E206F6E206F64647320616E64206C696E65206D6F76656D656E74732E3C2F703E0D0A3C62723E0D0A3C703E416C6C20696E666F726D6174696F6E2070726F766964656420636F6E737469747574657320736F6C656C7920696E666F726D6174696F6E616C20616E6420656475636174696F6E616C206F70696E696F6E2E3C2F703E3C62723E0D0A3C703E556E646572206E6F2063697263756D7374616E63657320646F6573204D616E6F4E6567726153706F7274426574732061637420617320612066696E616E6369616C2061647669736F722C20696E766573746D656E742061647669736F722C206F722067756172616E746F72206F662073706F72747320726573756C74732E3C2F703E0D0A0D0A3C62723E0D0A3C68723E0D0A3C62723E3C62723E0D0A0D0A3C70207374796C653D22636F6C6F723A23613365363335223E3C623E332E2041474520524551554952454D454E543C2F623E3C2F703E3C62723E0D0A3C703E4D616E6F4E6567726153706F72744265747320736572766963657320617265206469726563746564206578636C75736976656C7920746F20696E646976696475616C73206F766572203138207965617273206F6620616765206F7220746865206D696E696D756D206C6567616C2061676520726571756972656420696E2074686520757365722773206A7572697364696374696F6E20746F20706172746963697061746520696E20616374697669746965732072656C6174656420746F2073706F7274732062657474696E672E3C2F703E3C62723E0D0A3C703E5468652075736572206465636C6172657320616E642067756172616E7465657320636F6D706C69616E63652077697468207468697320726571756972656D656E74207768656E207573696E67206F75722073657276696365732E3C2F703E0D0A0D0A3C62723E0D0A3C68723E0D0A3C62723E3C62723E0D0A0D0A3C70207374796C653D22636F6C6F723A23613365363335223E3C623E342E20414253454E4345204F462057415252414E544945533C2F623E3C2F703E3C62723E0D0A3C703E53706F7274732062657474696E6720696E766F6C76657320612068696768206C6576656C206F662066696E616E6369616C207269736B2E3C2F703E0D0A3C703E54686520757365722061636B6E6F776C656467657320616E64206163636570747320746861743A3C2F703E0D0A3C703E2D204E6F206265742063616E2067756172616E7465652070726F666974732E3C2F703E0D0A3C703E2D205061737420726573756C747320646F206E6F742067756172616E7465652066757475726520726573756C74732E3C2F703E0D0A3C703E2D204E6F20696E66616C6C69626C652062657474696E672073797374656D206578697374732E3C2F703E0D0A3C703E2D204576657279206265742063616E20726573756C7420696E2061206C6F73732E3C2F703E0D0A3C62723E0D0A3C703E4D616E6F4E6567726153706F72744265747320646F6573206E6F742067756172616E7465653A3C2F703E0D0A3C703E2D2046696E616E6369616C206561726E696E67732E3C2F703E0D0A3C703E2D2050726F6669746162696C6974792E3C2F703E0D0A3C703E2D205265636F76657279206F66206C6F737365732E3C2F703E0D0A3C703E2D2053706563696669632077696E2070657263656E74616765732E3C2F703E0D0A3C703E2D204675747572652062656E65666974732E3C2F703E0D0A0D0A3C62723E0D0A3C68723E0D0A3C62723E3C62723E0D0A0D0A3C70207374796C653D22636F6C6F723A23613365363335223E3C623E352E205553455220524553504F4E534942494C4954593C2F623E3C2F703E3C62723E0D0A3C703E45616368207573657220697320736F6C656C7920726573706F6E7369626C6520666F723A3C2F703E0D0A3C703E2D2054686569722062657474696E67206465636973696F6E732E3C2F703E0D0A3C703E2D20546865206D616E6167656D656E74206F662074686569722062616E6B726F6C6C2E3C2F703E0D0A3C703E2D205468652070726F70657220757365206F662074686520696E666F726D6174696F6E2072656365697665642E3C2F703E0D0A3C703E2D20566572696679696E6720746865206C6567616C697479206F662073706F7274732062657474696E6720696E20746865697220636F756E7472792C2073746174652C206F72206A7572697364696374696F6E2E3C2F703E0D0A3C62723E0D0A3C703E54686520757365722061677265657320746F20626574206F6E6C79206D6F6E657920746865792063616E206166666F726420746F206C6F73652E3C2F703E0D0A0D0A3C62723E0D0A3C68723E0D0A3C62723E3C62723E0D0A0D0A3C70207374796C653D22636F6C6F723A23613365363335223E3C623E362E20504C414E5320414E4420535542534352495054494F4E533C2F623E3C2F703E3C62723E0D0A3C703E4D616E6F4E6567726153706F727442657473206D6179206F6666657220646966666572656E742061636365737320706C616E732C20696E636C7564696E673A3C2F703E3C62723E0D0A3C703E3C623E537562736372697074696F6E20506C616E3C2F623E3C2F703E0D0A3C703E2D2041636365737320746F2065636F6E6F6D6963616C20706C6179732E3C2F703E0D0A3C703E2D204D6F6E74686C792076616C69646974792E3C2F703E0D0A3C62723E0D0A3C703E3C623E56495020506C616E3C2F623E3C2F703E0D0A3C703E2D2041636365737320746F2056495020616E642065636F6E6F6D6963616C20706C6179732E3C2F703E0D0A3C703E2D205765656B6C792076616C69646974792E3C2F703E0D0A3C62723E0D0A3C703E3C623E456C69746520506C616E3C2F623E3C2F703E0D0A3C703E2D2041636365737320746F20456C6974652C205649502C20616E642065636F6E6F6D6963616C20706C6179732E3C2F703E0D0A3C703E2D20496E636C7564657320426574746F72277320496E737572616E63652E3C2F703E0D0A3C703E2D204461696C792076616C69646974792E3C2F703E0D0A3C62723E0D0A3C703E46656174757265732C207072696365732C20616E642062656E6566697473206D6179206265206D6F64696669656420617420616E792074696D6520776974686F7574207072696F72206E6F746963652E3C2F703E0D0A0D0A3C62723E0D0A3C68723E0D0A3C62723E3C62723E0D0A0D0A3C70207374796C653D22636F6C6F723A23613365363335223E3C623E372E205041594D454E5420414E4420524546554E4420504F4C4943593C2F623E3C2F703E3C62723E0D0A3C703E416C6C2070726F647563747320616E6420736572766963657320636F6D6D65726369616C697A6564206279204D616E6F4E6567726153706F7274426574732061726520636F6E73696465726564206469676974616C2070726F64756374732E3C2F703E3C62723E0D0A3C703E44756520746F2074686520696D6D656469617465206E6174757265206F6620636F6E74656E74206163636573733A3C2F703E0D0A3C703E2D204E6F206D6F6E657461727920726566756E647320617265206973737565642E3C2F703E0D0A3C703E2D204E6F207061727469616C20726566756E647320617265206973737565642E3C2F703E0D0A3C703E2D204E6F206D6F6E6574617279206372656469747320617265206973737565642E3C2F703E0D0A3C703E2D204E6F2066696E616E6369616C20636F6D70656E736174696F6E7320617265206973737565642E3C2F703E3C62723E0D0A3C703E4F6E636520746865207061796D656E742069732070726F63657373656420616E642061636365737320746F207468652073657276696365206973206772616E7465642C207468652073616C6520697320636F6E736964657265642066696E616C2E3C2F703E0D0A0D0A3C62723E0D0A3C68723E0D0A3C62723E3C62723E0D0A0D0A3C70207374796C653D22636F6C6F723A23613365363335223E3C623E382E20424554544F52275320494E535552414E43453C2F623E3C2F703E3C62723E0D0A3C703E426574746F72277320496E737572616E636520697320616E206578636C75736976652062656E6566697420666F722061637469766520456C69746520506C616E2075736572732E3C2F703E3C62723E0D0A3C703E49662074686520706C61797320636F72726573706F6E64696E6720746F2074686520646179206F66207365727669636520656E6420776974682061206E6567617469766520726573756C742C204D616E6F4E6567726153706F727442657473206D6179206772616E74206F6E6520283129206164646974696F6E616C20646179206F6620667265652061636365737320746F2074686520456C69746520506C616E2E3C2F703E3C62723E0D0A3C703E426574746F72277320496E737572616E63653A3C2F703E0D0A3C703E2D20446F6573206E6F7420636F6E7374697475746520612070726F6669742067756172616E7465652E3C2F703E0D0A3C703E2D20446F6573206E6F7420726570726573656E742066696E616E6369616C20696E737572616E63652E3C2F703E0D0A3C703E2D20446F6573206E6F7420696D706C792061206D6F6E657461727920726566756E642E3C2F703E0D0A3C703E2D20446F6573206E6F7420696D706C79206D6F6E657461727920636F6D70656E736174696F6E2E3C2F703E0D0A3C703E2D20446F6573206E6F7420636F766572206C6F7373657320696E6375727265642062792074686520757365722E3C2F703E3C62723E0D0A3C703E4D616E6F4E6567726153706F7274426574732072657365727665732074686520726967687420746F206D6F646966792C2073757370656E642C206F7220656C696D696E61746520746869732062656E6566697420617420616E792074696D652E3C2F703E0D0A0D0A3C62723E0D0A3C68723E0D0A3C62723E3C62723E0D0A0D0A0D0A3C70207374796C653D22636F6C6F723A23613365363335223E3C623E392E20415641494C4142494C495459204F46204C494E45532C204F4444532C20414E44204D41524B4554533C2F623E3C2F703E3C62723E0D0A3C703E546865207075626C6973686564206C696E65732C206F6464732C20616E64206D61726B657473206D6179207661727920646570656E64696E67206F6E3A3C2F703E3C62723E0D0A3C703E2D205468652073706F727473626F6F6B20757365642E3C2F703E0D0A3C703E2D205468652075736572277320636F756E747279206F72206A7572697364696374696F6E2E3C2F703E0D0A3C703E2D20546865206578616374206D6F6D656E74207468652062657420697320706C616365642E3C2F703E0D0A3C703E2D204D61726B6574206368616E676573206D61646520627920746869726420706172746965732E3C2F703E0D0A3C62723E0D0A3C703E4D616E6F4E6567726153706F72744265747320646F6573206E6F742067756172616E7465652074686174207075626C69736865642073656C656374696F6E732077696C6C20626520617661696C61626C6520617420616C6C2073706F727473626F6F6B732E3C2F703E3C62723E0D0A3C703E546865207573657220697320726573706F6E7369626C6520666F7220766572696679696E672074686520617661696C6162696C697479206F662065616368206265742E3C2F703E3C703E54686520666F6C6C6F77696E672077696C6C206E6F74206265206772616E7465643A3C2F703E3C62723E0D0A3C703E2D20526566756E64732E3C2F703E0D0A3C703E2D20437265646974732E3C2F703E0D0A3C703E2D204164646974696F6E616C20646179732E3C2F703E0D0A3C703E2D20436F6D70656E736174696F6E732E3C2F703E0D0A3C62723E0D0A3C703E44756520746F20746865206C61636B206F6620617661696C6162696C697479206F662061206C696E652C206F64642C206F72206D61726B6574206F6E2074686520706C6174666F726D20757365642062792074686520757365722E3C2F703E0D0A0D0A3C62723E0D0A3C68723E0D0A3C62723E3C62723E0D0A0D0A0D0A3C70207374796C653D22636F6C6F723A23613365363335223E3C623E31302E20494E54454C4C45435455414C2050524F50455254593C2F623E3C2F703E3C62723E0D0A3C703E416C6C20636F6E74656E74207075626C6973686564206279204D616E6F4E6567726153706F72744265747320697320746865206578636C75736976652070726F7065727479206F662074686520636F6D70616E792E3C2F703E3C62723E0D0A3C703E496E636C756465732C20616D6F6E67206F74686572733A3C2F703E0D0A3C703E2D2050726564696374696F6E732E3C2F703E0D0A3C703E2D20537461746973746963732E3C2F703E0D0A3C703E2D2044657369676E732E3C2F703E0D0A3C703E2D20496D616765732E3C2F703E0D0A3C703E2D20566964656F732E3C2F703E0D0A3C703E2D205075626C69636174696F6E732E3C2F703E0D0A3C703E2D204C6F676F732E3C2F703E0D0A3C703E2D2050726F6D6F74696F6E616C206D6174657269616C2E3C2F703E0D0A3C62723E0D0A3C703E4974206973207374726963746C792070726F6869626974656420746F20636F70792C20726570726F647563652C20646973747269627574652C2073656C6C2C2073686172652C206F7220636F6D6D65726369616C6C79206578706C6F6974207361696420636F6E74656E7420776974686F7574207772697474656E20617574686F72697A6174696F6E2E3C2F703E0D0A0D0A3C62723E0D0A3C68723E0D0A3C62723E3C62723E0D0A0D0A3C70207374796C653D22636F6C6F723A23613365363335223E3C623E31312E2050524F4849424954494F4E204F4620524553414C4520414E442053484152494E473C2F623E3C2F703E3C62723E0D0A3C703E41637175697265642061636365737320697320706572736F6E616C20616E64206E6F6E2D7472616E7366657261626C652E3C2F703E3C62723E0D0A3C703E49742069732070726F6869626974656420746F3A3C2F703E0D0A3C703E2D2053686172652073637265656E73686F7473206F66207072697661746520636F6E74656E742E3C2F703E0D0A3C703E2D20526573656C6C20696E666F726D6174696F6E2E3C2F703E3C703E446973747269627574652070726564696374696F6E7320746F20746869726420706172746965732E3C2F703E0D0A3C703E2D205075626C697368206578636C757369766520636F6E74656E7420696E2065787465726E616C2067726F7570732E3C2F703E0D0A3C62723E0D0A3C703E56696F6C6174696F6E206F66207468697320636C61757365206D617920726573756C7420696E20696D6D6564696174652063616E63656C6C6174696F6E206F662061636365737320776974686F75742074686520726967687420746F206120726566756E642E3C2F703E0D0A0D0A3C62723E0D0A3C68723E0D0A3C62723E3C62723E0D0A0D0A0D0A3C70207374796C653D22636F6C6F723A23613365363335223E3C623E31322E204C494D49544154494F4E204F46204C494142494C4954593C2F623E3C2F703E3C62723E0D0A3C703E4D616E6F4E6567726153706F727442657473207368616C6C206E6F74206265206C6961626C6520666F723A3C2F703E3C62723E0D0A3C703E2D2046696E616E6369616C206C6F737365732E3C2F703E0D0A3C703E2D20446972656374206F7220696E6469726563742064616D616765732E3C2F703E0D0A3C703E2D204465636973696F6E73206D6164652062792074686520757365722E3C2F703E0D0A3C703E2D2054686972642D7061727479206572726F72732E3C2F703E0D0A3C703E2D20506C6174666F726D206F7574616765732E3C2F703E0D0A3C703E2D20496E7465726E6574206661696C757265732E3C2F703E0D0A3C703E2D2053706F727473626F6F6B206572726F72732E3C2F703E0D0A3C703E2D204F646473206F72206D61726B6574206368616E6765732E3C2F703E0D0A3C62723E0D0A3C703E54686520757365722061677265657320746F20757365207468652073657276696365206174207468656972206F776E207269736B2E3C2F703E0D0A0D0A3C62723E0D0A3C68723E0D0A3C62723E3C62723E0D0A0D0A0D0A3C70207374796C653D22636F6C6F723A23613365363335223E3C623E31332E20534552564943452043414E43454C4C4154494F4E3C2F623E3C2F703E3C62723E0D0A3C703E4D616E6F4E6567726153706F727442657473206D61792073757370656E64206F722063616E63656C2074686520616363657373206F6620616E7920757365722077686F3A3C2F703E3C62723E0D0A3C703E2D204272656163686573207468657365207465726D732E3C2F703E0D0A3C703E2D20436F6D6D6974732066726175642E3C2F703E0D0A3C703E2D20526573656C6C7320636F6E74656E742E3C2F703E0D0A3C703E2D20417474656D70747320746F206861726D2074686520636F6D6D756E6974792E3C2F703E0D0A3C62723E0D0A3C703E43616E63656C6C6174696F6E2077696C6C206E6F742067656E6572617465206120726967687420746F206120726566756E642E3C2F703E0D0A0D0A3C62723E0D0A3C68723E0D0A3C62723E3C62723E0D0A0D0A0D0A0D0A3C70207374796C653D22636F6C6F723A23613365363335223E3C623E31342E204D4F44494649434154494F4E533C2F623E3C2F703E3C62723E0D0A3C703E4D616E6F4E6567726153706F727442657473206D6179206D6F64696679207468657365205465726D7320616E6420436F6E646974696F6E7320617420616E792074696D652E3C2F703E3C62723E0D0A3C703E5468652076657273696F6E207075626C6973686564206F6E2074686520776562736974652077696C6C20626520636F6E73696465726564207468652063757272656E7420616E64206170706C696361626C652076657273696F6E2E3C2F703E0D0A0D0A3C62723E0D0A3C68723E0D0A3C62723E3C62723E0D0A0D0A0D0A3C70207374796C653D22636F6C6F723A23613365363335223E3C623E31352E204150504C494341424C45204C41573C2F623E3C2F703E3C62723E0D0A3C703E5468657365205465726D7320616E6420436F6E646974696F6E73207368616C6C20626520676F7665726E656420627920746865206170706C696361626C65206C617773206F6620746865206A7572697364696374696F6E207768657265204D616E6F4E6567726153706F727442657473206F706572617465732E3C2F703E3C62723E0D0A3C703E416E792064697370757465207368616C6C206265207265736F6C76656420696E206163636F7264616E636520776974682073616964206C6177732E3C2F703E0D0A0D0A3C62723E0D0A3C68723E0D0A3C62723E3C62723E0D0A0D0A3C70207374796C653D22636F6C6F723A23613365363335223E3C623E31362E204F4646494349414C20434F4E544143543C2F623E3C2F703E3C62723E0D0A3C703E496E7374616772616D3A20406D616E6F6E6567726173706F7274626574733C2F703E0D0A3C703E57686174734170703A204F6666696369616C206368616E6E656C207075626C6973686564206F6E206F757220736F6369616C206D6564696120616E6420617574686F72697A656420706C6174666F726D732E3C2F703E0D0A3C703E456D61696C3A20546865206F6E65206F6666696369616C6C79207075626C6973686564206279204D616E6F4E6567726153706F7274426574732E3C2F703E0D0A0D0A3C62723E0D0A3C68723E0D0A3C62723E3C62723E0D0A0D0A3C70207374796C653D22636F6C6F723A23613365363335223E3C623E4C4547414C20444953434C41494D45523C2F623E3C2F703E3C62723E0D0A3C703E53706F7274732062657474696E6720696E766F6C7665732066696E616E6369616C207269736B20616E642063616E2067656E6572617465206C6F737365732E204D616E6F4E6567726153706F7274426574732070726F766964657320696E666F726D6174696F6E20666F7220656475636174696F6E616C20616E6420656E7465727461696E6D656E7420707572706F7365732E20576520646F206E6F742067756172616E7465652070726F666974732C2070726F6669746162696C6974792C206F7220737065636966696320726573756C74732E20546865207573657220697320736F6C656C7920726573706F6E7369626C6520666F722074686569722062657474696E67206465636973696F6E7320616E642074686520757365206F662074686520696E666F726D6174696F6E2070726F76696465642E3C2F703E, 1, 'TERMS', NULL, NULL, 'en', '2026-08-16 19:34:44', '2026-08-16 19:34:44', NULL);

-- ----------------------------
-- Table structure for subscriptions
-- ----------------------------
DROP TABLE IF EXISTS `subscriptions`;
CREATE TABLE `subscriptions`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Suscripcion',
  `user_id` bigint(20) UNSIGNED NULL DEFAULT NULL COMMENT 'ID usuerio',
  `payment_date` datetime(0) NULL DEFAULT NULL COMMENT 'Dia de pago',
  `whop_membership_id` varchar(191) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `subscription_status` varchar(191) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'estatus',
  `subscription_plan` varchar(191) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'plan',
  `subscription_expires_at` datetime(0) NULL DEFAULT NULL COMMENT 'fecha de expiracion',
  `send_email` tinyint(1) NULL DEFAULT NULL COMMENT 'email enviado',
  `winner` tinyint(1) NULL DEFAULT NULL COMMENT 'Ganador',
  `sure_bettor` tinyint(1) NULL DEFAULT NULL COMMENT 'Seguro apostador',
  `quantity_pick` int(11) NULL DEFAULT NULL COMMENT 'Cantidad d epicks',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `user_id`(`user_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of subscriptions
-- ----------------------------
INSERT INTO `subscriptions` VALUES (2, 2, '2026-08-23 16:09:35', 'mber_Au4IVEGZ8Decq', 'active', 'elite', '2026-09-07 00:00:00', 1, 1, 0, 3, '2026-09-06 23:09:35', '2026-09-06 21:03:49');
INSERT INTO `subscriptions` VALUES (3, 4, '2026-08-24 16:48:18', 'mber_Au4IVEGZ8Decq', 'expirado', 'vip', '2026-09-03 16:48:18', NULL, NULL, NULL, NULL, '2026-08-24 23:48:18', '2026-09-06 07:08:31');

-- ----------------------------
-- Table structure for type_plans
-- ----------------------------
DROP TABLE IF EXISTS `type_plans`;
CREATE TABLE `type_plans`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'nombre',
  `is_active` tinyint(1) NULL DEFAULT NULL COMMENT 'estatus',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of type_plans
-- ----------------------------
INSERT INTO `type_plans` VALUES (1, 'DÍA', 1, '2026-06-24 10:50:16', '2026-06-24 10:50:16', NULL);
INSERT INTO `type_plans` VALUES (2, 'MES', 1, '2026-06-24 10:50:16', '2026-06-24 10:50:16', NULL);
INSERT INTO `type_plans` VALUES (3, 'SEMANA', 1, '2026-06-24 10:50:16', '2026-06-24 10:50:16', NULL);

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'correo electronico',
  `google_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'id de google',
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'contraseña',
  `rol_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Rol de acceso',
  `is_active` tinyint(1) NULL DEFAULT NULL COMMENT '0 =Inactive; 1=Active',
  `is_valid_email` tinyint(1) NULL DEFAULT 0 COMMENT 'email validado',
  `date_valid_email` timestamp(0) NULL DEFAULT NULL COMMENT 'dia en que valido el email',
  `accept_the_terms` tinyint(1) NULL DEFAULT NULL COMMENT 'Acepto terminos y condiciones',
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `rol_id`(`rol_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'admin@gmail.com', NULL, '$2y$10$NIaeyYNYLkvzE5TMW0G6g.WuAG0kma0VYgTceFAV8wPWohe17I44K', 1, 1, 1, NULL, NULL, NULL, '2022-12-01 14:29:01', '2026-09-19 15:15:17', NULL);
INSERT INTO `users` VALUES (2, 'jss.reyes21@gmail.com', NULL, '$2y$10$5QrVLOjMJE6CVUVotgDifu2Bry8kPiOM3Ulmy0Y/v/BbOj6THGPIe', 3, 1, 1, NULL, NULL, NULL, '2026-08-21 20:00:42', '2026-09-06 20:08:41', NULL);
INSERT INTO `users` VALUES (3, 'manonegrasportbets@gmail.com', NULL, '$2y$10$Yq1sNjsGLv0d8hhSX8nIPOvqYMucAdxDYeqh6.SQF81OZcC0GDzNO', 3, 1, 1, NULL, NULL, NULL, '2026-08-21 20:32:07', '2026-08-23 19:09:06', NULL);
INSERT INTO `users` VALUES (4, 'mediosoporte@gmail.com', NULL, '$2y$10$QlWJkAwORE5cbHWAM1IVx.gJBwUnweNFC81IjV6mE/pGMnZWZAGc2', 3, 1, 1, NULL, NULL, NULL, '2026-08-23 20:08:01', '2026-08-24 19:44:47', NULL);
INSERT INTO `users` VALUES (5, 'jss.reyes211@gmail.com', NULL, '$2y$10$ENR25FXftDCSzjNAAZq3W.dX884eDMaKy6mIomZsJYYInK1Ow3J6W', 3, 1, 0, NULL, NULL, NULL, '2026-09-14 23:01:56', '2026-09-14 23:01:56', NULL);

-- ----------------------------
-- Table structure for users_profiles
-- ----------------------------
DROP TABLE IF EXISTS `users_profiles`;
CREATE TABLE `users_profiles`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Perfil',
  `user_id` bigint(20) UNSIGNED NULL DEFAULT NULL COMMENT 'ID user',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `avatar` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `country_id` bigint(20) UNSIGNED NULL DEFAULT NULL COMMENT 'ID Pais',
  `first_name` varchar(191) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'Nombres',
  `last_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'Apellidos',
  `phone` bigint(20) NULL DEFAULT NULL COMMENT 'Telefono',
  `photo` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'Foto del perfil',
  `completed_profile` tinyint(1) NULL DEFAULT NULL COMMENT 'Perfil Completado',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `user_id`(`user_id`) USING BTREE,
  INDEX `country_id`(`country_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of users_profiles
-- ----------------------------
INSERT INTO `users_profiles` VALUES (1, 2, NULL, NULL, 21, 'jesus antonio', 'reyes osorio', 584243505709, 'photo-1787346787.jpg', 1, '2026-08-21 20:04:14', '2026-08-24 11:17:54');
INSERT INTO `users_profiles` VALUES (2, 3, NULL, NULL, 21, 'jesus', 'romero', 4166130053, NULL, 1, '2026-08-21 20:35:36', '2026-08-21 20:35:36');
INSERT INTO `users_profiles` VALUES (3, 4, NULL, NULL, 22, 'jesus', 'romero', 14166130053, NULL, 1, '2026-08-24 11:51:25', '2026-08-24 19:50:20');

-- ----------------------------
-- Table structure for web_suscriptions
-- ----------------------------
DROP TABLE IF EXISTS `web_suscriptions`;
CREATE TABLE `web_suscriptions`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `full_name` varchar(191) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `email` varchar(191) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `send_email` tinyint(1) NULL DEFAULT NULL,
  `quantity_pick` int(3) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of web_suscriptions
-- ----------------------------
INSERT INTO `web_suscriptions` VALUES (8, 'JESUS', 'jss.reyes2@gmail.com', NULL, NULL, '2026-09-15 20:16:22', '2026-09-15 20:16:22');

-- ----------------------------
-- Table structure for whop_webhook_events
-- ----------------------------
DROP TABLE IF EXISTS `whop_webhook_events`;
CREATE TABLE `whop_webhook_events`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `event_id` varchar(191) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `event_type` varchar(191) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `event_id`(`event_id`) USING BTREE,
  INDEX `user_id`(`user_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of whop_webhook_events
-- ----------------------------
INSERT INTO `whop_webhook_events` VALUES (1, 3, 'msg_6IzrDEAIjEEKttj7mXWPyWGE', 'payment.succeeded', '2026-08-21 20:36:03', '2026-08-21 20:36:03');
INSERT INTO `whop_webhook_events` VALUES (2, 3, 'msg_veG1dA7Y2BBk4aFhwMwFtGJA', 'payment.succeeded', '2026-08-21 20:46:38', '2026-08-21 20:46:38');
INSERT INTO `whop_webhook_events` VALUES (4, 3, 'msg_7TSVZL8dr40gQPhZtTgsMS6E', 'payment.succeeded', '2026-08-23 19:09:35', '2026-08-23 19:09:35');
INSERT INTO `whop_webhook_events` VALUES (5, 4, 'msg_zZuwUPxcaxw5ipOQRpD5V9Zr', 'payment.succeeded', '2026-08-24 19:48:18', '2026-08-24 19:48:18');

SET FOREIGN_KEY_CHECKS = 1;
