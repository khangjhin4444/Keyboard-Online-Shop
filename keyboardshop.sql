-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 06, 2025 at 01:22 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `keyboardshop`
--
CREATE DATABASE IF NOT EXISTS `keyboardshop` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `keyboardshop`;

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `AccountName` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `UserID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`AccountName`, `Password`, `UserID`) VALUES
('admin', 'hashedpassword123', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `UserID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`UserID`) VALUES
(2),
(3),
(4);

-- --------------------------------------------------------

--
-- Table structure for table `cartproduct`
--

CREATE TABLE `cartproduct` (
  `UserID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `Color` varchar(50) NOT NULL,
  `Quantity` int(11) NOT NULL CHECK (`Quantity` > 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cartproduct`
--

INSERT INTO `cartproduct` (`UserID`, `ProductID`, `Color`, `Quantity`) VALUES
(3, 10, 'White', 2),
(4, 26, 'Jinx', 4),
(4, 26, 'Yasuo', 2),
(4, 26, 'Yone', 4);

-- --------------------------------------------------------

--
-- Table structure for table `orderproduct`
--

CREATE TABLE `orderproduct` (
  `OrderID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `Color` varchar(50) NOT NULL,
  `Quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orderproduct`
--

INSERT INTO `orderproduct` (`OrderID`, `ProductID`, `Color`, `Quantity`) VALUES
(6, 10, 'Gray', 10),
(6, 18, 'Gray', 3),
(6, 19, 'Red', 4),
(7, 10, 'Gray', 10),
(8, 10, 'Gray', 10),
(9, 10, 'Gray', 10),
(10, 10, 'Gray', 5),
(11, 10, 'Gray', 5),
(13, 41, 'Basic', 7),
(14, 41, 'Basic', 6),
(15, 10, 'Pink', 2);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `OrderID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Time` time NOT NULL,
  `Shipping` enum('Normal','Fast') NOT NULL,
  `Status` enum('Pending','Delivered','Declined','Canceled') NOT NULL,
  `Request` text DEFAULT NULL,
  `Payment` enum('COD','Banking') NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Phone` varchar(20) NOT NULL,
  `Address` text NOT NULL,
  `Total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`OrderID`, `UserID`, `Date`, `Time`, `Shipping`, `Status`, `Request`, `Payment`, `Name`, `Phone`, `Address`, `Total`) VALUES
(6, 2, '2025-04-04', '21:04:00', 'Fast', 'Pending', '', 'COD', 'Khang Nguyen', '0935118607', '497 Hoa Hao', 66670000),
(7, 2, '2025-04-04', '21:06:00', 'Fast', 'Pending', '', 'COD', 'Khang Nguyen', '0935118607', '497 Hoa Hao', 51060000),
(8, 2, '2025-04-04', '21:16:00', 'Fast', 'Pending', '', 'COD', 'Khang Nguyen', '0935118607', '497 Hoa Hao', 51060000),
(9, 2, '2025-04-04', '21:28:00', 'Fast', 'Delivered', '', 'COD', 'Khang Nguyen', '0935118607', '497 Hoa Hao', 51060000),
(10, 3, '2025-04-04', '21:29:00', 'Fast', 'Delivered', '', 'COD', 'user2', '0124343456', '268 Ly Thuong Kiet, district 10, Ho Chi Minh city', 25560000),
(11, 3, '2025-04-04', '21:33:00', 'Fast', 'Declined', '', 'COD', 'user2', '0124343456', '268 Ly Thuong Kiet, district 10, Ho Chi Minh city', 25560000),
(12, 2, '2025-04-06', '12:25:00', 'Fast', 'Declined', '', 'COD', 'Khang Nguyen', '0935118607', '497 Hoa Hao', 181221),
(13, 2, '2025-04-06', '17:19:00', 'Fast', 'Pending', '', 'Banking', 'Khang Nguyen', '0935118607', '497 Hoa Hao', 126500),
(14, 2, '2025-04-06', '17:21:00', 'Fast', 'Canceled', '', 'Banking', 'Khang Nguyen', '0935118607', '497 Hoa Hao', 117000),
(15, 2, '2025-04-06', '17:25:00', 'Fast', 'Canceled', '', 'Banking', 'Khang Nguyen', '0935118607', '497 Hoa Hao', 10260000);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `ProductID` int(11) NOT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `Price` decimal(10,0) DEFAULT NULL,
  `ProductType` enum('Prebuild','KeyboardKit','Keycap','Switch') NOT NULL,
  `Size` varchar(50) DEFAULT NULL,
  `Profile` varchar(50) DEFAULT NULL,
  `Type` varchar(50) DEFAULT NULL,
  `Soundtest` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`ProductID`, `Name`, `Description`, `Price`, `ProductType`, `Size`, `Profile`, `Type`, `Soundtest`) VALUES
(1, 'AULA F75', '- Material: plastic\r\n- Origin: China\r\n- Size: 12.6 x 5.51 x 1.69 inches\r\n- Warranty: 1 month\r\n- Product name: AULA F75\r\n- Layout 75%\r\n- Hotswap 5 pin socket. DOWNTIME\r\n- RGB backlight.\r\n- KEYCAP made of thick and beautiful doubleshot PBT material\r\n- 3 CONNECTION MODES (Bluetooth 5.1, Wireless 2.4G, Type C)\r\n- Supports operating systems: windows, MacOS, Android, IOS\r\n- Switch: Leobog Reaper Shaft (linear); for the black and yellow version, use the Crescent switch (linear)\r\n- The key is already lined with full foam from the manufacturer\r\n- Battery capacity 4000mAh', 840000, 'Prebuild', '75%', NULL, NULL, NULL),
(2, 'RAINY 75 Silver RGB', 'Maker: WOBLAB\r\nLayout: 75%\r\nMounting Style: PCB gasket Mount\r\nTilt angle: 8°\r\nKeycap PBT doubleshot\r\nFull foam\r\nPCB 1.2mm\r\nWeight: ~1.8 kg with 3500mAh battery version, ~2kg with 7000mAh battery version\r\nWarranty 1 month', 2300000, 'Prebuild', '75%', NULL, NULL, NULL),
(3, 'Furycube F75', '- Material: aluminum shell\r\n- Dimensions: 18 x 8 x 5 inches\r\n- Origin: China\r\n- Warranty: 1 month', 1200000, 'Prebuild', '75%', NULL, NULL, NULL),
(4, 'Weikav RO75', '- Material: 6063 aluminum case.\r\n- Anodized surface\r\n- Size: 75% layout\r\n- Foam: PORON sandwich cotton + 8 times IXPE shaft pad + PORON shaft seat cotton\r\n- Connection: 1 Mode Type C\r\n- PCB: 1.2mm Flex Cut\r\n- Plate: PC\r\n- Hotswap\r\n- Structure: Leaf-Spring structure\r\n- Support QMK / VIA\r\n- Weight 1.60kg\r\n- Accessories: Keypuller, switch puller, User manual...\r\n- Origin: China\r\n- Warranty: 1 month', 1700000, 'Prebuild', '75%', NULL, NULL, NULL),
(5, 'Chilkey ND75', '- Material: aluminum\r\n- Dimensions: 32 x 14 x 4cm\r\n- Origin: China\r\n- Warranty: 6 months\r\n\r\nSpecifications:\r\n- Layout 75% - Typing Angle: 6.5° - Front Height: 19.2mm\r\n- Case material: CNC Aluminum\r\n- Case surface:\r\n + Electrophoretic - Pure White\r\n + Anodized - Jet Black, Mountain Blue, Elegant Purple\r\n- Plate: Polycarbonate\r\n- PCB: Tri-mode, Per-key RGB, Hot-swappable\r\n- Screwless Quick Assembly System (Catchball, Magnetic connection)\r\n- Mounting Style:\r\n- O-Ring\r\n- Silica Gel\r\n- Top Mount\r\n- Stabilizer Mounting Style: Plate Mount\r\n- Support: Independent Driver / Software\r\n- Switch: WS Dopamine Blue\r\n- Keycaps: Doubleshot PBT Keycap (Cherry Profile)\r\n- 3600mAh battery', 1900000, 'Prebuild', '75%', NULL, NULL, NULL),
(6, 'Xinmeng M75', 'Product information:\r\n- Material: plastic\r\n- Size: 75% layout\r\n- Origin: China\r\n- Warranty: 1 month\r\n\r\nSpecifications:\r\n- M75 (regular): No screen, with knob\r\n- M75 Pro: With screen, with knob\r\n- Case: Plastic\r\n- Connection: 3 modes (Wired, Bluetooth, 2.4G)\r\n- 75% layout\r\n- Structure: Gasket Leaf Spring\r\n- Foam lining of all kinds\r\n- Plate: PC\r\n- PCB: 1.2mm Hotswap, Led RGB per key\r\n- Battery capacity: 5000mAh\r\n- Size: 32.6cmx15.2cmx2cm\r\n- Keymap: By Driver\r\n- Support: Mac/WIN\r\n- Color: White - Keycap Regular, White - Keycap Ninja, Purple - Keycap Ninja\r\n- Keycap: PBT - Profile Cherry\r\n\r\n- Product set includes: Keyboard, cable, Switch/Key Puller, Dust cover, User manual.\r\n\r\n-Warranty: 1 month', 890000, 'Prebuild', '75%', NULL, NULL, NULL),
(7, 'Keydous NJ81', '- Model: NJ80. Layout 81 with SCREEN\n- Dimensions: 325*141*42mm. Weight ~ 1.1kg\n- Color:\n+ Case color: White | Smoke |\n+ Keycap color: Moonlight | Cinnabar\n- Plate: Steel | Copper\n- 3-mode connection: Type C - Bluetooth 5.0 (3 devices) - Receiver 2.4G\n- Support NKRO / Multimedia / Macro / Windows key lock\n- RGB Led\n- Switch stock: Kailh Box White (Clicky) / Red (Linear) / Brown (Tactile).\n- Downstream circuit. Hotswap module Kailh 5 pin hot swap switch. Compatible with most standard switches (cherry, kailh, gateron and the same types) on the market\n- 5000mAh battery is strong and durable.\n- Accessories: User manual + 01 Type C cable + Switch: + 2.4G receiver + Additional keycap for Macbook - MacOS - Compatible: Windows / MacOS / Linux (With separate driver to adjust LED / Macro / Update firmware / Keymap)', 1800000, 'KeyboardKit', '75%', NULL, NULL, NULL),
(8, 'FL-CMK75', '- Manufacturer: FL- Esport\r\n- Layout: 82 keys\r\n- Connection: 3 modes\r\n- RGB Led\r\n- Hotswap\r\n- Foam: Full foam switch\r\n- Stab Plate mount\r\n- PC Plate\r\n- Dimensions: 339.5x155x45.5mm\r\n- Origin: China\r\n', 1950000, 'Prebuild', '75%', NULL, NULL, NULL),
(9, 'Monsgeek M1 V5 SP ', '- Warranty: 1 month\r\n- Size: 33.2cm*14.7cm*3.3cm\r\n- Origin: China\r\n- Material: CNC aluminum case\r\n- PC plate, Gasket Mount\r\n- Trendy catchball mechanism\r\n- PCB 3-Modes, RGB, Hotswap forward circuit\r\n- PBT keycap\r\n- Switch: AKKO CS Piano V3 Pro\r\n- VIA support', 2100000, 'Prebuild', '75%', NULL, NULL, NULL),
(10, 'Zoom75 Tiga', '- Material: aluminum- Origin: China- Size: 32.4cm x 14.6cm x 3.4cm- Warranty: 1 month', 5100000, 'KeyboardKit', '75%', 'null', 'null', 'null'),
(11, 'Aula F99 Pro', '- Material: plastic\r\n- Origin: China\r\n- Dimensions: 5.78 x 1.67 x 15.38 inches\r\n- Warranty: 1 month\r\n- Key durability: 60 million keystrokes\r\n- Connection: 3 modes (Type-C/Wireless/Bluetooth)\r\n- Backlight: RGB LED - 16 types of lighting effects\r\n- Switch type: Purple Emperor - Linear\r\n- Hot swap - Gasket mount\r\n- Number of keys: 99 keys\r\n- Keycap material: PBT plastic\r\n- Reverse circuit\r\n- Weight: About 1000g\r\n- Accessories included: User manual + 2 free switches + USB type-C cable + Keycap replacement tool', 1500000, 'Prebuild', 'Full Size', NULL, NULL, NULL),
(12, 'Yunzii IF99', '- Layout 98\r\n- Number of buttons: 95\r\n- Case: Plastic\r\n- Mounting type: Gasket Mount\r\n- 3 connection modes: 2.4G/ Wireless/ Blutooth\r\n- Hotswap 5 pin\r\n- PCB: With RGB LED, forward circuit\r\n- Plate PC\r\n- Stab: Plate mount\r\n- 2 Linear Switch options: Gateron Zero and CoCoa Cream V2\r\n- Support QMK/ VIA\r\n- Trendy LCD screen and Badge\r\n- Keycap: Profile Cherry\r\nPBT Doubleshot\r\n- 8000mAh battery\r\n- Warranty: 6 months\r\n', 1800000, 'Prebuild', 'Full Size', NULL, NULL, NULL),
(13, 'Furycube E68', '- Material: Aluminum Case\r\n- Size: 33.3cm*14.6cm*3.26cm\r\n- Surface: Nano Coated\r\n- Switch: HMX Citrus Grape. Keycap Cherry Profile\r\n- PCB: 1.2mm Flex Cut, Hotswap, Reverse Circuit, RGB, 1 mode or 3 modes\r\n- Support VIA keymap\r\n- Origin: China\r\n- Warranty: 6 months', 1200000, 'Prebuild', '75%', NULL, NULL, NULL),
(14, 'TKD PT.1/75 Keyboard Kit', '- Product name: pt.1/75;\n- Dimensions: 314.5*137.3*35.0mm;\n- Material: aluminum/copper/steel\n- Origin: China\n- Warranty: 1 month\n\n- PROJECT NAME: pt.1/75;\n- LAYOUT: 75%;\n- SIZE: 314.5*137.3*35.0mm;\n- FRONG HEIGHT: 17.00mm/EKH=21.35mm (without bumpons);\n- MOUNTING: top mount (only), non O-ring support;\n- WEIGHT: 2.05kg (unbuild, with SS weight)/2.45kg (built with Alu plate and SS weight);\n- MATERIALS: aluminum/brass/steel;\n- PCB: FR4, 1.6mm, non flex cuts;\n- FIRMWARE: QMK/VIA only, non VIAL support.\n', 5890000, 'KeyboardKit', '75%', NULL, NULL, NULL),
(15, 'Stars75 Keyboard', '- CNC Alu Case\r\n- 1.2mm Flexcut PCB, Hotswap, RGB Led, 3 Modes, Downstream Circuit\r\n- Leafspring mount.\r\n- FR4 Plate supports stab Platemount\r\n- Crystal weight with Receiver holder\r\n- VIA Keymap.\r\n- 8000Mah Battery\r\n- Weight: 1.7kg\r\n- Cherry PBT Dyesub / Through led keycap', 1500000, 'Prebuild', '75%', NULL, NULL, NULL),
(16, 'D75 Keyboard Kit', '- CNC Alu Case\r\n- Gasket Mount\r\n- FR4 Plate, supports stab Platemount\r\n- 1.2mm Flexcut PCB, hotswap, 3 modes, factory app\r\n- Ball catch system\r\n- 4000mah battery\r\n- 5 Foam Set\r\n', 950000, 'KeyboardKit', '75%', NULL, NULL, NULL),
(17, 'TN75s R3 Keyboard Kit', '- Alu CNC case\r\n- Leaf Spring Gasket Mount\r\n- Ball Catch is quick to install and remove\r\n- Plate PC supports stab Platemount\r\n- PCB 1.2mm Flexcut RGB, Hotswap, 3 Modes, VIA\r\n- Set of 4 foams\r\n- 7500mah battery', 2800000, 'KeyboardKit', '75%', NULL, NULL, NULL),
(18, 'Raw Nook 75% Keyboard Kit', '- Case Alu 6063\r\n- Gasket Mount\r\n- PCB 1.2mm, HS, Non Cut, RGB, VIA, DBT\r\n- Set of 4 Foam (Foam PCB, Foam IXPE, Foam Case x2)\r\n- Free Keyboard Bag + Screwdriver Set\r\n- Plate PC (Extra: Alu/FR4/POM) supports stab PCB Mount', 3870000, 'KeyboardKit', '75%', NULL, NULL, NULL),
(19, 'Lucky65 v2 Keyboard Kit', '- Case Alu 6063\r\n- Plate FR4, stab platemount\r\n- PCB 1.2mm Flexcut, Hotswap, 3 Modes, Led RGB, QMK/VIA\r\n- 3750mah battery\r\n- PCB Gasket Mount\r\n- Quick disassembly and installation of Ball Catch\r\n- Weight 1.2kg\r\n- Color:\r\n+ Anode: Black, Silver, Red, Green, Purple\r\n+ E-Coating: Milky White\r\n- Ta Anode Gold, Crystal Silver, Crystal Black\r\n- Set of 5 Foam\r\n- Dimensions: 326*115*33mm', 1000000, 'KeyboardKit', '75%', NULL, NULL, NULL),
(20, 'HavenTKL Keyboard Kit', '- Gasket Mount\n- Layout WK/WKL\n- Plate Alu Non Cut\n- PCB 1.2mm, Non Cut, VIA\n- Set of 3 Foams\n- Comes with Artisan Metal Keycap', 13580000, 'KeyboardKit', 'TKL', NULL, NULL, NULL),
(21, 'Fly65 Keyboard Kit', 'Case Material: Aluminum\r\nMounting Structure: Gasket Mount\r\nVIA Support: Yes\r\nConnectivity: Wired or Tri-mode\r\nAnti-Ghosting: NKRO\r\nPolling Rate: 1000Hz (Wired/2.4GHz), 125Hz (Bluetooth)\r\nBattery: 3600mAh\r\nWeight: 1.5kg', 4000000, 'KeyboardKit', '75%', NULL, NULL, NULL),
(22, 'TB8-TKL Keyboard Kit', '- Case Alu\r\n- Alu / SS / Brass (Water Ripple / PVD / Brilliance)\r\n- Layout TKL F13 WK/WKL\r\n- Gasket/Top Mount\r\n- Plate PC/FR4/Alu Flexcut, Alu Noncut, support stab pcbmount\r\n- Ball Catch mechanism for easy disassembly\r\n- PCB supports VIA\r\n+1.6mm Noncut/1.2mm Flexcut RGB\r\n+ 1/3 Modes\r\n+ Hotswap/Solder\r\n- Weight 2.4kg\r\n- Tilt 7', 4600000, 'KeyboardKit', 'TKL', NULL, NULL, NULL),
(23, 'Monka Alice 67 Pro Keyboard Kit', '- Case Alu\n- Plate PC\n- Gasket Mount\n- PCB HS, RGB, 3 Modes, Downstream, Keymap app manufacturer\n- 4k Battery\n- Stab Platemount', 1400000, 'KeyboardKit', 'Alice', NULL, NULL, NULL),
(24, '80Retros Game 1989 Keyboard Kit', '- Material: Aluminum 6061\r\n- Processing method: CNC\r\n- Color: Powder Spraying Technology\r\n- Components: TOP – BOT – MID Frame – Decorative red dots – Decorative strips on both sides and back – Interface decoration block\r\n- Dimensions ~ 391x140x44 mm\r\n- Front height: 22mm\r\n- Back height: 34mm\r\n- Slope: 6 degrees\r\n- Weight: ~ 2.1kg (excluding switch and keycap) ~ 2.6kg (including switch and keycap)\r\n- USB Type-C 2 Type-A (1 mode) connection\r\n- Hotswap 5 pin, South-Facing circuit, QMK support\r\n- Structure: Gasket-mount (Silicone) / Top-mount\r\n- 1.2mm black PCBA with gold plating, Flex-cut each key, ANSI layout\r\n- 1.5mm black FR4 plate, gold plated, with horizontal grooves\r\n- Plate Foam INOAC Poron 3.5mm / Case Foam Rogers Poron 1.5mm\r\n- Switch pad IXPE 0.5mm\r\n- Accessories: Connecting cable, screws, foot pad, plate-mount stab kit, Top-mount screws, silicone gasket with hardness 25/35', 5400000, 'KeyboardKit', 'TKL', NULL, NULL, NULL),
(25, 'Keycap Artisan Lobo Demon Slayer\n', '- Material: Resin\r\n- Origin: China\r\n- Size: 1U', 139000, 'Keycap', NULL, 'Artisan', NULL, NULL),
(26, 'Keycap Lobo Artisan League Of Legends', '- Material: Resin\r\n- Origin: China\r\n- Size: 1U', 139000, 'Keycap', NULL, 'Artisan', NULL, NULL),
(27, 'Keycap Lobo Artisan VALORANT Gekko\'s Pet', '- Material: Resin\r\n- Origin: China\r\n- Size: 1U', 139000, 'Keycap', NULL, 'Artisan', NULL, NULL),
(28, 'Keycap Walker Cherry Retro100 PBT Dyesub', '- Profile: Cherry- Legend: Dyesub Print- Material: PBT', 590000, 'Keycap', NULL, 'Cherry', NULL, NULL),
(29, 'Keycap Cherry Retro Dark Light PBT Dyesub', '- Profile: Cherry- Legend: Dyesub Print- Material: PBT', 520000, 'Keycap', NULL, 'Cherry', NULL, NULL),
(30, 'Keycap GMK Fright Club Cherry Profile', '- Profile: Cherry- Print : Double Shot- Material: 1.5mm ABS- Manufacture: GMK', 2150000, 'Keycap', NULL, 'Cherry', NULL, NULL),
(31, 'Keycap Cherry Aifei Error 404 PBT Dyesub', '- Profile: Cherry\r\n- Print : Dyesub\r\n- Material: PBT\r\n- Amount: 137 keys', 430000, 'Keycap', NULL, 'Cherry', NULL, NULL),
(32, 'Keycap Cherry Aifei Pyga Jinyu Semi-Transparent ABS Doubleshot', '- Profile: Cherry\r\n- Print : Double Shot\r\n- Material: PBT', 290000, 'Keycap', NULL, 'Cherry', NULL, NULL),
(33, 'Keycap MDA Meow meow', '- Profile: MDA- Print : Dyesub- Material: PBT', 450000, 'Keycap', NULL, 'MDA', NULL, NULL),
(34, 'Set Keycap MDA Virtual War 141', '- Profile: MDA- Print : Dyesub- Material: PBT', 790000, 'Keycap', NULL, 'MDA', NULL, NULL),
(35, 'Keycap Honey Bee MDA PBT Dyesub', '- Profile: MDA- Print : Dyesub- Material: PBT', 600000, 'Keycap', NULL, 'MDA', NULL, NULL),
(36, 'Keycap Shiba PBT Dyesub', '- Profile: MDA\r\n- Print : Dyesub\r\n- Material: PBT', 600000, 'Keycap', NULL, 'MDA', NULL, NULL),
(37, 'Set Keycap PBT SA Control Code', '- Profile: SA\r\n- Print : Dyesub\r\n- Material: PBT', 1500000, 'Keycap', NULL, 'SA', NULL, NULL),
(41, 'Switch Linear SWK Catmint', '\r\n- Switch Type: Linear (5 pin)\r\n- Material: Top - Nylon, Bottom - Nylon, Stem - Pok\r\n- Spring: 20mm long, Bottom out force 58gr\r\n- Travel: 3.5mm\r\n- Pre-Travel: 2.0mm\r\n- Factory Lube: Yes\r\n- Manufacturer: SWK (Swagkeys)', 9500, 'Switch', 'null', 'null', 'Linear', 'https://www.youtube.com/watch?v=7fO9bT5WI1I'),
(42, 'Switch Linear Gateron Oil King', '- Top housiing: PA66 (Nylon) opaque black\r\n- Bot housing: Black ink material\r\n- Body: POM matte black\r\n- Switch type: Linear\r\n- Spring: 22mm black coating\r\n- Actuation force: 55g\r\n- Bottom out force: 80g\r\n- Pre-Lubed from factory\r\n- 5Pin PCB Mount', 12000, 'Switch', 'null', 'null', 'Linear', 'https://www.youtube.com/watch?v=5W0co2UaB6E'),
(44, 'Switch Linear SP-Star Meteor White', 'Specifications: \r\n\r\n- Switch type: Linear - 5 Pin\r\n\r\n- Stem: POM\r\n\r\n- Top: Nylon | Bottom: Nylon\r\n\r\n- Press force 57g - Yellow spring\r\n\r\n- Lightly lubed from manufacturer\r\n\r\n- Material: plastic\r\n\r\n- Origin: China\r\n\r\n- Warranty: No', 8500, 'Switch', 'null', 'null', 'Linear', 'https://www.youtube.com/watch?v=lQOK2K4-aeY'),
(45, 'Switch WS Bean Green Tactile', 'Product information:\r\n\r\n- Material: plastic\r\n\r\n- Origin: China\r\n\r\n- Warranty: No\r\n\r\n+ Type: Tactile\r\n+ Stroke: 3.5 +/- 0.3mm\r\n+ Bottom out force: 45gr\r\n+ Spring: 2 layers 22mm\r\n+ Factory lubed: Yes\r\n+ Top Housing: POM / Fluorescent Green\r\n+ Bot Housing: POM / Fluorescent Green\r\n+ Stem: UPE / Light Pink', 7500, 'Switch', 'null', 'null', 'Tactile', 'https://www.youtube.com/watch?v=WY36UuNmboI'),
(46, 'Switch Clicky Gateron Melodic', '- Type: Clicky\r\n- Operation Force:60±12gf\r\n- Pre-Travel: 2.0±0.6mm\r\n- Total Travel: 4mm Max\r\n- Stem:POM, Light Pink\r\n- Top Housing: PC\r\n- Bottom Housing: Nylon,Light Blue\r\n- LED Support：SMD​\r\n- Pre-lubed: Yes\r\n- Pins: 5-Pin', 13000, 'Switch', 'null', 'null', 'Clicky', 'https://www.youtube.com/watch?v=v8wRTaw7GH4'),
(47, 'Switch Tactile Akko Creamy Purple Pro', 'Basic Specifications:\r\n\r\nSwitch Type: Tactile\r\n\r\nMaterial: nylon pro/pc/pa\r\n\r\nOperating Force: 30 ± 5gf\r\n\r\nTactile Travel: 0.5mm\r\n\r\nTotal Travel: 3.3mm\r\n\r\nPre-Travel: 2.0 ± 0.6mm\r\n\r\nPressing Force: 55gf ± 5gf', 5000, 'Switch', 'null', 'null', 'Tactile', 'https://www.youtube.com/watch?v=MgYZjZMPIgI'),
(48, 'Switch WS Light Tactile', 'Type: Tactile \r\nTop Housing Material: PC\r\nBottom Housing Material: Nylon\r\nStem Material: POM\r\nTotal travel: 4mm\r\nSpring length: L=15.4mm\r\nFactory lubed: Yes', 7500, 'Switch', 'null', 'null', 'Tactile', 'https://www.youtube.com/watch?v=RnKZi5DTHoM'),
(49, 'Switch Outemu Silent v3', 'Specifications:\r\n+ Type: Silent Linear (Peach) and Silent Tactile (Lime)\r\n+ Color: Pink (Peach) or Blue (Lime)\r\n+ 5 batteries\r\n+ Press force: 45g (Peach) or 50g (Lime)\r\n+ Travel: 3.3mm\r\n+ Durability: 50 million presses\r\n+ Quantity: 1 switch\r\n+ With LED diffuser', 4000, 'Switch', 'null', 'null', 'Silent', 'https://www.youtube.com/watch?v=jZVp8JfrJVw');

-- --------------------------------------------------------

--
-- Table structure for table `productvariant`
--

CREATE TABLE `productvariant` (
  `ProductID` int(11) NOT NULL,
  `Color` varchar(50) NOT NULL,
  `Image` varchar(255) NOT NULL,
  `stock` int(11) DEFAULT 20
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `productvariant`
--

INSERT INTO `productvariant` (`ProductID`, `Color`, `Image`, `stock`) VALUES
(1, 'Black', 'variant-images/aulaf75black.webp', 20),
(1, 'Blue', 'variant-images/aulaf75blue.webp', 20),
(1, 'White', 'variant-images/aulaf75white.webp', 20),
(2, 'Black', 'variant-images/rainy75black.webp', 20),
(2, 'Creamy', 'variant-images/rainy75creamy.webp', 20),
(2, 'Red', 'variant-images/rainy75red.webp', 20),
(2, 'Silver', 'variant-images/rainy75silver.webp', 20),
(3, 'Blue', 'variant-images/furycubef75blue.webp', 20),
(3, 'Cheese', 'variant-images/furycubef75cheese.webp', 20),
(3, 'Pink', 'variant-images/furycubef75pink.png', 20),
(3, 'Silver', 'variant-images/furycubef75silver.webp', 20),
(3, 'White', 'variant-images/furycubef75white.webp', 20),
(4, 'Caramel', 'variant-images/weikavro75caramel.jpg', 20),
(4, 'Silver', 'variant-images/weikavro75silver.webp', 20),
(5, 'Blue', 'variant-images/nd75blue.webp', 20),
(5, 'Purple', 'variant-images/nd75purple.webp', 20),
(6, 'Purple', 'variant-images/xinmengm75purple.webp', 20),
(6, 'White', 'variant-images/xinmengm75white.webp', 20),
(7, 'Smoke', 'variant-images/nj81smoke.webp', 20),
(8, 'Black', 'variant-images/flcmk75black.webp', 20),
(8, 'White', 'variant-images/flcmk75white.webp', 20),
(9, 'Black', 'variant-images/m1wblack.webp', 20),
(9, 'White', 'variant-images/m1wwhite.webp', 20),
(10, 'Aquamarine', 'variant-images/zoom75tigaaquamarine.webp', 10),
(10, 'Gray', 'variant-images/zoom75tigagray.webp', 20),
(10, 'Pink', 'variant-images/zoom75tigaPink.webp', 13),
(10, 'Red', 'variant-images/zoom75tigared.webp', 20),
(10, 'White', 'variant-images/zoom75tigawhite.webp', 2),
(11, 'Black', 'variant-images/aulaf99pro.webp', 20),
(12, 'Black', 'variant-images/yunziiif99black.webp', 20),
(12, 'White', 'variant-images/yunziiif99white.webp', 20),
(13, 'Black', 'variant-images/furycubee68black.webp', 20),
(13, 'White', 'variant-images/furycubee68white.webp', 20),
(14, 'Canvas', 'variant-images/tkd75canvas.webp', 20),
(14, 'Lunar', 'variant-images/tkd75lunar.webp', 20),
(15, 'Black', 'variant-images/stars75black.jpg', 20),
(15, 'Purple', 'variant-images/stars75purple.jpg', 20),
(15, 'Red', 'variant-images/stars75red.jpg', 20),
(16, 'Black', 'variant-images/d75black.jpg', 20),
(16, 'Purple', 'variant-images/d75purple.jpg', 20),
(16, 'Red', 'variant-images/d75red.jpg', 20),
(16, 'White', 'variant-images/d75white.jpg', 20),
(17, 'Purple', 'variant-images/tn75purple.jpg', 20),
(17, 'Red', 'variant-images/tn75red.jpg', 20),
(17, 'Tiffany', 'variant-images/tn75tiffany.jpg', 20),
(17, 'Yello', 'variant-images/tn75yellow.jpg', 20),
(18, 'Gray', 'variant-images/nook75gray.webp', 20),
(19, 'Black', 'variant-images/lucky65black.webp', 20),
(19, 'Milky White', 'variant-images/lucky65milkywhite.jpg', 20),
(19, 'Red', 'variant-images/lucky65red.jpg', 20),
(20, 'Red', 'variant-images/haventklred.webp', 20),
(20, 'Silver', 'variant-images/haventklsilver.jpg', 20),
(21, 'Black Gold', 'variant-images/fly65blackgold.jpg', 20),
(21, 'Light Gold', 'variant-images/fly65lightgold.jpg', 20),
(21, 'White Gold', 'variant-images/fly65whitegold.jpg', 20),
(22, 'Black', 'variant-images/tb8black.jpg', 20),
(22, 'Gray', 'variant-images/tb8gray.jpg', 20),
(22, 'Green', 'variant-images/tb8green.jpeg', 20),
(22, 'Red', 'variant-images/tb8red.jpeg', 20),
(23, 'Blue', 'variant-images/monkaa67problue.jpg', 20),
(23, 'Pink', 'variant-images/monkaa67propink.jpg', 20),
(23, 'White', 'variant-images/monkaa67prowhite.jpg', 20),
(24, 'White', 'variant-images/80retroswhite.jpg', 20),
(25, 'Inosuke', 'variant-images/lobodemoninosuke.webp', 20),
(25, 'Nezuko', 'variant-images/lobodemonnezuko.webp', 20),
(25, 'Tanjirou', 'variant-images/lobodemontanjirou.webp', 20),
(25, 'Zenitsu', 'variant-images/lobodemonzenitsu.webp', 20),
(26, 'Jinx', 'variant-images/lobololjinx.webp', 20),
(26, 'Seraphine', 'variant-images/lobololseraphine.webp', 20),
(26, 'Yasuo', 'variant-images/lobololyasuo.webp', 20),
(26, 'Yone', 'variant-images/lobololyone.jpg', 20),
(27, 'Dizzy', 'variant-images/lobogekkodizzy.jpg', 20),
(27, 'Gekko squad', 'variant-images/lobogekkosquad.jpg', 20),
(27, 'Mosh Pit', 'variant-images/lobogekkomoshpit.jpg', 20),
(27, 'Thrash', 'variant-images/lobogekkothrash.jpg', 20),
(27, 'Wingman', 'variant-images/lobogekkowingman.jpg', 20),
(28, 'Basic', 'variant-images/cherryretro100-1.webp', 10),
(28, 'Basic', 'variant-images/cherryretro100-2.webp', 10),
(28, 'Basic', 'variant-images/cherryretro100-3.webp', 10),
(28, 'Basic', 'variant-images/cherryretro100-4.webp', 10),
(28, 'Basic', 'variant-images/cherryretro100-5.webp', 10),
(29, 'Basic', 'variant-images/retrodarklight-1.webp', 20),
(29, 'Basic', 'variant-images/retrodarklight-2.webp', 20),
(29, 'Basic', 'variant-images/retrodarklight-3.webp', 20),
(29, 'Basic', 'variant-images/retrodarklight-4.webp', 20),
(30, 'Basic', 'variant-images/gmkfrightclub-1.webp', 19),
(30, 'Basic', 'variant-images/gmkfrightclub-2.webp', 19),
(30, 'Basic', 'variant-images/gmkfrightclub-3.webp', 19),
(30, 'Basic', 'variant-images/gmkfrightclub-4.webp', 19),
(30, 'Basic', 'variant-images/gmkfrightclub-5.webp', 19),
(31, 'Basic', 'variant-images/aifeierror404-1.webp', 10),
(31, 'Basic', 'variant-images/aifeierror404-2.webp', 10),
(31, 'Basic', 'variant-images/aifeierror404-3.webp', 10),
(31, 'Basic', 'variant-images/aifeierror404-4.webp', 10),
(31, 'Basic', 'variant-images/aifeierror404-5.webp', 10),
(32, 'Basic', 'variant-images/aifeipygajinyu-1.webp', 10),
(32, 'Basic', 'variant-images/aifeipygajinyu-2.webp', 10),
(32, 'Basic', 'variant-images/aifeipygajinyu-3.webp', 10),
(32, 'Basic', 'variant-images/aifeipygajinyu-4.webp', 10),
(32, 'Basic', 'variant-images/aifeipygajinyu-5.webp', 10),
(33, 'Basic', 'variant-images/mdameowmeow-1.webp', 5),
(33, 'Basic', 'variant-images/mdameowmeow-2.jpg', 5),
(33, 'Basic', 'variant-images/mdameowmeow-3.webp', 5),
(33, 'Basic', 'variant-images/mdameowmeow-4.webp', 5),
(33, 'Basic', 'variant-images/mdameowmeow-5.webp', 5),
(34, 'Basic', 'variant-images/mdavirtualwar-1.jpg', 20),
(34, 'Basic', 'variant-images/mdavirtualwar-2.jpg', 20),
(34, 'Basic', 'variant-images/mdavirtualwar-3.jpg', 20),
(35, 'Basic', 'variant-images/mdabeevil-1.jpg', 20),
(35, 'Basic', 'variant-images/mdabeevil-2.jpg', 20),
(35, 'Basic', 'variant-images/mdabeevil-3.jpg', 20),
(35, 'Basic', 'variant-images/mdabeevil-4.jpg', 20),
(36, 'Basic', 'variant-images/mdashiba-1.jpg', 20),
(36, 'Basic', 'variant-images/mdashiba-2.jpg', 20),
(36, 'Basic', 'variant-images/mdashiba-3.jpg', 20),
(36, 'Basic', 'variant-images/mdashiba-4.jpg', 20),
(37, 'Basic', 'variant-images/sacontrolcode-1.jpg', 20),
(37, 'Basic', 'variant-images/sacontrolcode-2.jpg', 20),
(37, 'Basic', 'variant-images/sacontrolcode-3.jpg', 20),
(37, 'Basic', 'variant-images/sacontrolcode-4.jpg', 20),
(41, 'Basic', 'variant-images/102902013552764125-580931491-128-1704355881710.webp', 37),
(41, 'Basic', 'variant-images/102902020003195674-728283824-128.webp', 37),
(41, 'Basic', 'variant-images/102902020228654712-353505977-128.webp', 37),
(41, 'Basic', 'variant-images/102902020546994557-822128055-128.webp', 37),
(42, 'Basic', 'variant-images/sg-11134201-22100-6r7s44m7pxiv1a-1673783486587-1677402136824.webp', 100),
(42, 'Basic', 'variant-images/sg-11134201-22100-6z9v21m7pxivc2-1673783486587-1677402137929.webp', 100),
(42, 'Basic', 'variant-images/sg-11134201-22100-g65xcon7pxiv20-1673783486587-1677402138566.webp', 100),
(42, 'Basic', 'variant-images/sg-11134201-22100-gh3jd0m7pxiv17-1673783486587-1677402139392.webp', 100),
(44, 'Basic', 'variant-images/1-1672740373924.png', 100),
(44, 'Basic', 'variant-images/2-1672740373932.webp', 100),
(44, 'Basic', 'variant-images/3-1672740373940.webp', 100),
(44, 'Basic', 'variant-images/4-1672740373950.webp', 100),
(44, 'Basic', 'variant-images/5-1672740373958.webp', 100),
(45, 'Basic', 'variant-images/34-q4faqr8.webp', 100),
(45, 'Basic', 'variant-images/37-e3yxxqy.webp', 100),
(45, 'Basic', 'variant-images/screenshot-2023-12-15-174239.webp', 100),
(46, 'Basic', 'variant-images/1-c1c956c7-86ef-4174-b459-d97f7eb9b52b.webp', 100),
(47, 'Basic', 'variant-images/800.webp', 100),
(47, 'Basic', 'variant-images/creamy-purple-pro.webp', 100),
(47, 'Basic', 'variant-images/sku-08bb0343-b334-4b98-99c8-05a56c80cfa7.jpg', 100),
(48, 'Basic', 'variant-images/dsc00736.webp', 100),
(48, 'Basic', 'variant-images/dsc00740.png', 100),
(48, 'Basic', 'variant-images/dsc00755.png', 100),
(48, 'Basic', 'variant-images/light-tactile.webp', 100),
(49, 'Lime V3', 'variant-images/s2dd85b8a4e584d80a59e7aa3d4fa284-1722843041257.webp', 50),
(49, 'Peach V3', 'variant-images/sb2ce5ace83f94622b191adb0dca9f53-1722570659450.jpg', 100),
(49, 'Peach V3', 'variant-images/sb759f55b0f92495a8215efa009582ae-1722570659448.webp', 100);

--
-- Triggers `productvariant`
--
DELIMITER $$
CREATE TRIGGER `update_cartproduct_after_productvariant_update` AFTER UPDATE ON `productvariant` FOR EACH ROW BEGIN
  -- Kiểm tra nếu có sự thay đổi về Color hoặc stock
  IF OLD.Color != NEW.Color OR OLD.stock != NEW.stock THEN
    -- Cập nhật cartproduct nếu Quantity trong cart lớn hơn stock, và thay đổi color nếu có
    UPDATE cartproduct
    SET
      Quantity = CASE
        WHEN cartproduct.Quantity > NEW.stock THEN NEW.stock
        ELSE cartproduct.Quantity
      END,
      Color = CASE
        WHEN OLD.Color != NEW.Color THEN NEW.Color
        ELSE cartproduct.Color
      END
    WHERE cartproduct.ProductID = NEW.ProductID
    AND cartproduct.Color = OLD.Color; -- Cập nhật chỉ với bản ghi có Color cũ
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `UserID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `Phone` varchar(20) DEFAULT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserID`, `Name`, `Address`, `Phone`, `username`, `password`) VALUES
(1, 'Khang Nguyễn', '497 Hòa Hảo, phường 7, quận 10, TP.HCM', '0123456789', 'admin', '$2y$10$45.EtBYhAHnTNVjBIJR8DOu5u8HKyyWXUwl567dqdlVGhZ1tyuhhO'),
(2, 'Khang Nguyen', '497 Hoa Hao', '0935118607', 'User1', '$2y$10$45.EtBYhAHnTNVjBIJR8DOu5u8HKyyWXUwl567dqdlVGhZ1tyuhhO'),
(3, 'user2', '268 Ly Thuong Kiet, district 10, Ho Chi Minh city', '0124343456', 'user2', '$2y$10$SNM46T/AyGNeYrHvB.3zye4Nzr5nV7Y3bKJ8TZ0pXEkCcf3ydjxu.'),
(4, 'Hanh Nguyen', '497 Hoa Hao', '0888610401', 'User3', '$2y$10$TdPum73lcZFoZTd049v2o.22IVV1yCp/1Hj2vbg5SzNzJLbndwkRG');

--
-- Triggers `user`
--
DELIMITER $$
CREATE TRIGGER `after_user_insert` AFTER INSERT ON `user` FOR EACH ROW BEGIN
    INSERT INTO cart (UserID) VALUES (NEW.UserID);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `user_tokens`
--

CREATE TABLE `user_tokens` (
  `id` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_tokens`
--

INSERT INTO `user_tokens` (`id`, `userID`, `token`, `expires_at`) VALUES
(14, 2, '4d7a9491251b7ef6529b02e7983e178b39533b7fa1087f717ed2a010369a3716', '2025-04-13 13:17:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`AccountName`),
  ADD UNIQUE KEY `unique_accountname` (`AccountName`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`UserID`);

--
-- Indexes for table `cartproduct`
--
ALTER TABLE `cartproduct`
  ADD PRIMARY KEY (`UserID`,`ProductID`,`Color`),
  ADD KEY `ProductID` (`ProductID`,`Color`);

--
-- Indexes for table `orderproduct`
--
ALTER TABLE `orderproduct`
  ADD PRIMARY KEY (`OrderID`,`ProductID`,`Color`),
  ADD KEY `ProductID` (`ProductID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`OrderID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`ProductID`),
  ADD UNIQUE KEY `unique_product_name` (`Name`);

--
-- Indexes for table `productvariant`
--
ALTER TABLE `productvariant`
  ADD PRIMARY KEY (`ProductID`,`Color`,`Image`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserID`);

--
-- Indexes for table `user_tokens`
--
ALTER TABLE `user_tokens`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `OrderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `ProductID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_tokens`
--
ALTER TABLE `user_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `account`
--
ALTER TABLE `account`
  ADD CONSTRAINT `account_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE;

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE;

--
-- Constraints for table `cartproduct`
--
ALTER TABLE `cartproduct`
  ADD CONSTRAINT `cartproduct_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `cart` (`UserID`) ON DELETE CASCADE,
  ADD CONSTRAINT `cartproduct_ibfk_2` FOREIGN KEY (`ProductID`,`Color`) REFERENCES `productvariant` (`ProductID`, `Color`) ON DELETE CASCADE;

--
-- Constraints for table `orderproduct`
--
ALTER TABLE `orderproduct`
  ADD CONSTRAINT `orderproduct_ibfk_1` FOREIGN KEY (`OrderID`) REFERENCES `orders` (`OrderID`) ON DELETE CASCADE,
  ADD CONSTRAINT `orderproduct_ibfk_2` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE;

--
-- Constraints for table `productvariant`
--
ALTER TABLE `productvariant`
  ADD CONSTRAINT `productvariant_ibfk_1` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
