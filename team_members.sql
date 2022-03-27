-- MySQL dump 10.13  Distrib 5.7.29, for Linux (x86_64)
--
-- Host: localhost    Database: mokyklele
-- ------------------------------------------------------
-- Server version	5.7.29-0ubuntu0.18.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `team_members`
--

DROP TABLE IF EXISTS `team_members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `team_members` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `img` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `team_members`
--

LOCK TABLES `team_members` WRITE;
/*!40000 ALTER TABLE `team_members` DISABLE KEYS */;
INSERT INTO `team_members` VALUES (20,'Mokytoja Justė','<p><span style=\"font-family: Roboto;\">Esu džiazo ir populiariosios muzikos atlikėja ir pedagogė. Baigiau džiazo fortepijono magistro studijas Lietuvos Muzikos ir teatro akademijoje. Labai myliu vaikus ir žinau, kad muzika daro stebuklus - išlaisvina ir atpalaiduoja, o tai ypač svarbu mokantis kalbos. </span><br><span style=\"font-family: Roboto;\">Nekantrauju supažindinti vaikus su lietuvių kalba per muziką</span> </p>','23-7LtUCVVieiv52deO.jpg','2022-03-01 10:51:37','2022-03-01 10:51:37'),(21,'Mokytoja Gintarė','<p>Esu anglų kalbos mokytoja, turiu vyr. mokytojos kategoriją, <b>Pasakoje </b>mokau vaikus, kurie tik pradeda mokytis lietuvių kalbos.Taip pat jau virš 20 metų priklausau Lietuvos skautijos organizacijai. Daugiausia patirties atsinešu iš skautiško gyvenimo - moku suktis iš keblių situacijų, stengiuosi mokymąsi padaryti smagiu ir kartu naudingu! </p>','23-ssPHslApLivniuJA.jpg','2022-03-01 10:53:06','2022-03-01 10:53:06'),(22,'Mokytojas Martynas','<p>Nuo pat mažens apsuptas įvairių kalbų gaudžiau pokalbių nuotrupas, fiksavau kalbėjimo manieras taip panerdamas į nepažintas kultūras ir užmegzdamas naujas pažintis. Dirbdamas su mokiniais keliu sau panašų tikslą - padėti atrasti kalbos mokymosi ir pažinimo džiaugsmą. </p>','23-TCd90IDSndC5juWd.jpg','2022-03-01 10:54:08','2022-03-01 10:54:08'),(23,'Mokytoja Monika','<p>Pasirinkau savo svajonių studijas - pradinio ugdymo pedagogiką ir ankstyvąjį užsienio kalbos mokymą. Mano siekis yra sukurti jaukią ir šiluma grįstą mokymosi atmosferą, kuri skatintų vaikus atskleisti savo gebėjimus ir motyvuotų mokytis lietuvių kalbos! </p>','23-b7mCv4OpTwPvb7Uh.jpeg','2022-03-01 10:54:59','2022-03-01 10:54:59'),(24,'Mokytoja Edita','<p>Jau 17 metų esu lietuvių kalbos mokytoja ir turiu lietuvių kalbos mokytojos metodininkės kvalifikaciją. Man patinka skaityti, rašyti, kurti, mąstyti ir svajoti lietuviškai. Mėgstu keliauti po tikrą ir išgalvotą – knygų – pasaulį. Dabar leidžiuosi į smagią kelionę su mokyklėlės Pasaka nariais, kurdama jiems pamokų planus ir mokydama vaikus </p>','23-DyE5GcrOP0jzxdtA.jpg','2022-03-01 10:57:13','2022-03-01 10:57:13'),(25,'Mokytoja Gabrielė','<p>Esu pedagogė, grojanti arfa! Baigiau arfos atlikimo meno ir gretutines pedagogikos studijas Lietuvos muzikos ir teatro akademijoje. Pasakoje mokau pačius mažiausius ir žinau, kad vaikai iš prigimties yra smalsūs ir žingeidūs, reikia tik atrasti raktelį į kiekvieno vaiko širdelę ir paskatinti jį džiaugtis mokymosi procesu. Muzika ir yra tas raktelis, kuris padeda atsipalaiduoti, skatina kūrybiškumą - tai vienas svarbiausių komponentų mokantis kalbos. </p>','23-hYsNQTCWeVNmaeXa.jpg','2022-03-01 10:57:55','2022-03-01 10:57:55'),(26,'Mokytoja Jolanta','<p>Nuo pat vaikystės svajojau būti mokytoja ir mano svajonė išsipildė - esu pedagogė, kalbų mokytoja. Gyvenu Italijoje ir čia dirbu kalbų mokykloje. Džiaugiuosi prisijungusi prie Pasakos komandos! Mano siekis - ne tik padėti Pasakos mažučiams mokytis pačios gražiausios pasaulyje kalbos, bet ir skatinti jų smalsumą, norą pažinti lietuviškas tradicijas ir kultūrą, juos motyvuoti ir nuolat priminti, kaip svarbu ir gera yra svajoti! </p>','23-YdB64stTCL3jCCPq.jpg','2022-03-01 10:59:02','2022-03-01 10:59:02'),(27,'Mokytoja Silvija','<p>Esu Lietuvos muzikos ir teatro akademijos absolventė. Myliu vaikus ir domiuosi šiuolaikinėmis ugdymo technologijomis, dirbu muzikos mokykloje mokytoja. Mano siekis - padėti kiekvienam, net ir pačiam mažiausiam Pasakos mokiniui atrasti meilę lietuvių kalbai. Juk sužinoti ir išmokti kažką naujo gali būti ne tik lengva, bet ir labai linksma! </p>','23-iam6HidEiATjSh3R.jpeg','2022-03-01 10:59:49','2022-03-01 10:59:49'),(28,'Mokytoja Guoda','<p>Studijuoju pradinio ugdymo pedagogiką ir ankstyvąjį užsienio kalbos mokymą. Esu labai žingeidi, trokštu išbandyti naujoves ir patirti nuotykius! Mano tikslas Pasakoje yra ne tik mokyti lietuvių kalbos ir kultūros, bet taip pat įkvėpti, padrąsinti ir motyvuoti mažuosius pasaulio lietuvius! </p>','23-krbzaBVNm7PWGAtZ.jpeg','2022-03-01 11:01:30','2022-03-01 11:01:30'),(29,'Jonas','<p>Vytauto Didžiojo universitete įgyjau lietuvių filologijos bakalauro laipsnį ir šiuo metu tęsiu mokslus Moderniosios lingvistikos magistro studijose, kuriose sujungiamos dvi sritys: daugiakalbystė ir kalbos technologijos. Pasakos komandai padedu įveikti įvairias užduotis ir dalinuosi daugiakalbystės ir pedagogikos žiniomis, kad mažieji užsienio lietuviai tobulėtų kurdami lietuviškąjį identitetą ir lietuvių kalbą. Juk kalbą kuria ne žodynai, bet žmonės! </p>','23-Qi11bv4MvWK85nrQ','2022-03-01 11:05:00','2022-03-01 11:05:00'),(30,'Eglė','<p>Esu Pasaka bendraįkūrėja ir atsakinga už Pasakos mokytojų komandą. Kartu su ja kuriu pamokų planus Pasaka mokiniams. Baigiau bakalauro ir magistro kalbotyros studijas Jorko ir UCL universitetuose, kur gilinausi į vaikų kalbos įsisavinimo bei antros kalbos mokymosi teorijas, tyrinėjau dvikalbystės ypatumus. Žinias pritaikau ir augindama du dvikalbius vaikučius. </p>','23-1cQMHQae9aKoNpGi.jpg','2022-03-01 11:07:29','2022-03-01 11:07:29'),(31,'Justė','<p>Esu Pasaka bendraįkūrėja, marketingo specialistė ir trijų dvikalbių mama. \"Mummy can we valgytin košę for breakfast?\" ir panašūs kalbų miksai mūsų namuose skamba nuolatos. Tad ir virtualios lituanistinės mokyklėlės idėja kilo natūraliai - ieškant įdomaus, linksmo ir kokybiško lietuviško turinio savo vaikams. Džiaugiuosi Pasaka komanda ir ačiū Eglei, kad patikėjo idėja! </p>','23-qdn9NqzCCQQe2VLx.jpg','2022-03-01 11:09:12','2022-03-01 11:09:12');
/*!40000 ALTER TABLE `team_members` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-03-01 11:11:28
