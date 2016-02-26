-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 26-Fev-2016 às 16:49
-- Versão do servidor: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sgpd`
--
CREATE DATABASE IF NOT EXISTS `sgpd` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `sgpd`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `dados_bairros`
--

CREATE TABLE IF NOT EXISTS `dados_bairros` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` smallint(1) NOT NULL,
  `cidade` varchar(200) NOT NULL,
  `nome` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=45 ;

--
-- Extraindo dados da tabela `dados_bairros`
--

INSERT INTO `dados_bairros` (`id`, `status`, `cidade`, `nome`) VALUES
(1, 1, 'Balneário Camboriú', 'Ariribá'),
(2, 1, 'Balneário Camboriú', 'Asilo'),
(3, 1, 'Balneário Camboriú', 'Barra'),
(4, 1, 'Balneário Camboriú', 'Barra Sul'),
(5, 1, 'Balneário Camboriú', 'Centro'),
(6, 1, 'Balneário Camboriú', 'Estados'),
(7, 1, 'Balneário Camboriú', 'Estaleiro'),
(8, 1, 'Balneário Camboriú', 'Laranjeiras'),
(9, 1, 'Balneário Camboriú', 'Meia Praia'),
(10, 1, 'Balneário Camboriú', 'Municípios'),
(11, 1, 'Balneário Camboriú', 'Nações'),
(12, 1, 'Balneário Camboriú', 'Nova Esperança'),
(13, 1, 'Balneário Camboriú', 'Pioneiros'),
(14, 1, 'Balneário Camboriú', 'Praia dos Amores'),
(15, 1, 'Balneário Camboriú', 'Vila Real'),
(16, 1, 'Camboriú', 'Monte Alegre'),
(19, 1, 'Camboriú', 'Centro'),
(26, 1, 'Camboriú', 'Tabuleiro'),
(27, 1, 'Camboriú', 'Areias'),
(28, 1, 'Camboriú', 'Cedro'),
(29, 1, 'Camboriú', 'Conde'),
(30, 1, 'Camboriú', 'Barranco'),
(31, 1, 'Camboriú', 'Jardim '),
(32, 1, 'Camboriú', 'Vila da Pedra'),
(33, 1, 'Camboriú', 'Santa Regina');

-- --------------------------------------------------------

--
-- Estrutura da tabela `dados_estados`
--

CREATE TABLE IF NOT EXISTS `dados_estados` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` smallint(1) NOT NULL,
  `iso3` char(3) COLLATE utf8_swedish_ci NOT NULL,
  `uf` char(4) COLLATE utf8_swedish_ci NOT NULL,
  `nome` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=28 ;

--
-- Extraindo dados da tabela `dados_estados`
--

INSERT INTO `dados_estados` (`id`, `status`, `iso3`, `uf`, `nome`) VALUES
(1, 1, 'BRA', 'AC', 'Acre'),
(2, 1, 'BRA', 'AL', 'Alagoas'),
(3, 1, 'BRA', 'AP', 'Amapá'),
(4, 1, 'BRA', 'AM', 'Amazonas'),
(5, 1, 'BRA', 'BA', 'Bahia'),
(6, 1, 'BRA', 'CE', 'Ceará'),
(7, 1, 'BRA', 'DF', 'Distrito Federal'),
(8, 1, 'BRA', 'ES', 'Espírito Santo'),
(9, 1, 'BRA', 'GO', 'Goiás'),
(10, 1, 'BRA', 'MA', 'Maranhão'),
(11, 1, 'BRA', 'MT', 'Mato Grosso'),
(12, 1, 'BRA', 'MS', 'Mato Grosso do Sul'),
(13, 1, 'BRA', 'MG', 'Minas Gerais'),
(14, 1, 'BRA', 'PA', 'Pará'),
(15, 1, 'BRA', 'PB', 'Paraíba'),
(16, 1, 'BRA', 'PR', 'Paraná'),
(17, 1, 'BRA', 'PE', 'Pernambuco'),
(18, 1, 'BRA', 'PI', 'Piauí'),
(19, 1, 'BRA', 'RJ', 'Rio de Janeiro'),
(20, 1, 'BRA', 'RN', 'Rio Grande do Norte'),
(21, 1, 'BRA', 'RS', 'Rio Grande do Sul'),
(22, 1, 'BRA', 'RO', 'Rondônia'),
(23, 1, 'BRA', 'RR', 'Roraima'),
(24, 1, 'BRA', 'SC', 'Santa Catarina'),
(25, 1, 'BRA', 'SP', 'São Paulo'),
(26, 1, 'BRA', 'SE', 'Sergipe'),
(27, 1, 'BRA', 'TO', 'Tocantins');

-- --------------------------------------------------------

--
-- Estrutura da tabela `dados_paises`
--

CREATE TABLE IF NOT EXISTS `dados_paises` (
  `status` smallint(1) NOT NULL,
  `iso` char(2) COLLATE utf8_swedish_ci NOT NULL,
  `iso3` char(3) COLLATE utf8_swedish_ci NOT NULL,
  `numero` smallint(6) DEFAULT NULL,
  `nome` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  PRIMARY KEY (`iso`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Extraindo dados da tabela `dados_paises`
--

INSERT INTO `dados_paises` (`status`, `iso`, `iso3`, `numero`, `nome`) VALUES
(1, 'AF', 'AFG', 4, 'Afeganistão'),
(1, 'ZA', 'ZAF', 710, 'África do Sul'),
(1, 'AX', 'ALA', 248, 'Åland, Ilhas'),
(1, 'AL', 'ALB', 8, 'Albânia'),
(1, 'DE', 'DEU', 276, 'Alemanha'),
(1, 'AD', 'AND', 20, 'Andorra'),
(1, 'AO', 'AGO', 24, 'Angola'),
(1, 'AI', 'AIA', 660, 'Anguilla'),
(1, 'AQ', 'ATA', 10, 'Antárctida'),
(1, 'AG', 'ATG', 28, 'Antigua e Barbuda'),
(1, 'AN', 'ANT', 530, 'Antilhas Holandesas'),
(1, 'SA', 'SAU', 682, 'Arábia Saudita'),
(1, 'DZ', 'DZA', 12, 'Argélia'),
(1, 'AR', 'ARG', 32, 'Argentina'),
(1, 'AM', 'ARM', 51, 'Arménia'),
(1, 'AW', 'ABW', 533, 'Aruba'),
(1, 'AU', 'AUS', 36, 'Austrália'),
(1, 'AT', 'AUT', 40, 'Áustria'),
(1, 'AZ', 'AZE', 31, 'Azerbeijão'),
(1, 'BS', 'BHS', 44, 'Bahamas'),
(1, 'BH', 'BHR', 48, 'Bahrain'),
(1, 'BD', 'BGD', 50, 'Bangladesh'),
(1, 'BB', 'BRB', 52, 'Barbados'),
(1, 'BE', 'BEL', 56, 'Bélgica'),
(1, 'BZ', 'BLZ', 84, 'Belize'),
(1, 'BJ', 'BEN', 204, 'Benin'),
(1, 'BM', 'BMU', 60, 'Bermuda'),
(1, 'BY', 'BLR', 112, 'Bielo-Rússia'),
(1, 'BO', 'BOL', 68, 'Bolívia'),
(1, 'BA', 'BIH', 70, 'Bósnia-Herzegovina'),
(1, 'BW', 'BWA', 72, 'Botswana'),
(1, 'BV', 'BVT', 74, 'Bouvet, Ilha'),
(1, 'BR', 'BRA', 76, 'Brasil'),
(1, 'BN', 'BRN', 96, 'Brunei'),
(1, 'BG', 'BGR', 100, 'Bulgária'),
(1, 'BF', 'BFA', 854, 'Burkina Faso'),
(1, 'BI', 'BDI', 108, 'Burundi'),
(1, 'BT', 'BTN', 64, 'Butão'),
(1, 'CV', 'CPV', 132, 'Cabo Verde'),
(1, 'KH', 'KHM', 116, 'Cambodja'),
(1, 'CM', 'CMR', 120, 'Camarões'),
(1, 'CA', 'CAN', 124, 'Canadá'),
(1, 'KY', 'CYM', 136, 'Cayman, Ilhas'),
(1, 'KZ', 'KAZ', 398, 'Cazaquistão'),
(1, 'CF', 'CAF', 140, 'Centro-africana, República'),
(1, 'TD', 'TCD', 148, 'Chade'),
(1, 'CZ', 'CZE', 203, 'Checa, República'),
(1, 'CL', 'CHL', 152, 'Chile'),
(1, 'CN', 'CHN', 156, 'China'),
(1, 'CY', 'CYP', 196, 'Chipre'),
(1, 'CX', 'CXR', 162, 'Christmas, Ilha'),
(1, 'CC', 'CCK', 166, 'Cocos, Ilhas'),
(1, 'CO', 'COL', 170, 'Colômbia'),
(1, 'KM', 'COM', 174, 'Comores'),
(1, 'CG', 'COG', 178, 'Congo, República do'),
(1, 'CD', 'COD', 180, 'Congo, República Democrática do (antigo Zaire)'),
(1, 'CK', 'COK', 184, 'Cook, Ilhas'),
(1, 'KR', 'KOR', 410, 'Coreia do Sul'),
(1, 'KP', 'PRK', 408, 'Coreia, República Democrática da (Coreia do Norte)'),
(1, 'CI', 'CIV', 384, 'Costa do Marfim'),
(1, 'CR', 'CRI', 188, 'Costa Rica'),
(1, 'HR', 'HRV', 191, 'Croácia'),
(1, 'CU', 'CUB', 192, 'Cuba'),
(1, 'DK', 'DNK', 208, 'Dinamarca'),
(1, 'DJ', 'DJI', 262, 'Djibouti'),
(1, 'DM', 'DMA', 212, 'Dominica'),
(1, 'DO', 'DOM', 214, 'Dominicana, República'),
(1, 'EG', 'EGY', 818, 'Egipto'),
(1, 'SV', 'SLV', 222, 'El Salvador'),
(1, 'AE', 'ARE', 784, 'Emiratos Árabes Unidos'),
(1, 'EC', 'ECU', 218, 'Equador'),
(1, 'ER', 'ERI', 232, 'Eritreia'),
(1, 'SK', 'SVK', 703, 'Eslováquia'),
(1, 'SI', 'SVN', 705, 'Eslovénia'),
(1, 'ES', 'ESP', 724, 'Espanha'),
(1, 'US', 'USA', 840, 'Estados Unidos da América'),
(1, 'EE', 'EST', 233, 'Estónia'),
(1, 'ET', 'ETH', 231, 'Etiópia'),
(1, 'FO', 'FRO', 234, 'Faroe, Ilhas'),
(1, 'FJ', 'FJI', 242, 'Fiji'),
(1, 'PH', 'PHL', 608, 'Filipinas'),
(1, 'FI', 'FIN', 246, 'Finlândia'),
(1, 'FR', 'FRA', 250, 'França'),
(1, 'GA', 'GAB', 266, 'Gabão'),
(1, 'GM', 'GMB', 270, 'Gâmbia'),
(1, 'GH', 'GHA', 288, 'Gana'),
(1, 'GE', 'GEO', 268, 'Geórgia'),
(1, 'GS', 'SGS', 239, 'Geórgia do Sul e Sandwich do Sul, Ilhas'),
(1, 'GI', 'GIB', 292, 'Gibraltar'),
(1, 'GR', 'GRC', 300, 'Grécia'),
(1, 'GD', 'GRD', 308, 'Grenada'),
(1, 'GL', 'GRL', 304, 'Gronelândia'),
(1, 'GP', 'GLP', 312, 'Guadeloupe'),
(1, 'GU', 'GUM', 316, 'Guam'),
(1, 'GT', 'GTM', 320, 'Guatemala'),
(1, 'GG', 'GGY', 831, 'Guernsey'),
(1, 'GY', 'GUY', 328, 'Guiana'),
(1, 'GF', 'GUF', 254, 'Guiana Francesa'),
(1, 'GW', 'GNB', 624, 'Guiné-Bissau'),
(1, 'GN', 'GIN', 324, 'Guiné-Conacri'),
(1, 'GQ', 'GNQ', 226, 'Guiné Equatorial'),
(1, 'HT', 'HTI', 332, 'Haiti'),
(1, 'HM', 'HMD', 334, 'Heard e Ilhas McDonald, Ilha'),
(1, 'HN', 'HND', 340, 'Honduras'),
(1, 'HK', 'HKG', 344, 'Hong Kong'),
(1, 'HU', 'HUN', 348, 'Hungria'),
(1, 'YE', 'YEM', 887, 'Iémen'),
(1, 'IN', 'IND', 356, 'Índia'),
(1, 'ID', 'IDN', 360, 'Indonésia'),
(1, 'IQ', 'IRQ', 368, 'Iraque'),
(1, 'IR', 'IRN', 364, 'Irão'),
(1, 'IE', 'IRL', 372, 'Irlanda'),
(1, 'IS', 'ISL', 352, 'Islândia'),
(1, 'IL', 'ISR', 376, 'Israel'),
(1, 'IT', 'ITA', 380, 'Itália'),
(1, 'JM', 'JAM', 388, 'Jamaica'),
(1, 'JP', 'JPN', 392, 'Japão'),
(1, 'JE', 'JEY', 832, 'Jersey'),
(1, 'JO', 'JOR', 400, 'Jordânia'),
(1, 'KI', 'KIR', 296, 'Kiribati'),
(1, 'KW', 'KWT', 414, 'Kuwait'),
(1, 'LA', 'LAO', 418, 'Laos'),
(1, 'LS', 'LSO', 426, 'Lesoto'),
(1, 'LV', 'LVA', 428, 'Letónia'),
(1, 'LB', 'LBN', 422, 'Líbano'),
(1, 'LR', 'LBR', 430, 'Libéria'),
(1, 'LY', 'LBY', 434, 'Líbia'),
(1, 'LI', 'LIE', 438, 'Liechtenstein'),
(1, 'LT', 'LTU', 440, 'Lituânia'),
(1, 'LU', 'LUX', 442, 'Luxemburgo'),
(1, 'MO', 'MAC', 446, 'Macau'),
(1, 'MK', 'MKD', 807, 'Macedónia, República da'),
(1, 'MG', 'MDG', 450, 'Madagáscar'),
(1, 'MY', 'MYS', 458, 'Malásia'),
(1, 'MW', 'MWI', 454, 'Malawi'),
(1, 'MV', 'MDV', 462, 'Maldivas'),
(1, 'ML', 'MLI', 466, 'Mali'),
(1, 'MT', 'MLT', 470, 'Malta'),
(1, 'FK', 'FLK', 238, 'Malvinas, Ilhas (Falkland)'),
(1, 'IM', 'IMN', 833, 'Man, Ilha de'),
(1, 'MP', 'MNP', 580, 'Marianas Setentrionais'),
(1, 'MA', 'MAR', 504, 'Marrocos'),
(1, 'MH', 'MHL', 584, 'Marshall, Ilhas'),
(1, 'MQ', 'MTQ', 474, 'Martinica'),
(1, 'MU', 'MUS', 480, 'Maurícia'),
(1, 'MR', 'MRT', 478, 'Mauritânia'),
(1, 'YT', 'MYT', 175, 'Mayotte'),
(1, 'UM', 'UMI', 581, 'Menores Distantes dos Estados Unidos, Ilhas'),
(1, 'MX', 'MEX', 484, 'México'),
(1, 'MM', 'MMR', 104, 'Myanmar (antiga Birmânia)'),
(1, 'FM', 'FSM', 583, 'Micronésia, Estados Federados da'),
(1, 'MZ', 'MOZ', 508, 'Moçambique'),
(1, 'MD', 'MDA', 498, 'Moldávia'),
(1, 'MC', 'MCO', 492, 'Mónaco'),
(1, 'MN', 'MNG', 496, 'Mongólia'),
(1, 'ME', 'MNE', 499, 'Montenegro'),
(1, 'MS', 'MSR', 500, 'Montserrat'),
(1, 'NA', 'NAM', 516, 'Namíbia'),
(1, 'NR', 'NRU', 520, 'Nauru'),
(1, 'NP', 'NPL', 524, 'Nepal'),
(1, 'NI', 'NIC', 558, 'Nicarágua'),
(1, 'NE', 'NER', 562, 'Níger'),
(1, 'NG', 'NGA', 566, 'Nigéria'),
(1, 'NU', 'NIU', 570, 'Niue'),
(1, 'NF', 'NFK', 574, 'Norfolk, Ilha'),
(1, 'NO', 'NOR', 578, 'Noruega'),
(1, 'NC', 'NCL', 540, 'Nova Caledónia'),
(1, 'NZ', 'NZL', 554, 'Nova Zelândia (Aotearoa)'),
(1, 'OM', 'OMN', 512, 'Oman'),
(1, 'NL', 'NLD', 528, 'Países Baixos (Holanda)'),
(1, 'PW', 'PLW', 585, 'Palau'),
(1, 'PS', 'PSE', 275, 'Palestina'),
(1, 'PA', 'PAN', 591, 'Panamá'),
(1, 'PG', 'PNG', 598, 'Papua-Nova Guiné'),
(1, 'PK', 'PAK', 586, 'Paquistão'),
(1, 'PY', 'PRY', 600, 'Paraguai'),
(1, 'PE', 'PER', 604, 'Peru'),
(1, 'PN', 'PCN', 612, 'Pitcairn'),
(1, 'PF', 'PYF', 258, 'Polinésia Francesa'),
(1, 'PL', 'POL', 616, 'Polónia'),
(1, 'PR', 'PRI', 630, 'Porto Rico'),
(1, 'PT', 'PRT', 620, 'Portugal'),
(1, 'QA', 'QAT', 634, 'Qatar'),
(1, 'KE', 'KEN', 404, 'Quénia'),
(1, 'KG', 'KGZ', 417, 'Quirguistão'),
(1, 'GB', 'GBR', 826, 'Reino Unido da Grã-Bretanha e Irlanda do Norte'),
(1, 'RE', 'REU', 638, 'Reunião'),
(1, 'RO', 'ROU', 642, 'Roménia'),
(1, 'RW', 'RWA', 646, 'Ruanda'),
(1, 'RU', 'RUS', 643, 'Rússia'),
(1, 'EH', 'ESH', 732, 'Saara Ocidental'),
(1, 'AS', 'ASM', 16, 'Samoa Americana'),
(1, 'WS', 'WSM', 882, 'Samoa (Samoa Ocidental)'),
(1, 'PM', 'SPM', 666, 'Saint Pierre et Miquelon'),
(1, 'SB', 'SLB', 90, 'Salomão, Ilhas'),
(1, 'KN', 'KNA', 659, 'São Cristóvão e Névis (Saint Kitts e Nevis)'),
(1, 'SM', 'SMR', 674, 'San Marino'),
(1, 'ST', 'STP', 678, 'São Tomé e Príncipe'),
(1, 'VC', 'VCT', 670, 'São Vicente e Granadinas'),
(1, 'SH', 'SHN', 654, 'Santa Helena'),
(1, 'LC', 'LCA', 662, 'Santa Lúcia'),
(1, 'SN', 'SEN', 686, 'Senegal'),
(1, 'SL', 'SLE', 694, 'Serra Leoa'),
(1, 'RS', 'SRB', 688, 'Sérvia'),
(1, 'SC', 'SYC', 690, 'Seychelles'),
(1, 'SG', 'SGP', 702, 'Singapura'),
(1, 'SY', 'SYR', 760, 'Síria'),
(1, 'SO', 'SOM', 706, 'Somália'),
(1, 'LK', 'LKA', 144, 'Sri Lanka'),
(1, 'SZ', 'SWZ', 748, 'Suazilândia'),
(1, 'SD', 'SDN', 736, 'Sudão'),
(1, 'SE', 'SWE', 752, 'Suécia'),
(1, 'CH', 'CHE', 756, 'Suíça'),
(1, 'SR', 'SUR', 740, 'Suriname'),
(1, 'SJ', 'SJM', 744, 'Svalbard e Jan Mayen'),
(1, 'TH', 'THA', 764, 'Tailândia'),
(1, 'TW', 'TWN', 158, 'Taiwan'),
(1, 'TJ', 'TJK', 762, 'Tajiquistão'),
(1, 'TZ', 'TZA', 834, 'Tanzânia'),
(1, 'TF', 'ATF', 260, 'Terras Austrais e Antárticas Francesas (TAAF)'),
(1, 'IO', 'IOT', 86, 'Território Britânico do Oceano Índico'),
(1, 'TL', 'TLS', 626, 'Timor-Leste'),
(1, 'TG', 'TGO', 768, 'Togo'),
(1, 'TK', 'TKL', 772, 'Toquelau'),
(1, 'TO', 'TON', 776, 'Tonga'),
(1, 'TT', 'TTO', 780, 'Trindade e Tobago'),
(1, 'TN', 'TUN', 788, 'Tunísia'),
(1, 'TC', 'TCA', 796, 'Turks e Caicos'),
(1, 'TM', 'TKM', 795, 'Turquemenistão'),
(1, 'TR', 'TUR', 792, 'Turquia'),
(1, 'TV', 'TUV', 798, 'Tuvalu'),
(1, 'UA', 'UKR', 804, 'Ucrânia'),
(1, 'UG', 'UGA', 800, 'Uganda'),
(1, 'UY', 'URY', 858, 'Uruguai'),
(1, 'UZ', 'UZB', 860, 'Usbequistão'),
(1, 'VU', 'VUT', 548, 'Vanuatu'),
(1, 'VA', 'VAT', 336, 'Vaticano'),
(1, 'VE', 'VEN', 862, 'Venezuela'),
(1, 'VN', 'VNM', 704, 'Vietname'),
(1, 'VI', 'VIR', 850, 'Virgens Americanas, Ilhas'),
(1, 'VG', 'VGB', 92, 'Virgens Britânicas, Ilhas'),
(1, 'WF', 'WLF', 876, 'Wallis e Futuna'),
(1, 'ZM', 'ZMB', 894, 'Zâmbia'),
(1, 'ZW', 'ZWE', 716, 'Zimbabwe');

-- --------------------------------------------------------

--
-- Estrutura da tabela `eixo`
--

CREATE TABLE IF NOT EXISTS `eixo` (
  `id_eixo` int(11) NOT NULL AUTO_INCREMENT,
  `nome_eixo` mediumtext NOT NULL,
  `desc_eixo` mediumtext,
  PRIMARY KEY (`id_eixo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Extraindo dados da tabela `eixo`
--

INSERT INTO `eixo` (`id_eixo`, `nome_eixo`, `desc_eixo`) VALUES
(1, 'A', 'Ensino'),
(2, 'B', 'Orientacao'),
(3, 'C', 'Pesquisa'),
(4, 'D', 'Extensao'),
(5, 'E', 'Gestao'),
(6, 'F', 'QUALIFICAÇÃO E CAPACITAÇÃO DOCENTE');

-- --------------------------------------------------------

--
-- Estrutura da tabela `item`
--

CREATE TABLE IF NOT EXISTS `item` (
  `id_item` int(11) NOT NULL AUTO_INCREMENT,
  `id_subeixo` int(11) NOT NULL,
  `id_itemtipo` int(11) NOT NULL,
  `id_itempai` int(11) NOT NULL,
  `id_ponto` int(11) NOT NULL,
  `nome_item` text NOT NULL,
  `desc_item` text NOT NULL,
  `docprob_item` text NOT NULL,
  PRIMARY KEY (`id_item`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=63 ;

--
-- Extraindo dados da tabela `item`
--

INSERT INTO `item` (`id_item`, `id_subeixo`, `id_itemtipo`, `id_itempai`, `id_ponto`, `nome_item`, `desc_item`, `docprob_item`) VALUES
(19, 1, 1, 0, 0, 'A1.1', 'Na graduação', 'Declaração da Chefia imediata ou Documento do SIGAA'),
(20, 1, 1, 0, 0, 'A1.2', 'Na pós-graduação', 'Declaração da coordenação do Programa ou Documento do SIGAA'),
(21, 1, 1, 0, 0, 'A1.3', 'Coordenação de projetos de ensino, eixos de componentes curriculares, preceptores de residência ou similares', 'Declaração da Chefia imediata'),
(22, 1, 1, 0, 0, 'A1.4', 'Coordenação Institucional em Programas Acadêmicos (Ciência sem Fronteiras, PIBID, PET, PEC-G, etc), por programa', 'Declaração da Pró-Reitoria a qual o programa é vinculado'),
(23, 2, 2, 0, 0, 'B1.1', 'Orientação finalizada em Iniciação Científica, por plano de trabalho do aluno aprovado no PIBIC ou em projeto de pesquisa aprovado por agência de fomento', 'Declaração do Departamento de Pesquisa/PPPG sobre o cumprimento do plano de orientação ou Declaração da coordenação institucional, termo de concessão da agência de fomento'),
(24, 2, 2, 0, 0, 'B1.2', 'Orientação finalizada no Programa Jovens Talentos ou PIBITI, por plano de trabalho do aluno', 'Declaração do DEDEG/PROEN sobre o cumprimento do plano de orientação ou Declaração da coordenação institucional'),
(25, 3, 3, 0, 0, 'B2.1', 'Orientação finalizada de Monografias de especialização, por unidade', 'Declaração do coordenador do curso associado (SIGAA)'),
(26, 4, 4, 0, 0, 'C1.1', 'Livros publicados na área de conhecimento com ISBN', ''),
(27, 0, 0, 26, 0, 'C1.1.1', 'Autoria única', 'um volume ou cópia do livro e classificação da Capes quando houver'),
(28, 0, 0, 26, 0, 'C1.1.2', 'Autoria compartilhada', 'um volume ou cópia do livro e classificação da Capes quando houver'),
(29, 14, 0, 0, 0, 'item teste f', 'item teste f desc', 'doc item teste f'),
(31, 14, 0, 0, 0, 'item teste f', 'item teste f', 'item teste f'),
(32, 14, 0, 0, 0, 'item teste f2', 'item teste f2', 'doc item teste f2'),
(33, 1, 0, 0, 0, 'item teste f', 'item teste fw', 'item teste fw'),
(34, 14, 0, 0, 0, 'item teste f', 're', 'rew'),
(35, 14, 0, 0, 0, 'item teste f2DS', 'item teste f2DSQDW', 'item teste f2QDW'),
(36, 14, 0, 0, 0, 'teste ponto', 'teste ponto desc', 'teste ponto doc'),
(37, 14, 0, 0, 0, 'teste ponto2', 'teste ponto2', 'teste ponto2 doc'),
(38, 14, 0, 0, 0, 'teste ponto3', 'teste ponto3 desc', 'teste ponto3 dic'),
(39, 14, 0, 0, 0, 'teste ponto4', 'teste ponto4 desc', 'teste ponto4 doc'),
(40, 14, 0, 0, 0, 'teste ponto5', 'teste ponto5 desc', 'teste ponto5 doc'),
(41, 14, 0, 0, 6, 'teste ponto6', 'teste ponto6', 'teste ponto6'),
(42, 13, 0, 0, -1, 'teste ponto7', 'este ponto7 d', 'este ponto7 doc'),
(43, 14, 0, 0, -1, 'teste ponto8', 'test', 'tes'),
(44, 14, 0, 0, -1, 'f teste9', 'te', ''),
(45, 14, 0, 0, 7, 'f teste10', 'f teste10', 'f teste10'),
(46, 14, 0, 0, 8, 'item teste 12', 'item teste 12', 'item teste 12'),
(47, 14, 0, 0, 9, 'item teste 13', 'item teste 13', 'item teste 13'),
(48, 14, 0, 0, 10, 'item teste 14', 'item teste 14', 'item teste 14'),
(49, 14, 0, 0, 11, 'teste ponto15', 'teste ponto15', 'teste ponto15'),
(50, 14, 0, 0, 12, 'teste ponto16', 'teste ponto16', 'teste ponto16'),
(51, 14, 0, 0, 13, 'teste ponto17', 'teste ponto17', 'teste ponto17'),
(52, 14, 0, 0, 14, 'teste ponto18', 'teste ponto18', 'teste ponto18'),
(53, 14, 0, 0, 15, 'item teste 19', 'item teste 19', 'item teste 19'),
(54, 14, 0, 0, 16, 'item teste 20', 'item teste 20', 'item teste 20'),
(55, 14, 0, 0, 17, 'item 21', 'teste 21', ''),
(56, 14, 0, 0, -1, 'item 24', 'teste 24', ''),
(57, 14, 0, 0, -1, 'item 24', 'teste 24', ''),
(58, 14, 0, 0, 18, 'item 25', 'teste 25', 'doc'),
(59, 14, 0, 0, -1, 'item 26', 'teste 26', ''),
(60, 14, 0, 0, -1, 'item 26', 'teste 26', ''),
(61, 14, 0, 0, 19, 'item 27', 'desc item 27', 'documentacao item 27'),
(62, 13, 0, 0, 21, 'E.2.1', 'teste e2 desc', 'teste e2');

-- --------------------------------------------------------

--
-- Estrutura da tabela `item_tipo`
--

CREATE TABLE IF NOT EXISTS `item_tipo` (
  `id_itemtipo` int(11) NOT NULL AUTO_INCREMENT,
  `nome_itemtipo` text NOT NULL,
  PRIMARY KEY (`id_itemtipo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ponto`
--

CREATE TABLE IF NOT EXISTS `ponto` (
  `id_ponto` int(11) NOT NULL AUTO_INCREMENT,
  `id_pontopai` int(11) NOT NULL,
  `tipo_und_valor` double NOT NULL,
  `tipo_und_desc` text NOT NULL,
  `qtd_max_und` double NOT NULL,
  `ponto_por_und` double NOT NULL,
  PRIMARY KEY (`id_ponto`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- Extraindo dados da tabela `ponto`
--

INSERT INTO `ponto` (`id_ponto`, `id_pontopai`, `tipo_und_valor`, `tipo_und_desc`, `qtd_max_und`, `ponto_por_und`) VALUES
(1, 0, 2, 'nao deu', 20, 1),
(2, 0, 1, 'artigo', 30, 2),
(3, 0, 1, 'artigo', 20, 2),
(4, 0, 2, 'projeto', 6, 1),
(5, 0, 1, 'projeto', 12, 2),
(6, 0, 2, 'projeto', 10, 2),
(7, 0, 4, 'hora', 0, 2),
(8, 0, 0, '', 0, 0),
(9, 0, 0, '', 0, 0),
(10, 0, 0, '', 0, 0),
(11, 0, 0, '', 0, 0),
(12, 0, 0, '', 0, 0),
(13, 0, 0, '', 0, 0),
(14, 0, 0, '', 0, 0),
(15, 0, 0, '', 0, 0),
(16, 0, 0, '', 0, 0),
(17, 0, 0, 'desc pont', 0, 0),
(18, 0, 1, 'musica', 12, 1),
(19, 0, 1, 'hora', 0, 2),
(20, 19, 1, 'projeto Qualis1', 0, 1.5),
(21, 0, 15, 'hora', 60, 1.5);

-- --------------------------------------------------------

--
-- Estrutura da tabela `subeixo`
--

CREATE TABLE IF NOT EXISTS `subeixo` (
  `id_subeixo` int(11) NOT NULL AUTO_INCREMENT,
  `id_eixo` int(11) NOT NULL,
  `nome_subeixo` mediumtext NOT NULL,
  `desc_subeixo` mediumtext NOT NULL,
  `pont_max_subeixo` double NOT NULL,
  PRIMARY KEY (`id_subeixo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Extraindo dados da tabela `subeixo`
--

INSERT INTO `subeixo` (`id_subeixo`, `id_eixo`, `nome_subeixo`, `desc_subeixo`, `pont_max_subeixo`) VALUES
(1, 1, 'A1', 'Atividades de Ensino', 80),
(2, 2, 'B1', 'Orientação na Graduação', 30),
(3, 2, 'B2', 'Orientação na Pós-Graduação', 30),
(4, 3, 'C1', 'Produção Científica por Unidade', 120),
(5, 3, 'C2', 'Atividades de Pesquisa', 30),
(6, 3, 'C3', 'Atividades de Divulgação da Produção Científica', 30),
(7, 3, 'C4', 'Produção Técnico-Científica', 30),
(8, 3, 'C5', 'Patente e Registro', 90),
(9, 3, 'C6', 'Produção Artística por Unidade', 60),
(10, 3, 'C7', 'Bancas Examinadoras por Unidade', 30),
(11, 4, 'D1', 'Atividades de Extensão', 30),
(12, 5, 'E1', 'Administração Universitária ou Equivalente', 70),
(13, 5, 'E2', 'Representações Institucionais ou Categorias Universitárias(por semestre)', 12),
(14, 6, 'F1', 'CURSOS (POR SEMESTRE)', 60);

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'auto incrementing user_id of each user, unique index',
  `user_name` varchar(65) NOT NULL COMMENT 'user''s name, unique',
  `user_nome` mediumtext,
  `user_cpf` varchar(11) DEFAULT NULL,
  `user_sexo` varchar(20) DEFAULT NULL,
  `user_nasc` varchar(20) DEFAULT NULL,
  `user_formacao` varchar(30) DEFAULT NULL,
  `user_fone` varchar(20) DEFAULT NULL,
  `user_admissao` varchar(30) DEFAULT NULL,
  `user_cargo` varchar(30) DEFAULT NULL,
  `user_adm` tinyint(1) DEFAULT NULL,
  `user_password_hash` varchar(255) NOT NULL COMMENT 'user''s password in salted and hashed format',
  `user_email` varchar(64) NOT NULL COMMENT 'user''s email, unique',
  `user_active` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'user''s activation status',
  `user_activation_hash` varchar(40) DEFAULT NULL COMMENT 'user''s email verification hash string',
  `user_password_reset_hash` char(40) DEFAULT NULL COMMENT 'user''s password reset code',
  `user_password_reset_timestamp` bigint(20) DEFAULT NULL COMMENT 'timestamp of the password reset request',
  `user_rememberme_token` varchar(64) DEFAULT NULL COMMENT 'user''s remember-me cookie token',
  `user_failed_logins` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'user''s failed login attemps',
  `user_last_failed_login` int(10) DEFAULT NULL COMMENT 'unix timestamp of last failed login attempt',
  `user_registration_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_registration_ip` varchar(39) NOT NULL DEFAULT '0.0.0.0',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_name` (`user_name`),
  UNIQUE KEY `user_email` (`user_email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='user data' AUTO_INCREMENT=64 ;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_nome`, `user_cpf`, `user_sexo`, `user_nasc`, `user_formacao`, `user_fone`, `user_admissao`, `user_cargo`, `user_adm`, `user_password_hash`, `user_email`, `user_active`, `user_activation_hash`, `user_password_reset_hash`, `user_password_reset_timestamp`, `user_rememberme_token`, `user_failed_logins`, `user_last_failed_login`, `user_registration_datetime`, `user_registration_ip`) VALUES
(12, 'stefano', 'Dassaiev Diniz', '11122233300', 'masc', 'data nasc', 'nada', '1233', 'data admissao', 'docente', 1, '$2y$10$lj7Ujg/rv7RRwNJn1a.ogO6TBIpzJyzK.Z8lCyvjQyAadNNQY8bc6', 'stefano@ufma.com', 1, 'b6de5fec7691f585a147dde037dc11a8349640e8', NULL, NULL, NULL, 0, NULL, '2016-01-05 01:24:27', '::1'),
(57, 'anselmo', 'nome', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$FLP5kAxxxjdu161m3vOedeyq7iw18JOM6AK4vm2FvFctDgoL3SClO', 'anselmo@ufma.com', 1, '39f7517db00212d086df8a0aaa1f19a671d5d652', '80cdd0f7ce781380f49aab564843aa7522ef98d3', 1454312563, NULL, 0, NULL, '2016-01-15 15:40:38', '::1'),
(35, 'portela', 'nomeuser20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '$2y$10$wKPKWif4b0235tdbvoUDAOZJvocA428i5zotBht9EL/0zusCK4/1a', 'portela@ufma.com', 1, 'f7f4c3f3fc7f8e0b672b8c7e7d8aca4a87d405e7', NULL, NULL, NULL, 0, NULL, '2016-01-13 03:00:27', '::1'),
(36, 'luciano', 'nomeuser21', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$YbT12M19j5q7RwVqh5l8wOgVRr1vRXYW9JCdKo7Ov7Bybg8cpnJFq', 'luciano@ufma.com', 1, 'a05be85205b38a947672c8a1b6ee434d5f0c55ae', NULL, NULL, NULL, 0, NULL, '2016-01-13 03:15:15', '::1'),
(37, 'mario', 'user2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$tC.a/Oa70VcOBXXMyljNdOh8sLIhrLrHTeP1BZ8HnIjQcaMcTSNlu', 'mario@ufma.com', 1, 'c0f1d2ba47e1be0db6979a4636f45ce3527d9bed', NULL, NULL, NULL, 0, NULL, '2016-01-13 03:22:20', '::1'),
(40, 'salles', '12345678900', '12345678902', 'masculino', NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$sjcDo90MBvLdU.K3.LJNiuA6toeysY4m59m4smQ4DBCnOSWMdvQHm', 'salles@ufma.com', 1, 'd97eed69ef82c35ad67126dc40a4bcd6b2bc33e0', '56dacbfbc1480181e5a9f409e0cd499b693f8313', 1452819682, NULL, 0, NULL, '2016-01-13 04:34:35', '::1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `users_dates`
--

CREATE TABLE IF NOT EXISTS `users_dates` (
  `user_id` int(11) NOT NULL,
  `user_nome` mediumtext,
  `user_cpf` varchar(11) DEFAULT '00000000099',
  `user_sexo` varchar(10) DEFAULT NULL,
  `user_nasc` varchar(20) DEFAULT NULL COMMENT 'data de nascimento',
  `user_formacao` varchar(30) DEFAULT NULL,
  `user_fone` varchar(20) DEFAULT NULL,
  `user_admissao` varchar(20) DEFAULT NULL COMMENT 'data da admissao',
  `user_cargo` varchar(30) DEFAULT NULL COMMENT 'docente?',
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `users_dates`
--

INSERT INTO `users_dates` (`user_id`, `user_nome`, `user_cpf`, `user_sexo`, `user_nasc`, `user_formacao`, `user_fone`, `user_admissao`, `user_cargo`) VALUES
(12, 'Stefano Pontes', '11122233345', 'masc', '03/34/1900', 'alfabetização', '878765443', '01/01/2001', 'docente'),
(35, 'Carlos', '12312312346', 'masculino', '30/11/1960', 'mestrado', '98998988765', '30/11/2001', 'docente'),
(36, 'Luciano Sousa', '27630868707', 'feminino', '30/11/1993', 'Mestrado', '98998988764', '10/10/2000', 'docente'),
(37, 'Mario Meireles', '04495759345', 'masculino', '30/11/1993', 'Graduação', '98984988764', '10/10/2003', 'docente'),
(40, 'Salles Silva', '48827681353', 'feminino', '01/01/1993', 'Graduação', '8888-8885', '01/01/2017', 'docente'),
(57, 'Anselmo Malvado', '12345678900', 'masculino', '01/01/1991', 'Graduação', '8888-8888', 'data', 'Cargo');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
