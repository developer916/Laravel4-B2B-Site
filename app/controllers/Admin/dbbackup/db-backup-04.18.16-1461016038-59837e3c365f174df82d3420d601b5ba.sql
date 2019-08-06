DROP TABLE np_additional_category;

            CREATE TABLE `np_additional_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `categoryname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

					INSERT INTO np_additional_category VALUES("1","size","2016-03-07 09:05:47","2016-03-07 09:05:50");
					INSERT INTO np_additional_category VALUES("2","color","2016-03-07 09:06:01","2016-03-07 09:06:04");
					INSERT INTO np_additional_category VALUES("3","size and color","2016-03-07 09:06:14","2016-03-07 09:06:16");
					


			DROP TABLE np_admin;

            CREATE TABLE `np_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `AdminUserName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `AdminUserPassword` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

					INSERT INTO np_admin VALUES("1","admin","47bce5c74f589f4867dbd57e9ca9f808","1","0000-00-00 00:00:00","2015-06-02 14:39:51");
					


			DROP TABLE np_bargain;

            CREATE TABLE `np_bargain` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `bargain_product_id_foreign` (`product_id`),
  CONSTRAINT `bargain_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `np_product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

					INSERT INTO np_bargain VALUES("3","7","2015-11-26 14:03:24","2015-11-26 14:03:24");
					INSERT INTO np_bargain VALUES("4","5","2015-11-26 14:03:30","2015-11-26 14:03:30");
					INSERT INTO np_bargain VALUES("5","6","2015-12-03 01:44:08","2015-12-03 01:44:08");
					


			DROP TABLE np_businesstype;

            CREATE TABLE `np_businesstype` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `businesstype` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

					INSERT INTO np_businesstype VALUES("1","Trading","2015-06-03 15:25:27","2015-06-03 15:25:27");
					


			DROP TABLE np_buyer_card;

            CREATE TABLE `np_buyer_card` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `quote_id` int(10) unsigned NOT NULL,
  `card_number` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `card_month` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `card_year` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `total_payment` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `card_address` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `card_zip` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `card_email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `card_cvv` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `invoice_number` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `transaction_id` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `avs_response` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cvv_response` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `buyer_card_quote_id_foreign` (`quote_id`),
  CONSTRAINT `buyer_card_quote_id_foreign` FOREIGN KEY (`quote_id`) REFERENCES `np_seller_quote` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

					INSERT INTO np_buyer_card VALUES("2","4","5454545454545454","12","15","270.7","123 Fake St.","77008","customer@email.com","146","330753","20150810194241-080880-330753","AVS Match 9 Digit Zip and Address (X)","CVV2 Match (M)","2015-07-28 13:21:04","2015-08-10 15:42:37");
					


			DROP TABLE np_categories;

            CREATE TABLE `np_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `categoryname` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

					INSERT INTO np_categories VALUES("1","Agriculture","2015-06-03 16:52:17","2015-06-03 16:52:17");
					INSERT INTO np_categories VALUES("2","Apparel & Fashion","2015-06-03 16:52:31","2015-06-03 16:52:31");
					INSERT INTO np_categories VALUES("4","Gifts, Sports & Toys","2015-06-04 18:53:25","2015-06-04 18:53:25");
					INSERT INTO np_categories VALUES("5","Arts, Crafts and Gifts","0000-00-00 00:00:00","0000-00-00 00:00:00");
					INSERT INTO np_categories VALUES("6","Automobile","0000-00-00 00:00:00","0000-00-00 00:00:00");
					INSERT INTO np_categories VALUES("7","Business Services","0000-00-00 00:00:00","0000-00-00 00:00:00");
					INSERT INTO np_categories VALUES("8","Chemicals","0000-00-00 00:00:00","0000-00-00 00:00:00");
					INSERT INTO np_categories VALUES("9","Computer","0000-00-00 00:00:00","0000-00-00 00:00:00");
					INSERT INTO np_categories VALUES("10","Construction","0000-00-00 00:00:00","0000-00-00 00:00:00");
					


			DROP TABLE np_companyprofiles;

            CREATE TABLE `np_companyprofiles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `companyname` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `companyaddress` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `companyphonenumber` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `companyfax` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `companylogo` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `busineestype` int(11) NOT NULL,
  `categories` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `mainforcus` int(11) NOT NULL,
  `companyyoutube` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `companydescription` longtext COLLATE utf8_unicode_ci NOT NULL,
  `companyyear` int(11) NOT NULL,
  `ceoownername` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `factorysize` int(11) NOT NULL,
  `factorylocation` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `qa_qc` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `employees` int(11) NOT NULL,
  `marketingpicture` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `marketingvideo` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `companycity` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `companystate` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `companycountry` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `companyprofiles_user_id_foreign` (`user_id`),
  CONSTRAINT `companyprofiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `np_member` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

					INSERT INTO np_companyprofiles VALUES("2","1","forest company","tulkork phnompenh ","8550972493800","8550972493800","diRdXDlmD8yPsULVN9lzWQkc.png","1","2,3,4,5","2","https://www.youtube.com/embed/C9thrGPyN-k?rel=0&amp;showinfo=0","<p>This is our test code</p>","2015","forest","1","phonompenh","Third Parties","1","F62jB6oKhQmbD3zttqzHRPh2.jpg","dZMK9UuIqbOpXpC3i1sZ3ZPC.mp4","2015-06-04 17:15:16","2015-06-12 07:24:49","freste","","4");
					INSERT INTO np_companyprofiles VALUES("3","2","forest company12","tulkork","8550972493800","8550972493800","F62jB6oKhQmbD3zttqzHRPh2.jpg","1","1,2,3,4,5,6","2","fdsfsd","<p>This is my test</p>","2015","name","1","sdfdf","Third Parties","5","F62jB6oKhQmbD3zttqzHRPh2.jpg","dZMK9UuIqbOpXpC3i1sZ3ZPC.mp4","2015-06-16 18:38:22","2015-06-16 18:38:22","phnompenh","phnompenh","4");
					INSERT INTO np_companyprofiles VALUES("5","5","alexander anikin company","alexander.anikin89@gmail.com","9893343234","","KFJ4xiQKNzTgD1lbRDqVd8Dp.png","1","1,2,4","2","","<p>Our company is good for you.</p>","2012","Forest","1","","Third Parties","3","","","2015-10-06 00:20:00","2015-10-06 00:20:00","dulkork","","4");
					INSERT INTO np_companyprofiles VALUES("9","9","","","","","","0","","0","","","0","","0","","","0","","","2016-01-06 16:11:09","2016-01-06 16:11:09","","","0");
					


			DROP TABLE np_country;

            CREATE TABLE `np_country` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `country_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `country_flag` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=244 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

					INSERT INTO np_country VALUES("3","Afghanistan","vSkxIiV5HU7um4RK3yg5NvEU.png","2015-06-03 14:46:48","2015-06-25 17:30:39");
					INSERT INTO np_country VALUES("4","Cambodia","qBxx8Bp1xuWpoaxU8LT9uEvC.png","2015-06-04 18:24:15","2015-07-20 06:30:50");
					INSERT INTO np_country VALUES("5","Italy","ERI1PqteBilZUuUnKy6fEcYS.png","2015-06-04 18:40:42","2015-07-20 06:31:49");
					INSERT INTO np_country VALUES("8","China","Q7k79VaMfxjjd1uU5F8JLI78.png","2015-07-20 06:32:48","2015-07-20 06:32:48");
					INSERT INTO np_country VALUES("9","Albania","WgchKJXiYWD90IrRTNcpZ8y8.png","2015-07-29 14:37:20","2015-07-29 14:37:20");
					INSERT INTO np_country VALUES("10","Algeria","COFpMckQ2CwZiVMpyEuxOLQQ.png","2015-07-29 14:37:44","2015-07-29 14:37:44");
					INSERT INTO np_country VALUES("11","Andorra","Z4YYFl3E8QVFuLWoyL2y2QTI.png","2015-07-29 14:38:20","2015-07-29 14:38:20");
					INSERT INTO np_country VALUES("12","Angola","m5XrizyOaYIAEYlrTw8fzsRw.png","2015-07-29 14:38:43","2015-07-29 14:38:43");
					INSERT INTO np_country VALUES("13","Anguilla","XgCJkVKI95msMLcqaUYqv8ob.png","2015-07-29 14:38:59","2015-07-29 14:38:59");
					INSERT INTO np_country VALUES("14","Antigua & Barbuda","9RDpDyE629JlhsDIw3WfXvEz.png","2015-07-29 14:39:55","2015-07-29 14:39:55");
					INSERT INTO np_country VALUES("15","Argentina","GGg74om9OncR986rtmlj0cVZ.png","2015-07-29 14:40:30","2015-07-29 14:40:30");
					INSERT INTO np_country VALUES("16","Armenia","1vJhPGbFEeePcDmNwLPrIyV4.png","2015-07-29 14:40:47","2015-07-29 14:40:47");
					INSERT INTO np_country VALUES("17","Austria","lZsrvMUkCtjjdXiLhnGG7frC.png","2015-07-29 14:41:12","2015-07-29 14:41:12");
					INSERT INTO np_country VALUES("18","Azerbaijan","ZqriYYADBNL22ajAQAlKKURn.png","2015-07-29 14:41:38","2015-07-29 14:41:38");
					INSERT INTO np_country VALUES("19","Bahamas","dpu27zJrYiXzmnIwex2JFTnK.png","2015-07-29 14:41:55","2015-07-29 14:41:55");
					INSERT INTO np_country VALUES("20","Bahrain","0UfZ4BckrPfKoTBvncn9W9ZB.png","2015-07-29 14:42:13","2015-07-29 14:42:13");
					INSERT INTO np_country VALUES("21","Bangladesh","uJQ7Wj6q758jMukdXeUjtoYH.png","2015-07-29 14:42:29","2015-07-29 14:42:29");
					INSERT INTO np_country VALUES("22","Barbados","tzSRu5uy9DLMMOaq0hvNfyt7.png","2015-07-29 14:42:47","2015-07-29 14:42:47");
					INSERT INTO np_country VALUES("23","Belarus","r2q9BXZTlmCoXxoLam9I5bTm.png","2015-07-29 14:43:06","2015-07-29 14:43:06");
					INSERT INTO np_country VALUES("24","Belgium","sKmwUT6zGMgwBU0bxo4I7YXi.png","2015-07-29 14:43:29","2015-07-29 14:43:29");
					INSERT INTO np_country VALUES("25","Belize","qD40syJcMy3VJiYRQv3crAXM.png","2015-07-29 14:43:44","2015-07-29 14:43:44");
					INSERT INTO np_country VALUES("26","Benin","sYDO1gLQT7V83cJxnfvDP81v.png","2015-07-29 14:44:07","2015-07-29 14:44:07");
					INSERT INTO np_country VALUES("27","Bermuda","SAXdOsp14zxWtIPHyTRS87Gc.png","2015-07-29 14:44:24","2015-07-29 14:44:24");
					INSERT INTO np_country VALUES("28","Bhutan","tpQE8adnlKh4ILzsqcT5KkmT.png","2015-07-29 14:44:39","2015-07-29 14:44:39");
					INSERT INTO np_country VALUES("29","Bolivia","g27aE3NiSTYerU3UfOjeJOPZ.png","2015-07-29 14:44:56","2015-07-29 14:44:56");
					INSERT INTO np_country VALUES("30","Bosnia And Herzegovina","o43fI2Emc47EmlOw01BaBNMS.png","2015-07-29 14:49:44","2015-07-29 14:49:44");
					INSERT INTO np_country VALUES("31","Botswana","fcerKGwo3MARIfUu3hzbUDpw.png","2015-07-29 14:50:04","2015-07-29 14:50:04");
					INSERT INTO np_country VALUES("32","Brazil","933inAVSxOsmqViFq6J44nR8.png","2015-07-29 14:50:19","2015-07-29 14:50:19");
					INSERT INTO np_country VALUES("33","Brunei","EgX4YBnypsLWnYJlm7Atm3Wf.png","2015-07-29 14:50:32","2015-07-29 15:07:54");
					INSERT INTO np_country VALUES("34","Bulgaria","e31DRzwEK72JdAEGP9i9ID1y.png","2015-07-29 14:50:50","2015-07-29 14:50:50");
					INSERT INTO np_country VALUES("35","Burkina Faso","YLLeMBzIF1m7igMni505cdYM.png","2015-07-29 14:51:13","2015-07-29 14:51:13");
					INSERT INTO np_country VALUES("36","Burundi","SR493J7tLXvBjsj9IlDvhNbQ.png","2015-07-29 14:51:29","2015-07-29 14:51:29");
					INSERT INTO np_country VALUES("37","Cameroon","EPGcaVkkw7wmq57E4ZKX7pAV.png","2015-07-29 14:51:58","2015-07-29 14:51:58");
					INSERT INTO np_country VALUES("38","Canada","EVH7zxF3d4Yn4GVtucpMiZ1R.png","2015-07-29 14:52:10","2015-07-29 14:52:10");
					INSERT INTO np_country VALUES("39","Cape Verde","08jjUduqWQwOLy3iuvOSByXy.png","2015-07-29 14:52:42","2015-07-29 14:52:42");
					INSERT INTO np_country VALUES("40","Cayman Islands","BCNOeBksOtP1EjqVzBqXQmm9.png","2015-07-29 14:53:15","2015-07-29 14:53:15");
					INSERT INTO np_country VALUES("41","Central African Republic","dzIK0hhtxrZuAw4DuHmp6Pde.png","2015-07-29 14:53:38","2015-07-29 14:53:38");
					INSERT INTO np_country VALUES("42","Chad","GC1hfPTtk4u5DhTUkYX2yrFY.png","2015-07-29 14:53:59","2015-07-29 14:53:59");
					INSERT INTO np_country VALUES("43","Chile","JBZ0QRXuvWS4OqNVCQTW35D9.png","2015-07-29 14:54:17","2015-07-29 14:54:17");
					INSERT INTO np_country VALUES("44","American Samoa","I04AdTnlu0w99Hzh1xaDXtyt.png","2015-07-29 14:57:19","2015-07-29 14:57:19");
					INSERT INTO np_country VALUES("45","Antarctica","GwEltsXPHEN5XAUVVteSa4LI.png","2015-07-29 15:00:48","2015-07-29 15:00:48");
					INSERT INTO np_country VALUES("46","Aruba","EwyDtfI4qFvWhtRPTRjXNn4p.png","2015-07-29 15:02:01","2015-07-29 15:02:01");
					INSERT INTO np_country VALUES("47","Australia","dm46Cpp18gMSxI04OT9XMUi8.png","2015-07-29 15:02:59","2015-07-29 15:02:59");
					INSERT INTO np_country VALUES("48","Bouvet Island","c59RlMxzCXmjCrgvKdfiWc5O.jpg","2015-07-29 15:04:59","2015-07-29 15:04:59");
					INSERT INTO np_country VALUES("49","British Indian Ocean Territory","Wc3YgQMkcUVcCXwVfwGfkNKE.png","2015-07-29 15:06:15","2015-07-29 15:06:15");
					INSERT INTO np_country VALUES("50","Christmas Island","EEaP4KLu6bHhtnOHS9ZqWalr.png","2015-07-29 15:11:29","2015-07-29 15:11:29");
					INSERT INTO np_country VALUES("51","Cocos (Keeling) Islands","Mdx8nfb9JEYuilUwGYy8mzcz.png","2015-07-29 15:12:16","2015-07-29 15:12:16");
					INSERT INTO np_country VALUES("52","Colombia","rqtnJu1XW34o7sbdKyVI3CV9.png","2015-07-29 15:13:05","2015-07-29 15:13:05");
					INSERT INTO np_country VALUES("53","Comoros","emuCvT3kXfrmRE2Vv67IZJei.png","2015-07-29 15:13:28","2015-07-29 15:13:28");
					INSERT INTO np_country VALUES("54","Congo","J0do8gmuqmSHu9IRZbNeB7Aa.png","2015-07-29 15:14:00","2015-07-29 15:14:00");
					INSERT INTO np_country VALUES("55","Congo, The Democratic Republic Of The","DN2TuV1IQ0sWo8vS0tPaDMxM.png","2015-07-29 15:14:37","2015-07-29 15:14:37");
					INSERT INTO np_country VALUES("56","Cook Islands","DXixNikbAAO5tijtkDOtNrMM.png","2015-07-29 15:15:13","2015-07-29 15:15:13");
					INSERT INTO np_country VALUES("57","Costa Rica","hsOvHKrAutmlxPatnM72ZkPL.png","2015-07-29 15:15:46","2015-07-29 15:15:46");
					INSERT INTO np_country VALUES("58","Cote DIvoire","pdjo4PhxhUL2zPG4HZrW8ppE.png","2015-07-29 15:16:38","2015-07-29 15:16:38");
					INSERT INTO np_country VALUES("59","Croatia (Hrvatska)","cyzFovlijfLb7F8dR34kPlIN.png","2015-07-29 15:17:04","2015-07-29 15:17:04");
					INSERT INTO np_country VALUES("60","Cuba","zNTWdxWLatk9a05cNsCLQ52m.png","2015-07-29 15:17:42","2015-07-29 15:17:42");
					INSERT INTO np_country VALUES("61","Cyprus","Jfxf9GaBlSeh0GRfNLShDJJL.png","2015-07-29 15:18:05","2015-07-29 15:18:05");
					INSERT INTO np_country VALUES("62","Czech Republic","KJbfmeOe1iglPmZYxMEFWGaj.png","2015-07-29 15:18:38","2015-07-29 15:18:38");
					INSERT INTO np_country VALUES("63","Denmark","jpdBFoEauNruRl9mvKzi8MjY.png","2015-07-29 15:18:57","2015-07-29 15:18:57");
					INSERT INTO np_country VALUES("64","Djibouti","TXyY4ivB9f0YTg2vdAxE8YWb.png","2015-07-29 15:37:38","2015-07-29 15:37:38");
					INSERT INTO np_country VALUES("65","Dominica","bGIeZn9URuaLLDvAeuLNTQPp.png","2015-07-29 15:38:00","2015-07-29 15:38:00");
					INSERT INTO np_country VALUES("66","Dominican Republic","NU7DdZjjOlwsdnHLAFHMIqMl.png","2015-07-29 15:38:18","2015-07-29 15:38:18");
					INSERT INTO np_country VALUES("67","East Timor","ObWjbD9d3I3XNm0rgkYtcYLu.png","2015-07-29 15:38:41","2015-07-29 15:38:41");
					INSERT INTO np_country VALUES("68","Ecuador","ngPc0sbVG696My1VtMFqvTGU.png","2015-07-29 15:39:04","2015-07-29 15:39:04");
					INSERT INTO np_country VALUES("69","Egypt","5VTicU6dl7oCRO2CgVziIf1h.png","2015-07-29 15:39:30","2015-07-29 15:39:30");
					INSERT INTO np_country VALUES("70","El Salvador","ENZTml37XvlDQgu34MtLshjm.png","2015-07-29 15:39:47","2015-07-29 15:39:47");
					INSERT INTO np_country VALUES("71","Equatorial Guinea","tVgFE5pxqycRcpuLUcOXxwl9.png","2015-07-29 15:40:09","2015-07-29 15:40:09");
					INSERT INTO np_country VALUES("72","Eritrea","qrvzrCTgDOUTbDDtRe5XE3lS.png","2015-07-29 15:40:30","2015-07-29 15:40:30");
					INSERT INTO np_country VALUES("73","Estonia","KZ6Y3BrE5FzJIEfwWiHZaMAq.png","2015-07-29 15:40:49","2015-07-29 15:40:49");
					INSERT INTO np_country VALUES("74","Ethiopia","QJEBdaO8HT6Q7vim2h4jpfic.png","2015-07-29 15:41:10","2015-07-29 15:41:10");
					INSERT INTO np_country VALUES("75","Falkland Islands","XNnCaDhusblFguhvmvSTI5z2.png","2015-07-29 15:41:48","2015-07-29 15:41:48");
					INSERT INTO np_country VALUES("76","Faroe Islands","fypxniRDSVuqqKyP0oJcUDGF.png","2015-07-29 15:42:15","2015-07-29 15:42:15");
					INSERT INTO np_country VALUES("77","Fiji","dF9zMuP3FGGG3ffrg7wXCT5E.png","2015-07-29 15:42:55","2015-07-29 15:42:55");
					INSERT INTO np_country VALUES("78","Finland","T1BBAQIHZV3JD4LyGNKCdfIE.png","2015-07-29 15:43:08","2015-07-29 15:43:08");
					INSERT INTO np_country VALUES("79","France","kFtOXpxL7cdbJNRJWeiVSHn7.png","2015-07-29 15:43:29","2015-07-29 15:43:29");
					INSERT INTO np_country VALUES("80","French Guiana","vZ3tghSrH8UqFO8l035KV9Oh.png","2015-07-29 15:45:12","2015-07-29 15:45:12");
					INSERT INTO np_country VALUES("81","French Polynesia","90DEm4JSwb0dhxcQkTrgNWUH.png","2015-07-29 15:45:54","2015-07-29 15:45:54");
					INSERT INTO np_country VALUES("82","French Southern Territories","uY0sFu0eMVwf1P5R0scu14iY.png","2015-07-29 15:47:10","2015-07-29 15:47:10");
					INSERT INTO np_country VALUES("83","Gabon","YeQomhGValzRHAgoeBir5qI2.png","2015-07-29 15:47:34","2015-07-29 15:47:34");
					INSERT INTO np_country VALUES("84","Gambia","D1bGrAzhGDFyzkD7WURFut59.png","2015-07-29 15:47:48","2015-07-29 15:47:48");
					INSERT INTO np_country VALUES("85","Georgia","hJhtDG9EjAhhwWmjMVygFZg5.png","2015-07-29 15:48:18","2015-07-29 15:48:18");
					INSERT INTO np_country VALUES("86","Germany","ekgyyqKTUSVllrwCZQvTjL32.png","2015-07-29 15:48:36","2015-07-29 15:48:36");
					INSERT INTO np_country VALUES("87","Ghana","JFJ2rIppE4nhWY7acDZu7NRo.png","2015-07-29 15:49:01","2015-07-29 15:49:01");
					INSERT INTO np_country VALUES("88","Gibraltar","O5H5SKSd3kozFcng0WhowWW3.png","2015-07-29 15:49:25","2015-07-29 15:49:25");
					INSERT INTO np_country VALUES("89","Greece","sOzkoCspsIJQM2DntnLHCfDo.png","2015-07-29 15:49:44","2015-07-29 15:49:44");
					INSERT INTO np_country VALUES("90","Greenland","2sopiXqKpf5mgoqdRvHTeC6u.png","2015-07-29 15:50:07","2015-07-29 15:50:07");
					INSERT INTO np_country VALUES("91","Grenada","jVbmh9GgWGVzDHLio05xiv2p.png","2015-07-29 15:50:19","2015-07-29 15:50:19");
					INSERT INTO np_country VALUES("92","Guadeloupe","Br83LG7vkofQMoZGe3rGbjab.png","2015-07-29 15:51:57","2015-07-29 15:51:57");
					INSERT INTO np_country VALUES("93","Guam","OQldpcS9R4LmkvU2sWoA4HjA.png","2015-07-29 15:52:14","2015-07-29 15:52:14");
					INSERT INTO np_country VALUES("94","Guatemala","4OZXAiWjzCSxflQQWHVr2XNv.png","2015-07-29 15:52:28","2015-07-29 15:52:28");
					INSERT INTO np_country VALUES("95","Guinea","VBwLUh0kLT0BACVfeBEZcljq.png","2015-07-29 15:52:48","2015-07-29 15:52:48");
					INSERT INTO np_country VALUES("96","Guinea-Bissau","AAVxihxGOMTLfsY962Indy9h.png","2015-07-29 15:53:06","2015-07-29 15:53:06");
					INSERT INTO np_country VALUES("97","Guyana","UrHzmq01kRCabMFgBGSXAYiI.png","2015-07-29 15:53:25","2015-07-29 15:53:25");
					INSERT INTO np_country VALUES("98","Haiti","pbeOfs7pFM11W3DmOBTTbUwl.png","2015-07-29 15:53:45","2015-07-29 15:53:45");
					INSERT INTO np_country VALUES("99","Hong Kong","FLUXGtKwAdmLpznSqgBxfTHx.png","2015-07-29 15:55:28","2015-07-29 15:55:28");
					INSERT INTO np_country VALUES("100","Hungary","mGpHhyPCzyRA0kZAl5ChXVO6.png","2015-07-29 15:55:47","2015-07-29 15:55:47");
					INSERT INTO np_country VALUES("101","Iceland","WjXCvsANYxellb41fJqgxbzZ.png","2015-07-29 15:56:08","2015-07-29 15:56:08");
					INSERT INTO np_country VALUES("102","India","Cy1Md9WPEN7ciZsaNjdxgKeN.png","2015-07-29 15:56:26","2015-07-29 15:56:26");
					INSERT INTO np_country VALUES("103","Indonesia","0WVmeryKXGJj6qulTfU3MxUe.png","2015-07-29 15:56:43","2015-07-29 15:56:43");
					INSERT INTO np_country VALUES("104","Iran","y7UJwfLp0lAfDp1qAMTWkZ9I.png","2015-07-29 15:56:54","2015-07-29 15:56:54");
					INSERT INTO np_country VALUES("105","Iraq","3Kiapdz6CTGeZjBPPdSuI1Wu.png","2015-07-29 15:57:06","2015-07-29 15:57:06");
					INSERT INTO np_country VALUES("106","Ireland","ff1OcG9CK7xOZu7yNG40DP2e.png","2015-07-29 15:57:29","2015-07-29 15:57:29");
					INSERT INTO np_country VALUES("107","Israel","LdhLlyaMyhM0bPjsSTpNiSx8.png","2015-07-29 15:57:41","2015-07-29 15:57:41");
					INSERT INTO np_country VALUES("108","Jamaica","2jAbRjBW932XWxzBSSRFpfp3.png","2015-07-29 15:58:13","2015-07-29 15:58:13");
					INSERT INTO np_country VALUES("109","Japan","XRVWfhU5QH1x0gmav2JUZPCW.png","2015-07-29 15:58:25","2015-07-29 15:58:25");
					INSERT INTO np_country VALUES("110","Jordan","YfZSohN5szqQRGejr3VNox3V.png","2015-07-29 15:58:39","2015-07-29 15:58:39");
					INSERT INTO np_country VALUES("111","Kazakhstan","7BAyN611MtxFvJvLtxJRcYVP.png","2015-07-29 15:58:51","2015-07-29 15:58:51");
					INSERT INTO np_country VALUES("112","Kenya","OKjGULTZr3CjQk0gINzSFmjn.png","2015-07-29 15:59:15","2015-07-29 15:59:15");
					INSERT INTO np_country VALUES("113","Kiribati","B8PRtkFIUA1oON5ywbjGYP44.png","2015-07-29 15:59:42","2015-07-29 15:59:42");
					INSERT INTO np_country VALUES("114","Korea","CDWqBFeN47Wve9aFwcaa17Ie.png","2015-07-29 15:59:54","2015-07-29 15:59:54");
					INSERT INTO np_country VALUES("115","Kuwait","M2enI39WTr2TbDZa02Z63Zry.png","2015-07-29 16:00:15","2015-07-29 16:00:15");
					INSERT INTO np_country VALUES("116","Kyrgyzstan","UmtylGTlEa6F2HJlPD9Gu5a4.png","2015-07-29 16:00:31","2015-07-29 16:00:31");
					INSERT INTO np_country VALUES("117","Laos","BkC2232xrqvgmjHK7phsHGfS.png","2015-07-29 16:00:52","2015-07-29 16:00:52");
					INSERT INTO np_country VALUES("118","Latvia","crPDMpVXdauxbZQKoIQQW5dn.png","2015-07-30 05:41:28","2015-07-30 05:41:28");
					INSERT INTO np_country VALUES("119","Lebanon","OBtVVxX70xREEQxlWLsoHubf.png","2015-07-30 05:42:33","2015-07-30 05:42:33");
					INSERT INTO np_country VALUES("120","Lesotho","1UAUeUpV3WBjeWKdbcANpEw9.png","2015-07-30 05:42:51","2015-07-30 05:42:51");
					INSERT INTO np_country VALUES("121","Liberia","3xN89VLZ4KtVaWcsCkglAdUn.png","2015-07-30 05:43:19","2015-07-30 05:43:19");
					INSERT INTO np_country VALUES("122","Liechtenstein","E4XUClEiHp9AhntnKKlrjnUo.png","2015-07-30 05:44:01","2015-07-30 05:44:01");
					INSERT INTO np_country VALUES("123","Lithuania","aMWqirbDxisRTRadWsy6U2q2.png","2015-07-30 05:44:21","2015-07-30 05:44:21");
					INSERT INTO np_country VALUES("124","Luxembourg","zBnE7kgfVLY20flu1bD2zK26.png","2015-07-30 05:44:46","2015-07-30 05:44:46");
					INSERT INTO np_country VALUES("125","Macau","0RvBNdbnuqMhJyXtOUlkNUq4.png","2015-07-30 05:50:56","2015-07-30 05:50:56");
					INSERT INTO np_country VALUES("126","Macedonia","Z6LB1cXK5qPMvavnNTCLIHVG.png","2015-07-30 12:39:42","2015-07-30 12:39:42");
					INSERT INTO np_country VALUES("127","Madagascar","9lohPybyGoobeb63Xeg1kZEx.png","2015-07-30 12:40:00","2015-07-30 12:40:00");
					INSERT INTO np_country VALUES("128","Malawi","DY570qjoZl0lVAusORMWlm5E.png","2015-07-30 12:40:18","2015-07-30 12:40:18");
					INSERT INTO np_country VALUES("129","Malaysia","5P9tbj2WAGk7tXjLdqNZqhgE.png","2015-07-30 12:41:30","2015-07-30 12:41:30");
					INSERT INTO np_country VALUES("130","Maldives","fFUjBOuUflY0yUCyXw1iUR52.png","2015-07-30 12:41:47","2015-07-30 12:41:47");
					INSERT INTO np_country VALUES("131","Mali","HgJ0PYgj57AKPzofFTCc3hqn.png","2015-07-30 12:43:10","2015-07-30 12:43:10");
					INSERT INTO np_country VALUES("132","Malta","ScJkbMKyVT82oGPegBSyVaDH.png","2015-07-30 12:43:27","2015-07-30 12:43:27");
					INSERT INTO np_country VALUES("133","Martinique","m06w2ZOzS3lgB1V9alcyUMqt.png","2015-07-30 12:43:41","2015-07-30 12:43:41");
					INSERT INTO np_country VALUES("134","Marshall Islands","GS3OLuHFthCoWQ9OAVsLdWSz.png","2015-07-30 12:45:16","2015-07-30 12:45:16");
					INSERT INTO np_country VALUES("135","Mauritania","nnVnPXKeLpdqHZxEwKPqs2GB.png","2015-07-30 12:45:41","2015-07-30 12:45:41");
					INSERT INTO np_country VALUES("136","Mauritius","NOdPhieEfonefnnvhSsgpiOd.png","2015-07-30 12:46:06","2015-07-30 12:46:06");
					INSERT INTO np_country VALUES("137","Mayotte","fqCYpGnu3mQo8OvCcmQEbdrS.png","2015-07-30 12:48:32","2015-07-30 12:48:32");
					INSERT INTO np_country VALUES("138","Mexico","7fmR8ucawi3XqGNz187zn0eD.png","2015-07-30 12:48:45","2015-07-30 12:48:45");
					INSERT INTO np_country VALUES("139","Micronesia","Ra87guBJoxNf1RTINkcgWC8b.png","2015-07-30 12:49:35","2015-07-30 12:49:35");
					INSERT INTO np_country VALUES("140","Moldova","P1IPEzG4UeHRl2TtLWVjf7OQ.png","2015-07-30 12:49:58","2015-07-30 12:49:58");
					INSERT INTO np_country VALUES("141","Monaco","dTgtcTNNIjLjrVO8rF9ctoTb.png","2015-07-30 12:52:03","2015-07-30 12:52:03");
					INSERT INTO np_country VALUES("142","Mongolia","PqYWTiKDL2iS2P0VpvMhQjSZ.png","2015-07-30 12:52:20","2015-07-30 12:52:20");
					INSERT INTO np_country VALUES("143","Montserrat","FfViDCi85OTyrAKvOzHECn6M.png","2015-07-30 12:53:02","2015-07-30 12:53:02");
					INSERT INTO np_country VALUES("144","Morocco","Aeg4beGGwuBlTHdA3ZrAqqtA.png","2015-07-30 12:53:22","2015-07-30 12:53:22");
					INSERT INTO np_country VALUES("145","Mozambique","5iPwJvS9cxAczcPMVbJDSj5e.png","2015-07-30 12:53:36","2015-07-30 12:53:36");
					INSERT INTO np_country VALUES("146","Myanmar","Ab7xzlwKPW6xUSVzL56wfauL.png","2015-07-30 12:54:58","2015-07-30 12:54:58");
					INSERT INTO np_country VALUES("147","Namibia","Pp6Z7odJ8DR3WmXxhevrHLDe.png","2015-07-30 12:55:23","2015-07-30 12:55:23");
					INSERT INTO np_country VALUES("148","Nauru","VQ08gojG7SfHN31XgXD4ibo9.png","2015-07-30 12:55:42","2015-07-30 12:55:42");
					INSERT INTO np_country VALUES("149","Nepal","rLfr4vn7FplJX4GAIAwRFnEi.png","2015-07-30 12:56:30","2015-07-30 12:56:30");
					INSERT INTO np_country VALUES("150","Netherlands","Sjh4oUIPiinp4giqDc7ZqyeS.png","2015-07-30 12:56:45","2015-07-30 12:56:45");
					INSERT INTO np_country VALUES("151","Netherlands Antilles","pkIm9KMHcZIP1BzL8epmiEbx.png","2015-07-30 12:57:08","2015-07-30 12:57:08");
					INSERT INTO np_country VALUES("152","New Caledonia","tibqx6nxF6LVDIb1FNs6Z137.jpg","2015-07-30 12:59:29","2015-07-30 12:59:29");
					INSERT INTO np_country VALUES("153","New Zealand","NZaSkZOhEzBlOCgxUnUfGQvn.png","2015-07-30 12:59:53","2015-07-30 12:59:53");
					INSERT INTO np_country VALUES("154","Nicaragua","Bt6SFCldTckiLhpJOIx6MBJF.png","2015-07-30 13:00:12","2015-07-30 13:00:12");
					INSERT INTO np_country VALUES("155","Niger","gMUi1b7q4jOT4EumsPG3xqip.png","2015-07-30 13:04:34","2015-07-30 13:04:34");
					INSERT INTO np_country VALUES("156","Nigeria","dRPBy7O7FgYEiaNUcKPPxdAj.png","2015-07-30 13:04:50","2015-07-30 13:04:50");
					INSERT INTO np_country VALUES("157","Niue","9wrct1wMQep80oZwtji8CBNy.png","2015-07-30 13:06:28","2015-07-30 13:06:28");
					INSERT INTO np_country VALUES("158","Norfolk Island","SRBhZIz8NraZKQg91M8ToYSC.png","2015-07-30 13:06:47","2015-07-30 13:06:47");
					INSERT INTO np_country VALUES("159","North Korea","L5pqqJmHiAXOznVtUbfA8HxJ.png","2015-07-30 13:07:00","2015-07-30 13:07:00");
					INSERT INTO np_country VALUES("160","Northern Mariana Islands","yogyJ1RHCNRHYv568lCS2Wu4.gif","2015-07-30 13:08:08","2015-07-30 13:08:08");
					INSERT INTO np_country VALUES("161","Norway","h4UlocKQAeIcjb634LzKVvL6.png","2015-07-30 13:08:21","2015-07-30 13:08:21");
					INSERT INTO np_country VALUES("162","Oman","qyubJI045mfzeKkc11It8Tmz.png","2015-07-30 13:25:22","2015-07-30 13:25:22");
					INSERT INTO np_country VALUES("163","Pakistan","ZzzEIkpUmFTWyTSu1VGA0dPT.png","2015-07-30 13:25:40","2015-07-30 13:25:40");
					INSERT INTO np_country VALUES("164","Palau","7MKT8latTGZLS4RnT1AmAl8M.gif","2015-07-30 15:16:54","2015-07-30 15:16:54");
					INSERT INTO np_country VALUES("165","Panama","8TeryHbAoZsOYqV3GDm9AZup.png","2015-07-30 15:17:16","2015-07-30 15:17:16");
					INSERT INTO np_country VALUES("166","Papua New Guinea","5yUjym7NOQew4aBbnpalJ6sE.png","2015-07-30 15:17:41","2015-07-30 15:17:41");
					INSERT INTO np_country VALUES("167","Paraguay","x5c8iQ04y3SQBL2SYad965Hb.png","2015-07-30 15:17:55","2015-07-30 15:17:55");
					INSERT INTO np_country VALUES("168","Peru","cXimCksNzwTbJZKrk5XAlXwR.png","2015-07-30 15:18:08","2015-07-30 15:18:08");
					INSERT INTO np_country VALUES("169","Philippines","i3eppZZOpPKcYnSy2SJeilCG.png","2015-07-30 15:18:30","2015-07-30 15:18:30");
					INSERT INTO np_country VALUES("170","Pitcairn Islands","E4m8EnJaYSMOFw4lmbTnIPgG.png","2015-07-30 15:18:46","2015-07-30 15:18:46");
					INSERT INTO np_country VALUES("171","Poland","FH11GxlgKBoZU6N9JBk0ZnI3.png","2015-07-30 15:19:03","2015-07-30 15:19:03");
					INSERT INTO np_country VALUES("172","Portugal","nCoB3vt0jA9TjAOTa20w9lOL.png","2015-07-30 15:19:19","2015-07-30 15:19:19");
					INSERT INTO np_country VALUES("173","Qatar","YAEQ8DFj7BMFeEXBdh2Q2CVI.png","2015-07-30 15:23:29","2015-07-30 15:23:29");
					INSERT INTO np_country VALUES("174","Reunion","toB5tQwsaL5p0mcMJAYs3H2d.gif","2015-07-30 15:24:59","2015-07-30 15:24:59");
					INSERT INTO np_country VALUES("175","Romania","d2pj0L4FXTObdgc5xtvWmuum.png","2015-07-30 15:25:17","2015-07-30 15:25:17");
					INSERT INTO np_country VALUES("176","Russia","LAHgv9V8hmP9dEhJjGR4MM6G.png","2015-07-30 15:25:42","2015-07-30 15:25:42");
					INSERT INTO np_country VALUES("177","Rwanda","YTSdQo9sZkVJ1Ec97ocFPzpz.png","2015-07-30 15:26:08","2015-07-30 15:26:08");
					INSERT INTO np_country VALUES("178","Samoa ","l8znMRZjdwrEiJUROeJxpu2d.png","2015-07-30 15:26:22","2015-07-30 15:26:22");
					INSERT INTO np_country VALUES("179","San Marino","1TJUckMASinbrvypGESPX5MK.png","2015-07-30 15:26:43","2015-07-30 15:26:43");
					INSERT INTO np_country VALUES("180","Sao Tome And Principe","xWy7beUVKi9nIn3xsj5SNMnc.png","2015-07-30 15:27:09","2015-07-30 15:27:09");
					INSERT INTO np_country VALUES("181","Saudi Arabia","3nioEFDNbYFemyu6ejSmCoLw.png","2015-07-30 15:27:47","2015-07-30 15:27:47");
					INSERT INTO np_country VALUES("182","Senegal","hO0RzlK3ha16DJbs3pIp7T1Q.png","2015-07-30 15:28:59","2015-07-30 15:28:59");
					INSERT INTO np_country VALUES("183","Serbia And Montenegro","bwWMBULSOLzcGoxNU0liUZrj.png","2015-07-30 15:29:40","2015-07-30 15:29:40");
					INSERT INTO np_country VALUES("184","Seychelles","80Da8Ran8B45nm9YVk4wCuUW.png","2015-07-30 15:30:12","2015-07-30 15:30:12");
					INSERT INTO np_country VALUES("185","Sierra Leone","qYycEEaGEWvM7MMJwARupU4s.png","2015-07-30 15:30:26","2015-07-30 15:30:26");
					INSERT INTO np_country VALUES("186","Singapore","YJKasnLOK5xX8FRn0YnlI7Qc.png","2015-07-30 15:30:39","2015-07-30 15:30:39");
					INSERT INTO np_country VALUES("187","Slovakia","DADUzqMlr4eP7R6Jr38ThThm.png","2015-07-30 15:30:53","2015-07-30 15:30:53");
					INSERT INTO np_country VALUES("188","Slovenia","USxp9URMfHpUy1lwd0BsltTA.png","2015-07-30 15:31:22","2015-07-30 15:31:22");
					INSERT INTO np_country VALUES("189","Solomon Islands","l30InKhXHof97kmeFXl0qGhi.png","2015-07-30 15:31:48","2015-07-30 15:31:48");
					INSERT INTO np_country VALUES("190","South Africa","acJMHPZj9krO7gfIajfzrjI0.png","2015-07-30 15:40:25","2015-07-30 15:40:25");
					INSERT INTO np_country VALUES("191","South Georgia And The South Sandwich Islands","msPsEoP7ShdfZgwrbAuiYdvA.png","2015-07-30 15:44:08","2015-07-30 15:44:08");
					INSERT INTO np_country VALUES("192","Spain","wXczjOFlGRid750ugwFqn29b.png","2015-07-30 15:44:27","2015-07-30 15:44:27");
					INSERT INTO np_country VALUES("193","Sri Lanka","3uOdN2N7fmFkIZdhEAf2tQMI.png","2015-07-30 15:44:43","2015-07-30 15:44:43");
					INSERT INTO np_country VALUES("194","St. Helena","ufWDytsbwL8CXBgO68LTaJUc.png","2015-07-30 15:45:13","2015-07-30 15:45:13");
					INSERT INTO np_country VALUES("195","St. Kitts And Nevis","TkeyaLUyFt5Rx9QFdkPHnNZ0.png","2015-07-30 15:45:29","2015-07-30 15:45:29");
					INSERT INTO np_country VALUES("196","St. Lucia","xXkxi3NbDzznz37NoGkJbfgk.png","2015-07-30 15:45:50","2015-07-30 15:45:50");
					INSERT INTO np_country VALUES("197","St. Pierre And Miquelon","8QO2Mxc9cyUObvUeOt5FrDjs.png","2015-07-30 15:49:30","2015-07-30 15:49:30");
					INSERT INTO np_country VALUES("198","St. Vincent & Grenadines","ub8xL892eLtpkOYVzCGZnssN.png","2015-07-30 15:51:18","2015-07-30 15:51:18");
					INSERT INTO np_country VALUES("199","Sudan","jZREkABseRmiUER7J5TspKA4.png","2015-07-30 15:51:34","2015-07-30 15:51:34");
					INSERT INTO np_country VALUES("200","Suriname","Yn3dxGB2fwZl7S8j2pjw5yFF.png","2015-07-30 15:51:55","2015-07-30 15:51:55");
					INSERT INTO np_country VALUES("201","Swaziland","qdSbpgEjD8arhcni969Qro8l.png","2015-07-30 15:52:12","2015-07-30 15:52:12");
					INSERT INTO np_country VALUES("202","Sweden","35HFzdp6XIVyFqBQp6NXEU7v.png","2015-07-30 15:52:34","2015-07-30 15:52:34");
					INSERT INTO np_country VALUES("203","Switzerland","0xyQL0OU3hFhW1lWjWMEdP0s.png","2015-07-30 15:52:50","2015-07-30 15:52:50");
					INSERT INTO np_country VALUES("204","Syria","WiJjVBWZGaaFELyrJyVitZ3p.png","2015-07-30 15:53:12","2015-07-30 15:53:12");
					INSERT INTO np_country VALUES("205","Taiwan","ndw2dP5VAdV2REaJAvpSe8bv.png","2015-07-30 15:53:29","2015-07-30 15:53:29");
					INSERT INTO np_country VALUES("206","Tajikistan","mcYkAnNUSMCM6WBqG1JnAv3h.png","2015-07-30 15:53:44","2015-07-30 15:57:43");
					INSERT INTO np_country VALUES("207","Tanzania","YHgHQPtbv1pmwRmPXcyCxgzD.png","2015-07-30 15:53:59","2015-07-30 15:53:59");
					INSERT INTO np_country VALUES("208","Thailand","XI9Ytl3jSYDlmHUKvqH7l1F1.png","2015-07-30 15:54:19","2015-07-30 15:54:19");
					INSERT INTO np_country VALUES("209","Togo","kvM3MQTaB0O6wtiMdS6a46IP.png","2015-07-30 15:54:57","2015-07-30 15:54:57");
					INSERT INTO np_country VALUES("210","Tokelau","H3lq7U5XrHqr0CowILjDzo7U.png","2015-07-30 15:55:11","2015-07-30 15:55:11");
					INSERT INTO np_country VALUES("211","Tonga","yHBo6BfQJ5igAjG9AACHZbOe.png","2015-07-30 15:55:36","2015-07-30 15:55:36");
					INSERT INTO np_country VALUES("212","Trinidad And Tobago","FkDF4gpvAJrFecSeW4oVkdoK.png","2015-07-30 15:55:57","2015-07-30 15:55:57");
					INSERT INTO np_country VALUES("213","Tunisia","Dn8wMMgTOU1yDee8Ss2kenaS.png","2015-07-30 15:56:11","2015-07-30 15:56:11");
					INSERT INTO np_country VALUES("214","Turkey","G7NPRChvGT1EmqHmRbIwgzIJ.png","2015-07-30 15:56:24","2015-07-30 15:56:24");
					INSERT INTO np_country VALUES("215","Turkmenistan","423B4KNkT2YstIwXqudYfglq.png","2015-07-30 15:56:44","2015-07-30 15:56:44");
					INSERT INTO np_country VALUES("216","Turks And Caicos Islands","CjwJCJysBs5oTx8fLVrOqrQZ.png","2015-07-30 15:58:29","2015-07-30 15:58:29");
					INSERT INTO np_country VALUES("217","Tuvalu","aoCTACSM3rd6IRwLGLa7j4l6.png","2015-07-30 15:58:43","2015-07-30 15:58:43");
					INSERT INTO np_country VALUES("218","Uganda","yZAHRDmwmfji8MZNA9p8bqLu.png","2015-07-30 15:58:57","2015-07-30 15:58:57");
					INSERT INTO np_country VALUES("219","Ukraine","UDMNQDjzrymbidiBRPJmm5Gk.png","2015-07-30 15:59:11","2015-07-30 15:59:11");
					INSERT INTO np_country VALUES("220","United Arab Emirates","otklalwdAIKRnU8KrJWSLsYm.png","2015-07-30 15:59:24","2015-07-30 15:59:24");
					INSERT INTO np_country VALUES("221","United Kingdom","jDunYIC0dis5oOSIHhHQyThh.png","2015-07-30 15:59:38","2015-07-30 15:59:38");
					INSERT INTO np_country VALUES("222","Uruguay","oIchpmxDZWBbL6u6smM79cJS.png","2015-07-30 15:59:59","2015-07-30 15:59:59");
					INSERT INTO np_country VALUES("223","USA","LURBdymNHXRwfCNShTtBboIi.png","2015-07-30 16:00:20","2015-07-30 16:00:20");
					INSERT INTO np_country VALUES("224","Uzbekistan","Pr7i7Xq5vFhwqukYarHCpjAv.png","2015-07-30 16:00:37","2015-07-30 16:00:37");
					INSERT INTO np_country VALUES("225","Vanuatu","8pEeevf5cdF26QsXwcou69cT.png","2015-07-30 16:01:11","2015-07-30 16:01:11");
					INSERT INTO np_country VALUES("226","Venezuela","0Tw6VpYWXoFpkyoPDUMaLkgJ.png","2015-07-30 16:01:27","2015-07-30 16:01:27");
					INSERT INTO np_country VALUES("227","Vietnam","jewnu3rbxmjgnrlNmKNvVv03.png","2015-07-30 16:01:43","2015-07-30 16:01:43");
					INSERT INTO np_country VALUES("228","Virgin Islands","0TH9LZx8NFPiub1Eqh89hELZ.png","2015-07-30 16:02:24","2015-07-30 16:02:24");
					INSERT INTO np_country VALUES("229","Virgin Islands (British)","CAB9t9W0JE6pv5wmEi3mg1XL.png","2015-07-30 16:02:36","2015-07-30 16:02:36");
					INSERT INTO np_country VALUES("230","Wallis And Futuna","cHzNICMB41dSFHWP85ti1umh.png","2015-07-30 16:02:59","2015-07-30 16:02:59");
					INSERT INTO np_country VALUES("231","Yemen","jGRafbeRKgdn3vnz5SHbFU5y.png","2015-07-30 16:03:35","2015-07-30 16:03:35");
					INSERT INTO np_country VALUES("232","Zambia","MPO15eKpf0XrqWRSIQzpjd2h.png","2015-07-30 16:03:53","2015-07-30 16:03:53");
					INSERT INTO np_country VALUES("233","Zimbabwe","WY504w850EtpLHqgDk2dSILw.png","2015-07-30 16:04:07","2015-07-30 16:04:07");
					INSERT INTO np_country VALUES("234","Western Sahara","rhvcD9ntiAQoVd2NNIxEZmwW.png","2015-07-30 16:04:47","2015-07-30 16:04:47");
					INSERT INTO np_country VALUES("235","Honduras","rbGBusBqRRUHTChAwlZjsxVT.gif","2015-07-31 09:45:19","2015-07-31 09:45:19");
					INSERT INTO np_country VALUES("236","Holy See","zn81rwm35PaePsQqOrVQIaJp.jpg","2015-07-31 09:47:31","2015-07-31 09:47:31");
					INSERT INTO np_country VALUES("237","Libyan Arab","Q9Y4Stnqh0YhcjF0RZUGAS8N.gif","2015-07-31 10:16:34","2015-07-31 10:16:34");
					INSERT INTO np_country VALUES("238","Puerto Rico","44OobNbIU53ijWIlrTDJw1l8.png","2015-07-31 10:25:53","2015-07-31 10:25:53");
					INSERT INTO np_country VALUES("239","Saint Kitts And Nevis","SekQx9bXJkCbNSGJ4d66tnQW.png","2015-07-31 10:29:02","2015-07-31 10:29:02");
					INSERT INTO np_country VALUES("240","Saint LUCIA","XHcNmJgLbGbF6hK53cFzwURh.png","2015-07-31 10:30:09","2015-07-31 10:30:09");
					INSERT INTO np_country VALUES("241","Saint Vincent","J706Ea80k8Uv90ClTAWRGzN4.png","2015-07-31 10:31:09","2015-07-31 10:31:09");
					INSERT INTO np_country VALUES("242","Somalia","gURWW2r4YtzDMB42uKGmHrTa.png","2015-07-31 10:34:05","2015-07-31 10:34:05");
					INSERT INTO np_country VALUES("243","Svalbard And Jan Mayen Islands","f9mY8Sa7G78S1ZoHQh7cwCJ7.png","2015-07-31 10:38:02","2015-07-31 10:38:02");
					


			DROP TABLE np_currency;

            CREATE TABLE `np_currency` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `currency_symbol` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `currency_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

					INSERT INTO np_currency VALUES("1","$","USD","2015-06-08 00:01:35","2015-06-08 00:01:35");
					INSERT INTO np_currency VALUES("2","&pound;","GBP","2015-06-08 00:01:50","2015-06-08 00:02:19");
					INSERT INTO np_currency VALUES("3","&euro;","EUR","2015-06-08 00:02:42","2015-06-08 00:02:42");
					


			DROP TABLE np_email;

            CREATE TABLE `np_email` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sender_id` int(10) unsigned NOT NULL,
  `receiver_id` int(10) unsigned NOT NULL,
  `subject` longtext COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `sender_red` int(11) NOT NULL,
  `receiver_red` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `parent` int(11) DEFAULT NULL,
  `sender_delete` int(11) DEFAULT '0',
  `receiver_delete` int(11) DEFAULT '0',
  `admin_active` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `email_sender_id_foreign` (`sender_id`),
  KEY `email_receiver_id_foreign` (`receiver_id`),
  CONSTRAINT `email_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `np_member` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `email_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `np_member` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

					INSERT INTO np_email VALUES("5","1","3","test","this is my test","0","1","2015-07-10 07:08:48","2015-07-10 07:08:51","0","0","0","0");
					INSERT INTO np_email VALUES("7","2","3","test quality and my request","sddsfsd","1","1","2015-07-10 18:25:43","2015-07-14 02:23:43","0","0","0","0");
					INSERT INTO np_email VALUES("12","2","3","test","test","1","1","0000-00-00 00:00:00","2015-07-17 19:28:24","7","1","0","0");
					INSERT INTO np_email VALUES("13","3","2","fdsdfsd","dfsdfsdfsdfsdfds","1","1","0000-00-00 00:00:00","2015-07-14 06:44:49","7","0","1","0");
					INSERT INTO np_email VALUES("14","3","2","dfsdsfdsdfsd","fgdfgdf dfg dgdsfg dfs gs","1","1","0000-00-00 00:00:00","2015-07-17 19:26:11","7","1","0","0");
					INSERT INTO np_email VALUES("15","2","3","test email to forestfuture","This is my test with forestfuture","1","0","2015-07-17 19:20:52","2015-07-17 19:20:52","7","0","0","0");
					INSERT INTO np_email VALUES("16","2","2","TEst","This is test for ","1","0","2016-01-20 15:14:55","2016-01-20 15:14:55","0","0","0","0");
					INSERT INTO np_email VALUES("17","2","2","list test","This is my list test.","1","0","2016-01-20 15:15:29","2016-01-20 15:15:29","0","0","0","0");
					


			DROP TABLE np_emailtemplate;

            CREATE TABLE `np_emailtemplate` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` longtext COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

					INSERT INTO np_emailtemplate VALUES("1","Confirm Seller","<h2><span style=\"background-color: #ffffff;\">Confirm Seller</span></h2>
<p>Amdin approved you as seller.</p>
<p>You can post product and you can bid to RFQ</p>","2015-06-23 22:17:04","2015-06-23 23:14:12");
					INSERT INTO np_emailtemplate VALUES("2","Suspend","<h2>Suspend Account</h2>
<p>&nbsp;</p>
<p>Your account is suspended by admin.</p>
<p>&nbsp;</p>","2015-06-24 00:08:34","2015-06-24 00:08:34");
					INSERT INTO np_emailtemplate VALUES("3","Not Suspend","<h2>Account Restore</h2>
<p>&nbsp;</p>
<p>Your account restore by admin.</p>
<p>&nbsp;</p>
<p>You can login with your account in http://purchasetree.com</p>","2015-06-24 00:10:03","2015-06-24 00:10:03");
					INSERT INTO np_emailtemplate VALUES("4","Create Quote","<p>Seller &nbsp;created quote for your RFQ.</p>
<p>You can request sample or you can do order with him.</p>
<p>It will be good for you.</p>
<p>Best Regards</p>
<p>Purchasetree support team</p>","2015-07-20 01:25:33","2015-07-20 01:25:33");
					INSERT INTO np_emailtemplate VALUES("5","Sample request approved to seller","<p>Buyer sample request approved by admin.&nbsp;</p>
<p>When this product send to buyer, you can get fund from admin.</p>
<p>From purchasetree admin.</p>","2015-07-29 12:42:49","2015-07-29 12:42:49");
					INSERT INTO np_emailtemplate VALUES("6","Sample request approved to buyer","<p>Your sample request approved by admin.</p>
<p>Seller will be send product &nbsp;to you.</p>
<p>When seller send product, you can get tracking number from seller, &nbsp;you can get product.</p>
<p>When you get product, Please &nbsp;approve about that .</p>
<p>From purchasetree admin.</p>","2015-07-29 12:49:24","2015-07-29 12:49:24");
					


			DROP TABLE np_employees;

            CREATE TABLE `np_employees` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `employees` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

					INSERT INTO np_employees VALUES("1","Less than 5 People","0000-00-00 00:00:00","0000-00-00 00:00:00");
					INSERT INTO np_employees VALUES("2","5 - 10 People","0000-00-00 00:00:00","0000-00-00 00:00:00");
					INSERT INTO np_employees VALUES("3","11 - 50 People","0000-00-00 00:00:00","0000-00-00 00:00:00");
					INSERT INTO np_employees VALUES("4","51 - 100 People","0000-00-00 00:00:00","0000-00-00 00:00:00");
					INSERT INTO np_employees VALUES("5","101-500 People","0000-00-00 00:00:00","0000-00-00 00:00:00");
					INSERT INTO np_employees VALUES("6","501 - 1000 People","0000-00-00 00:00:00","0000-00-00 00:00:00");
					INSERT INTO np_employees VALUES("7","Above 1000 People","0000-00-00 00:00:00","0000-00-00 00:00:00");
					INSERT INTO np_employees VALUES("8","Freelance","0000-00-00 00:00:00","0000-00-00 00:00:00");
					INSERT INTO np_employees VALUES("9","10,000","0000-00-00 00:00:00","0000-00-00 00:00:00");
					


			DROP TABLE np_escrow_admin;

            CREATE TABLE `np_escrow_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `commission` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `is_admin` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

					INSERT INTO np_escrow_admin VALUES("1","","","15","","0000-00-00 00:00:00","2015-08-19 21:58:22");
					


			DROP TABLE np_escrow_dispute;

            CREATE TABLE `np_escrow_dispute` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `escrow_table_id` int(10) unsigned NOT NULL,
  `escrow_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `escrow_user_id` int(10) NOT NULL,
  `admin_active` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `escrow_dispute_escrow_table_id_foreign` (`escrow_table_id`),
  CONSTRAINT `escrow_dispute_escrow_table_id_foreign` FOREIGN KEY (`escrow_table_id`) REFERENCES `np_escrow_escrow` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

					INSERT INTO np_escrow_dispute VALUES("1","5","7","This is not good ","I didn\'t get product from seller","2015-09-16 20:36:23","2015-09-16 20:36:23","2","0");
					INSERT INTO np_escrow_dispute VALUES("2","4","26","This is my test","This is my test dispute","2015-09-17 18:34:51","2015-09-17 18:34:51","2","0");
					INSERT INTO np_escrow_dispute VALUES("3","4","26GK7EUYUP","Test","This is test for escrow admin
","2015-09-18 05:19:56","2015-09-18 05:19:56","0","0");
					INSERT INTO np_escrow_dispute VALUES("4","4","26GK7EUYUP","Seller","This is my test for seller","2015-09-18 05:22:26","2015-09-18 05:22:26","0","0");
					INSERT INTO np_escrow_dispute VALUES("5","4","26GK7EUYUP","Total","This is my test","2015-09-18 05:24:12","2015-09-18 05:24:12","0","0");
					INSERT INTO np_escrow_dispute VALUES("6","4","26GK7EUYUP","This is test","This is our test","2015-09-18 05:37:21","2015-09-18 05:37:21","0","0");
					


			DROP TABLE np_escrow_escrow;

            CREATE TABLE `np_escrow_escrow` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `escrow_id` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `quote_id` int(10) unsigned NOT NULL,
  `seller_id` int(10) unsigned NOT NULL,
  `buyer_id` int(10) unsigned NOT NULL,
  `item` longtext COLLATE utf8_unicode_ci NOT NULL,
  `price` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(250) COLLATE utf8_unicode_ci NOT NULL COMMENT '1:escrow, 2:pay,3:dispute,4:cancel,5:approved',
  `date` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `confirm` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `total` varchar(45) COLLATE utf8_unicode_ci DEFAULT '0',
  `type` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `invoice_number` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `transaction_id` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `avs_response` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cvv_response` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bank_info` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `escrowDate` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `approvedDate` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cancelDate` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `disputedDate` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `confirmDate` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `admin_active` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `escrow_escrow_seller_id_foreign` (`seller_id`),
  KEY `escrow_escrow_buyer_id_foreign` (`buyer_id`),
  KEY `escrow_escrow_quote_id_foreign` (`quote_id`),
  CONSTRAINT `escrow_escrow_buyer_id_foreign` FOREIGN KEY (`buyer_id`) REFERENCES `np_escrow_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `escrow_escrow_quote_id_foreign` FOREIGN KEY (`quote_id`) REFERENCES `np_seller_quote` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `escrow_escrow_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `np_escrow_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

					INSERT INTO np_escrow_escrow VALUES("4","26GK7EUYUP","4","1","2","forest company title","189.12","2","2015-08-19 02:42:50","1","2016-03-28 01:42:50","2016-03-28 00:14:42","189.12","credit","340084","20150927231358-080880-340084","AVS Match 9 Digit Zip and Address (X)","CVV2 Match (M)","","2015-09-28","","","","","0");
					INSERT INTO np_escrow_escrow VALUES("5","7ER7BKWZ4A","5","1","2","forest test","215","1","2015-09-16 23:29:03","1","2016-03-27 19:29:03","2015-09-21 10:06:36","0","wire","test dd","","","","ttes t","","","","","","0");
					


			DROP TABLE np_escrow_message_template;

            CREATE TABLE `np_escrow_message_template` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

					INSERT INTO np_escrow_message_template VALUES("1","","<p>This is my test.</p>
<p>My email address is <a href=\"mailto:alexander.petrob198929@gmail.com\">alexander.petrob198929@gmail.com</a>.</p>
<p>This is my test result for query.</p>","electronic","2015-09-16 23:54:47","2015-09-16 23:58:20");
					INSERT INTO np_escrow_message_template VALUES("3","Payment Issue","This is our payment issue. I want to remove it in your blank","email","2015-09-17 01:55:22","2015-09-17 01:55:22");
					INSERT INTO np_escrow_message_template VALUES("4","Test with client","This is my client test for admin email","email","2015-09-20 15:31:35","2015-09-20 15:31:35");
					


			DROP TABLE np_escrow_pages;

            CREATE TABLE `np_escrow_pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `page_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `page_content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

					INSERT INTO np_escrow_pages VALUES("1","Terms","<h1>Terms</h1>
<p>&nbsp;</p>
<p>By participating in our escrow services you indicate your acceptance of these Terms and your consent to be bound by them. Our terms for participation in our services is as follows:</p>
<p>&nbsp;1) Escrow is only available for lawful purposes. Payments are limited to U.S. dollars. Applicable state or federal laws and regulations may limit the escrow services.</p>
<p>&nbsp;</p>
<p>2) It is at our sole discretion to refuse to complete any escrow transaction that we have reason to believe &nbsp; &nbsp; &nbsp;may violate any law.</p>
<p>&nbsp; &nbsp; Each user agrees to indemnify and hold us harmless for any losses resulting from any use or attempted use of our services in violation of these Terms.<br /><br /></p>
<p>&nbsp;</p>","2015-08-20 22:54:51","2015-08-20 23:01:30");
					


			DROP TABLE np_escrow_payment;

            CREATE TABLE `np_escrow_payment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `total` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `invoice_number` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `transaction_id` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `avs_response` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cvv_response` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bank_info` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `escrow_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `quote_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

					INSERT INTO np_escrow_payment VALUES("2","189.12","wire","123","","","","test","2015-08-19 11:27:12","2015-09-15 23:44:22","26GK7EUYUP","4");
					


			DROP TABLE np_escrow_users;

            CREATE TABLE `np_escrow_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `purchasetree_id` int(10) unsigned NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `userpass` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `userfullname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `useremail` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `userbusiness` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `useraddress1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `useraddress2` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `usercity` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `userstate` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `userzip` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `usercountry` int(11) NOT NULL,
  `paymentaccepttype` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `registrationdate` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `admin_active` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `escrow_users_purchasetree_id_foreign` (`purchasetree_id`),
  CONSTRAINT `escrow_users_purchasetree_id_foreign` FOREIGN KEY (`purchasetree_id`) REFERENCES `np_member` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

					INSERT INTO np_escrow_users VALUES("1","2","forestfuture89","4124bc0a9335c27f086f24ba207a4912","forest chany","forestfuture89@gmail.com","forest chany","tulkork","","phnompenh","phnompenh","12531","4","paypal","2015-08-20 09:40:22","2015-08-18 00:05:47","2016-03-29 19:33:40","1");
					INSERT INTO np_escrow_users VALUES("2","3","forestfuture","4124bc0a9335c27f086f24ba207a4912","forest test","alex.petro198929@gmail.com","forest test","tulkork","","phnompenh","phnompenh","12531","4","paypal","2015-08-18 16:03:46","2015-08-18 12:03:46","2015-08-18 12:03:46","0");
					


			DROP TABLE np_factorysize;

            CREATE TABLE `np_factorysize` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `factorysize` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

					INSERT INTO np_factorysize VALUES("1","Below 1,000 square meters","2015-06-03 14:59:28","2015-06-03 14:59:28");
					


			DROP TABLE np_fee;

            CREATE TABLE `np_fee` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fee` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

					INSERT INTO np_fee VALUES("2","15","2015-07-27 12:56:50","2015-07-27 12:56:50");
					


			DROP TABLE np_freight_code;

            CREATE TABLE `np_freight_code` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

					INSERT INTO np_freight_code VALUES("2","Kg","2016-04-13 15:17:18","2016-04-13 15:17:18");
					INSERT INTO np_freight_code VALUES("3","Lb","2016-04-13 15:17:53","2016-04-13 15:17:53");
					


			DROP TABLE np_help;

            CREATE TABLE `np_help` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(10) unsigned NOT NULL,
  `subcategory_id` int(10) unsigned NOT NULL,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `help_category_id_foreign` (`category_id`),
  KEY `help_subcategory_id_foreign` (`subcategory_id`),
  CONSTRAINT `help_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `np_helpcategory` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `help_subcategory_id_foreign` FOREIGN KEY (`subcategory_id`) REFERENCES `np_helpsubcategory` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

					INSERT INTO np_help VALUES("1","2","2","What is purchasetree.com","<p class=\"MsoNormal\" style=\" background: white;\"><span style=\"font-family: arial; font-size: 10pt;\">Alibaba.com is the leading platform for global wholesale trade serving millions of buyers and suppliers around the world. Through Alibaba.com, businesses can sell their products to companies in other countries.</span></p>
<p>&nbsp;</p>
<h4><span style=\"font-family: arial; font-size: 10pt;\">Key roles and processes at Alibaba.com</span></h4>
<p>&nbsp;</p>
<p class=\"MsoNormal\" style=\"margin: 0cm 0cm 0pt; background: white;\"><span style=\"font-family: arial; font-size: 10pt;\">Suppliers (or exporters) post company information and product information (together with photos, descriptions, specifications, shipping terms, etc.) on Alibaba.com.&nbsp;</span></p>
<p>&nbsp;</p>
<p class=\"MsoNormal\" style=\"text-align: left; margin: 0cm 0cm 3pt 0.75pt; background: white; mso-pagination: widow-orphan; mso-margin-top-alt: auto;\" align=\"left\"><span style=\"font-family: arial; font-size: 10pt;\">Buyers (or importers) search and browse supplier\'s products and then make inquiries to negotiate or place orders. <br /></span></p>
<p>&nbsp;</p>
<p class=\"MsoNormal\" style=\"text-align: left; margin: 0cm 0cm 3pt 0.75pt; background: white; mso-pagination: widow-orphan; mso-margin-top-alt: auto;\" align=\"left\"><span style=\"font-family: arial; font-size: 10pt;\">Whether you want to sell or buy on Alibaba.com, <a href=\"http://us.my.alibaba.com/user/join/join_step1.htm\"><span style=\"color: #003399;\">join free today!</span></a><strong><span style=\"font-weight: normal;\"><br /></span></strong></span></p>
<p>&nbsp;</p>
<h5><span style=\"font-family: arial; font-size: 10pt;\">* Some restrictions apply: If your company operates from within China (mainland), it is required that you join as a \"Gold Supplier\" before you can use certain selling functions. For more details, <a href=\"http://exporter.alibaba.com/\"><span style=\"color: #003399;\">click here</span></a>.</span></h5>
<p>&nbsp;</p>","2015-06-19 17:56:21","2015-06-19 19:04:25");
					INSERT INTO np_help VALUES("2","2","3","How can I check the location of an IP address?","<p>You can check the location through a WHOIS search:</p>
<p>1. Go to a WHOIS search site (http://www.whois-search.com/)</p>
<p>2. Enter the IP Address into the WHOIS search box (e.g. 121.0.31.184)</p>
<p>3. Click \"Go\". The registered location of the IP address will be shown in the results page.</p>","2015-06-20 00:31:51","2015-06-21 18:47:47");
					INSERT INTO np_help VALUES("3","3","4","How can register","<p>This is our test with my client</p>","2015-06-22 18:07:55","2015-06-22 18:07:55");
					


			DROP TABLE np_helpcategory;

            CREATE TABLE `np_helpcategory` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `categoryname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

					INSERT INTO np_helpcategory VALUES("2","About  Purchasetree","2015-06-19 12:08:34","2015-06-19 12:08:34");
					INSERT INTO np_helpcategory VALUES("3","Account","2015-06-19 15:37:17","2015-06-19 15:37:17");
					


			DROP TABLE np_helpsubcategory;

            CREATE TABLE `np_helpsubcategory` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(10) unsigned NOT NULL,
  `subcategoryname` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `helpsubcategory_category_id_foreign` (`category_id`),
  CONSTRAINT `helpsubcategory_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `np_helpcategory` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

					INSERT INTO np_helpsubcategory VALUES("2","2","Purchasetree.com Introduce","2015-06-19 12:20:15","2015-06-19 12:20:15");
					INSERT INTO np_helpsubcategory VALUES("3","2","Difference between Alibaba.com and AliExpress.com","2015-06-19 15:37:42","2015-06-19 15:37:42");
					INSERT INTO np_helpsubcategory VALUES("4","3","Registration","2015-06-19 15:38:07","2015-06-19 15:38:07");
					INSERT INTO np_helpsubcategory VALUES("5","3","Sign in","2015-06-19 15:38:25","2015-06-19 15:38:25");
					INSERT INTO np_helpsubcategory VALUES("6","3","Account Management","2015-06-19 15:38:52","2015-06-19 15:38:52");
					


			DROP TABLE np_member;

            CREATE TABLE `np_member` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `userpassword` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `firstname` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `street` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `zipcode` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `phonenumber` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `workingnumber` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `companyname` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `usertype` int(11) NOT NULL,
  `suspend` int(11) NOT NULL DEFAULT '0',
  `sellrequest` int(11) NOT NULL DEFAULT '0',
  `sellconfirm` int(11) NOT NULL DEFAULT '0',
  `previostype` int(11) NOT NULL DEFAULT '0',
  `changeDate` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `country_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` int(11) DEFAULT '0',
  `email_status` int(11) DEFAULT '0',
  `admin_active` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `member_country_id_foreign` (`country_id`),
  CONSTRAINT `member_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `np_country` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

					INSERT INTO np_member VALUES("1","admin","4124bc0a9335c27f086f24ba207a4912","alexander","chany","forestfuture1289@gmail.com","tulkork","phnom penh","fdf","12531","855972493800","855972493800","forest company","3","0","1","1","1","","4","2016-03-22 10:52:02","2016-03-29 16:46:58","1","1","1");
					INSERT INTO np_member VALUES("2","forestfuture89","c8bc8526f5b077fd7e77bba51731b452","forest","chany","forestfuture89@gmail.com","phnompenh","phnompenh","","12531","855972493800","855972493800","forestcompany","1","0","0","0","0","","4","2016-02-28 19:44:04","2016-02-17 16:35:57","1","1","0");
					INSERT INTO np_member VALUES("3","forestfuture","c8bc8526f5b077fd7e77bba51731b452","forest","chany","alex.petro198929@gmail.com","turlkork","turlkork","","12531","8550972493800","","","2","0","0","0","1","","4","2016-03-28 01:09:13","2016-03-29 16:45:42","1","1","1");
					INSERT INTO np_member VALUES("5","forest","1323089502d4fb070e2c958090b1ae97","forest","chany","alexander.anikin89123@gmail.com","forest","phnompenh","","12531","9832432423","","","3","0","0","1","3","","4","2015-12-28 00:15:17","2015-10-06 00:22:15","1","1","0");
					INSERT INTO np_member VALUES("9","alexander.anikin89","4124bc0a9335c27f086f24ba207a4912","alexander","anikin","alexander.anikin89@gmail.com","odessa","odessa","","41000","03870288343","","","2","0","0","0","0","","219","2016-01-06 16:11:09","2016-01-06 20:06:40","1","1","0");
					


			DROP TABLE np_migrations;

            CREATE TABLE `np_migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

					INSERT INTO np_migrations VALUES("2015_06_01_212832_create_admin_user_table","1");
					INSERT INTO np_migrations VALUES("2015_06_03_134700_create_country_table","2");
					INSERT INTO np_migrations VALUES("2015_06_03_184016_create_factorysize_table","3");
					INSERT INTO np_migrations VALUES("2015_06_03_191430_create_businesstype_table","4");
					INSERT INTO np_migrations VALUES("2015_06_03_193425_create_employees_table","5");
					INSERT INTO np_migrations VALUES("2015_06_03_193821_create_productfocus_table","5");
					INSERT INTO np_migrations VALUES("2015_06_03_203929_create_category_table","6");
					INSERT INTO np_migrations VALUES("2015_06_03_210739_create_subcategory_table","7");
					INSERT INTO np_migrations VALUES("2015_06_04_032001_create_member_table","8");
					INSERT INTO np_migrations VALUES("2015_06_04_153634_create_companyprofiles_table","9");
					INSERT INTO np_migrations VALUES("2015_06_04_213952_create_member_modificate_status_table","10");
					INSERT INTO np_migrations VALUES("2015_06_05_145523_create_modify_companyprofile_table","11");
					INSERT INTO np_migrations VALUES("2015_06_06_190050_create_currency_table","12");
					INSERT INTO np_migrations VALUES("2015_06_07_202737_create_rfq_table","13");
					INSERT INTO np_migrations VALUES("2015_06_07_210610_create_rfq_picture_table","14");
					INSERT INTO np_migrations VALUES("2015_06_07_210759_create_rfq_file_table","15");
					INSERT INTO np_migrations VALUES("2015_06_07_210928_create_specification_table","16");
					INSERT INTO np_migrations VALUES("2015_06_07_211155_create_rfq_specificationpicture_table","17");
					INSERT INTO np_migrations VALUES("2015_06_12_104737_create_usercategory_table","18");
					INSERT INTO np_migrations VALUES("2015_06_12_133357_create_postproduct_table","19");
					INSERT INTO np_migrations VALUES("2015_06_12_134033_create_productpicture_table","19");
					INSERT INTO np_migrations VALUES("2015_06_19_150939_create_helpcategory_table","20");
					INSERT INTO np_migrations VALUES("2015_06_19_155937_create_helpsubcategory_table","21");
					INSERT INTO np_migrations VALUES("2015_06_19_163006_create_helpcreate_table","22");
					INSERT INTO np_migrations VALUES("2015_06_22_212300_create_modify_product_table","23");
					INSERT INTO np_migrations VALUES("2015_06_27_002849_create_usermaketingpicture_table","25");
					INSERT INTO np_migrations VALUES("2015_07_09_030048_create_email_table","26");
					INSERT INTO np_migrations VALUES("2015_07_14_054829_create_modify_email_table","27");
					INSERT INTO np_migrations VALUES("2015_07_19_111917_create_unit_table","28");
					INSERT INTO np_migrations VALUES("2015_07_20_013550_create_seller_quote_table","29");
					INSERT INTO np_migrations VALUES("2015_07_20_021630_create_seller_quote_note_table","30");
					INSERT INTO np_migrations VALUES("2015_07_20_021910_create_seller_quote_picture_table","31");
					INSERT INTO np_migrations VALUES("2015_07_20_023640_create_seller_quote_specification_table","32");
					INSERT INTO np_migrations VALUES("2015_06_24_014343_create_email_table","33");
					INSERT INTO np_migrations VALUES("2015_07_20_172008_create_rfq_email_table","34");
					INSERT INTO np_migrations VALUES("2015_07_23_054729_create_seller_sample_table","35");
					INSERT INTO np_migrations VALUES("2015_07_26_132515_create_buyer_card_table","36");
					INSERT INTO np_migrations VALUES("2015_07_27_010744_create_fee_table","37");
					INSERT INTO np_migrations VALUES("2015_08_11_194438_create_modify_product_table","38");
					INSERT INTO np_migrations VALUES("2015_08_12_184456_create_modify_seller_quote813_table","39");
					INSERT INTO np_migrations VALUES("2015_08_16_182913_create_seller_accept_table","40");
					INSERT INTO np_migrations VALUES("2015_08_17_204852_create_escrow_users_table","41");
					INSERT INTO np_migrations VALUES("2015_08_18_185216_create_escrow_admin_table","42");
					INSERT INTO np_migrations VALUES("2015_08_18_214553_create_escrow_escrow_table","43");
					INSERT INTO np_migrations VALUES("2015_08_19_142307_create_escrow_payment_table","44");
					INSERT INTO np_migrations VALUES("2015_08_20_095011_create_escrow_pages_table","45");
					INSERT INTO np_migrations VALUES("2015_08_21_213702_create_escrow_dispute_table","46");
					INSERT INTO np_migrations VALUES("2015_09_16_141815_create_modify_escrow_escrow916_table","47");
					INSERT INTO np_migrations VALUES("2015_09_17_023107_create_escrow_message_template_table","48");
					INSERT INTO np_migrations VALUES("2015_09_28_005237_create_modify_escrow_escrow28_table","49");
					INSERT INTO np_migrations VALUES("2015_11_26_081000_create_bargain_table","50");
					INSERT INTO np_migrations VALUES("2016_01_06_145457_create_member_modify_1_6_table","51");
					INSERT INTO np_migrations VALUES("2016_01_13_190422_create_user_category_table","52");
					INSERT INTO np_migrations VALUES("2016_01_14_034922_create_user_sub_category_table","53");
					INSERT INTO np_migrations VALUES("2016_02_05_212928_create_quick_details_table","54");
					INSERT INTO np_migrations VALUES("2016_02_13_074028_create_quick_detail_category_table","55");
					INSERT INTO np_migrations VALUES("2016_02_15_134217_create_product_quick_table","56");
					INSERT INTO np_migrations VALUES("2016_03_07_065209_create_additional_category_table","57");
					INSERT INTO np_migrations VALUES("2016_03_07_065417_create_product_additional_category_table","58");
					INSERT INTO np_migrations VALUES("2016_03_07_070217_create_addtional_image_table","59");
					INSERT INTO np_migrations VALUES("2016_03_07_134552_create_modify_product_20160307_table","60");
					INSERT INTO np_migrations VALUES("2016_03_29_160147_create_tables_modify_for_active_table","61");
					INSERT INTO np_migrations VALUES("2016_04_13_093804_create_freight_table","62");
					INSERT INTO np_migrations VALUES("2016_04_14_144952_create_product_shipping_table","63");
					


			DROP TABLE np_product;

            CREATE TABLE `np_product` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `category_id` int(10) unsigned NOT NULL,
  `subcategory_id` int(10) unsigned NOT NULL,
  `product_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `product_description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `meta` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `product_price1` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `price1_currency` int(11) NOT NULL,
  `product_price2` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `price2_currency` int(11) NOT NULL,
  `product_price3` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `price3_currency` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `min_order` varchar(255) COLLATE utf8_unicode_ci DEFAULT '0',
  `supply_ability` varchar(255) COLLATE utf8_unicode_ci DEFAULT '0',
  `min_order_unit` varchar(255) COLLATE utf8_unicode_ci DEFAULT '0',
  `supply_ability_unit` varchar(255) COLLATE utf8_unicode_ci DEFAULT '0',
  `additional_category_id` int(11) DEFAULT '0',
  `admin_active` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `product_user_id_foreign` (`user_id`),
  KEY `product_category_id_foreign` (`category_id`),
  KEY `product_subcategory_id_foreign` (`subcategory_id`),
  CONSTRAINT `product_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `np_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `product_subcategory_id_foreign` FOREIGN KEY (`subcategory_id`) REFERENCES `np_subcategory` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `product_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `np_member` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

					INSERT INTO np_product VALUES("5","1","2","4","test","<p> This is our test</p>","sdfsdf","23.2","3","20.2","3","18.2","3","2015-06-12 12:36:12","2016-04-18 16:23:21","10","300","2","2","0","1");
					INSERT INTO np_product VALUES("6","1","1","1","test product","This is our test","test product","23.21","3","20.21","3","18","3","2015-06-12 12:37:33","2015-06-13 09:38:14","5","300","3","3","0","0");
					INSERT INTO np_product VALUES("7","1","1","1","Product test","This is my test with client","product","20.87","3","18.97","3","18.77","3","2016-03-27 21:23:38","2016-04-18 19:07:02","15","600","3","3","0","1");
					INSERT INTO np_product VALUES("8","1","1","1","Test for new category with me","This is test for new category function with me","test with me","121","3","111","3","41","3","2016-03-28 02:53:36","2016-03-31 14:53:08","121","2131","2","2","3","1");
					INSERT INTO np_product VALUES("9","2","1","1","Quick Detail test Product","Hello.
This is my test product for quick detail test with client.","meta","25.55","3","23.55","3","21.55","3","2016-02-15 16:00:20","2016-04-18 19:21:49","31","323","2","2","0","1");
					INSERT INTO np_product VALUES("10","1","1","1","amazon product","This is my test account ","amazon","11.21","3","10.21","3","9.21","3","2016-03-07 14:29:59","2016-03-07 14:29:59","12","222222","3","3","3","0");
					INSERT INTO np_product VALUES("11","1","2","3","admin amazon test","This is my test ","amazon","12.21","2","11.21","2","10.21","2","2016-03-11 22:15:56","2016-03-12 15:02:36","12","2000","3","3","3","0");
					INSERT INTO np_product VALUES("14","2","1","1","New front end test","This is my front end  test description","front end","12.1","2","11.1","2","10.1","2","2016-03-31 21:13:00","2016-04-01 16:02:29","8","12000","2","2","3","1");
					INSERT INTO np_product VALUES("15","2","1","1","Print test","This is print test","1","12","2","11","2","10","2","2016-04-01 16:07:17","2016-04-01 16:08:00","1","123232","2","2","3","1");
					INSERT INTO np_product VALUES("16","2","1","1","New Design Products for shoe","This is test for new design product.","new design","12","2","11","3","9.21","3","2016-04-14 16:31:12","2016-04-18 19:07:00","5","2000","4","4","1","1");
					INSERT INTO np_product VALUES("17","1","2","3","admin new design","This is test for new design","12","11","3","10.3","3","9.7","3","2016-04-18 16:06:27","2016-04-18 16:06:48","5","20000","2","2","1","1");
					


			DROP TABLE np_product_additional_category;

            CREATE TABLE `np_product_additional_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  `additional_category_id` int(10) unsigned NOT NULL,
  `values` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `product_additional_category_user_id_foreign` (`user_id`),
  KEY `product_additional_category_product_id_foreign` (`product_id`),
  KEY `product_additional_category_additional_category_id_foreign` (`additional_category_id`),
  CONSTRAINT `product_additional_category_additional_category_id_foreign` FOREIGN KEY (`additional_category_id`) REFERENCES `np_additional_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `product_additional_category_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `np_product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `product_additional_category_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `np_member` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

					INSERT INTO np_product_additional_category VALUES("5","1","10","3","Red","1","2016-03-07 14:30:00","2016-03-07 14:30:00");
					INSERT INTO np_product_additional_category VALUES("6","1","10","3","Navy","1","2016-03-07 14:30:00","2016-03-07 14:30:00");
					INSERT INTO np_product_additional_category VALUES("7","1","10","3","Blue","1","2016-03-07 14:30:00","2016-03-07 14:30:00");
					INSERT INTO np_product_additional_category VALUES("9","1","10","3","Small","0","2016-03-08 10:26:03","2016-03-08 10:26:03");
					INSERT INTO np_product_additional_category VALUES("10","1","10","3","X-Large","0","2016-03-08 10:26:03","2016-03-08 10:26:03");
					INSERT INTO np_product_additional_category VALUES("11","1","10","3","Medium","0","2016-03-08 10:26:03","2016-03-08 10:26:03");
					INSERT INTO np_product_additional_category VALUES("12","1","10","3","Large","0","2016-03-08 10:26:03","2016-03-08 10:26:03");
					INSERT INTO np_product_additional_category VALUES("13","1","10","3","Black","1","2016-03-08 10:26:03","2016-03-08 10:26:03");
					INSERT INTO np_product_additional_category VALUES("18","1","11","3","Red","1","2016-03-11 22:15:56","2016-03-11 22:15:56");
					INSERT INTO np_product_additional_category VALUES("19","1","11","3","Navy","1","2016-03-11 22:15:56","2016-03-11 22:15:56");
					INSERT INTO np_product_additional_category VALUES("20","1","11","3","Blue","1","2016-03-11 22:15:56","2016-03-11 22:15:56");
					INSERT INTO np_product_additional_category VALUES("21","1","11","3","Green","1","2016-03-11 22:15:56","2016-03-11 22:15:56");
					INSERT INTO np_product_additional_category VALUES("30","1","11","3","Small","0","2016-03-12 15:02:36","2016-03-12 15:02:36");
					INSERT INTO np_product_additional_category VALUES("31","1","11","3","Medium","0","2016-03-12 15:02:36","2016-03-12 15:02:36");
					INSERT INTO np_product_additional_category VALUES("32","1","11","3","Large","0","2016-03-12 15:02:36","2016-03-12 15:02:36");
					INSERT INTO np_product_additional_category VALUES("33","1","11","3","X-Large","0","2016-03-12 15:02:36","2016-03-12 15:02:36");
					INSERT INTO np_product_additional_category VALUES("36","1","8","3","Red","1","2016-03-31 14:53:08","2016-03-31 14:53:08");
					INSERT INTO np_product_additional_category VALUES("37","1","8","3","Navy","1","2016-03-31 14:53:08","2016-03-31 14:53:08");
					INSERT INTO np_product_additional_category VALUES("41","1","8","3","small","0","2016-03-31 15:45:25","2016-03-31 15:45:25");
					INSERT INTO np_product_additional_category VALUES("42","1","8","3","Medium","0","2016-03-31 15:45:25","2016-03-31 15:45:25");
					INSERT INTO np_product_additional_category VALUES("43","1","8","3","2T","0","2016-03-31 15:45:25","2016-03-31 15:45:25");
					INSERT INTO np_product_additional_category VALUES("47","2","14","3","Red","1","2016-03-31 21:13:00","2016-03-31 21:13:00");
					INSERT INTO np_product_additional_category VALUES("48","2","14","3","Navy","1","2016-03-31 21:13:00","2016-03-31 21:13:00");
					INSERT INTO np_product_additional_category VALUES("49","2","14","3","Blue","1","2016-03-31 21:13:00","2016-03-31 21:13:00");
					INSERT INTO np_product_additional_category VALUES("50","2","14","3","Pink","1","2016-03-31 21:13:00","2016-03-31 21:13:00");
					INSERT INTO np_product_additional_category VALUES("51","2","15","3","Medium","0","2016-04-01 16:07:17","2016-04-01 16:07:17");
					INSERT INTO np_product_additional_category VALUES("52","2","15","3","Small","0","2016-04-01 16:07:17","2016-04-01 16:07:17");
					INSERT INTO np_product_additional_category VALUES("53","2","15","3","Red","1","2016-04-01 16:07:17","2016-04-01 16:07:17");
					INSERT INTO np_product_additional_category VALUES("54","2","15","3","Nay","1","2016-04-01 16:07:17","2016-04-01 16:07:17");
					INSERT INTO np_product_additional_category VALUES("55","2","14","3","Small","0","2016-04-02 03:29:49","2016-04-02 03:29:49");
					INSERT INTO np_product_additional_category VALUES("56","2","14","3","Medium","0","2016-04-02 03:29:49","2016-04-02 03:29:49");
					INSERT INTO np_product_additional_category VALUES("57","2","14","3","Large","0","2016-04-02 03:29:49","2016-04-02 03:29:49");
					INSERT INTO np_product_additional_category VALUES("58","2","14","3","X-Large","0","2016-04-02 03:29:49","2016-04-02 03:29:49");
					INSERT INTO np_product_additional_category VALUES("59","2","14","3","Green","1","2016-04-02 03:29:49","2016-04-02 03:29:49");
					INSERT INTO np_product_additional_category VALUES("63","2","16","1","Small","0","2016-04-14 17:18:46","2016-04-14 17:18:46");
					INSERT INTO np_product_additional_category VALUES("64","2","16","1","Medium","0","2016-04-14 17:18:46","2016-04-14 17:18:46");
					INSERT INTO np_product_additional_category VALUES("65","2","16","1","X-Large","0","2016-04-14 17:18:46","2016-04-14 17:18:46");
					INSERT INTO np_product_additional_category VALUES("72","1","17","1","Small","0","2016-04-18 16:58:37","2016-04-18 16:58:37");
					INSERT INTO np_product_additional_category VALUES("73","1","17","1","Large","0","2016-04-18 16:58:37","2016-04-18 16:58:37");
					INSERT INTO np_product_additional_category VALUES("74","1","17","1","Medium","0","2016-04-18 16:58:37","2016-04-18 16:58:37");
					


			DROP TABLE np_product_additional_image;

            CREATE TABLE `np_product_additional_image` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  `additional_category_id` int(10) unsigned NOT NULL,
  `product_additional_category_id` int(10) unsigned NOT NULL,
  `image_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `product_additional_image_user_id_foreign` (`user_id`),
  KEY `product_additional_image_product_id_foreign` (`product_id`),
  KEY `product_additional_image_additional_category_id_foreign` (`additional_category_id`),
  KEY `product_additional_image_product_additional_category_id_foreign` (`product_additional_category_id`),
  CONSTRAINT `product_additional_image_additional_category_id_foreign` FOREIGN KEY (`additional_category_id`) REFERENCES `np_additional_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `product_additional_image_product_additional_category_id_foreign` FOREIGN KEY (`product_additional_category_id`) REFERENCES `np_product_additional_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `product_additional_image_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `np_product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `product_additional_image_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `np_member` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

					INSERT INTO np_product_additional_image VALUES("24","1","10","3","5","sjwOqlbBb87fDFbfJw7gWG6D.gif","","2016-03-08 11:11:57","2016-03-08 11:11:57");
					INSERT INTO np_product_additional_image VALUES("25","1","10","3","5","ROCZraIYeh09TuWL9e6KMlOq.jpg","","2016-03-08 11:11:58","2016-03-08 11:11:58");
					INSERT INTO np_product_additional_image VALUES("26","1","10","3","5","LCtWQakwG9T1eJswY40BIKh5.jpg","","2016-03-08 11:11:58","2016-03-08 11:11:58");
					INSERT INTO np_product_additional_image VALUES("27","1","10","3","6","cIbs23rXRK6oyMEKbhLwDHYS.jpg","","2016-03-08 11:11:58","2016-03-08 11:11:58");
					INSERT INTO np_product_additional_image VALUES("28","1","10","3","6","QDChzVcNLf5gpMku880UVsaf.jpg","","2016-03-08 11:11:58","2016-03-08 11:11:58");
					INSERT INTO np_product_additional_image VALUES("29","1","10","3","7","XAbNUBMntysJhnjYIHvc7bnB.jpg","","2016-03-08 11:11:58","2016-03-08 11:11:58");
					INSERT INTO np_product_additional_image VALUES("30","1","10","3","7","B7oMegDzK0QDA6uTBEZmyZEc.jpg","","2016-03-08 11:11:58","2016-03-08 11:11:58");
					INSERT INTO np_product_additional_image VALUES("31","1","10","3","13","zKQS9JmgE3G78EwjE0dSKLiD.gif","","2016-03-08 11:11:58","2016-03-08 11:11:58");
					INSERT INTO np_product_additional_image VALUES("32","1","10","3","13","rlfc4XwRiBVNcJTNaEPYscqd.jpg","","2016-03-08 11:11:58","2016-03-08 11:11:58");
					INSERT INTO np_product_additional_image VALUES("33","1","11","3","18","FhIx9LqRkEI0Wo4FhRAqbv43.jpg","","2016-03-11 22:16:41","2016-03-11 22:16:41");
					INSERT INTO np_product_additional_image VALUES("34","1","11","3","19","x6BzlPQUXwSzLOrOBalExVeH.jpg","","2016-03-11 22:16:41","2016-03-11 22:16:41");
					INSERT INTO np_product_additional_image VALUES("35","1","11","3","20","X2TACXHpY3iWeOTzbIDX7u6k.jpg","","2016-03-11 22:16:41","2016-03-11 22:16:41");
					INSERT INTO np_product_additional_image VALUES("36","1","11","3","21","4m2r1r6TVl2rHpfej3rIGAlS.jpg","","2016-03-11 22:16:41","2016-03-11 22:16:41");
					INSERT INTO np_product_additional_image VALUES("41","1","8","3","36","4nAni1yQYr4JYuMFJN4jBhIZ.jpg","","2016-03-31 14:54:07","2016-03-31 14:54:07");
					INSERT INTO np_product_additional_image VALUES("42","1","8","3","36","55gxnFjJyPdGV6tGD7rLxBkE.jpg","","2016-03-31 14:54:07","2016-03-31 14:54:07");
					INSERT INTO np_product_additional_image VALUES("43","1","8","3","37","ZZdaUt4WHutiFuA2nkt6gOoA.jpg","","2016-03-31 14:54:07","2016-03-31 14:54:07");
					INSERT INTO np_product_additional_image VALUES("44","1","8","3","37","terVzbrvVy9eYV7LHqMRkUiH.jpg","","2016-03-31 14:54:07","2016-03-31 14:54:07");
					INSERT INTO np_product_additional_image VALUES("45","2","15","3","53","jdmJL9r07DUcyo2GxE8C71tC.jpg","","2016-04-01 16:07:41","2016-04-01 16:07:41");
					INSERT INTO np_product_additional_image VALUES("46","2","15","3","54","DBfqqACeaGTIoOMWMG7fUujL.jpg","","2016-04-01 16:07:42","2016-04-01 16:07:42");
					INSERT INTO np_product_additional_image VALUES("52","2","14","3","47","s3YSbMme2koQVBkXsy7rHtbv.jpg","","2016-04-02 03:53:00","2016-04-02 03:53:00");
					INSERT INTO np_product_additional_image VALUES("53","2","14","3","47","THhXTlspYEdveb4J2VkZnQrS.jpg","","2016-04-02 03:53:01","2016-04-02 03:53:01");
					INSERT INTO np_product_additional_image VALUES("54","2","14","3","48","VnGqajcp47nAqHM6elrYzJmX.jpg","","2016-04-02 03:53:01","2016-04-02 03:53:01");
					INSERT INTO np_product_additional_image VALUES("55","2","14","3","49","zLX94ikl9F6XCUjUtAsYXHRN.jpg","","2016-04-02 03:53:01","2016-04-02 03:53:01");
					INSERT INTO np_product_additional_image VALUES("56","2","14","3","50","J6uOmGtRGilTI8DsIevpGIoB.gif","","2016-04-02 03:53:01","2016-04-02 03:53:01");
					INSERT INTO np_product_additional_image VALUES("57","2","14","3","59","kZRGUtgM0yMHjv4e0x1lnJ5D.jpg","","2016-04-02 03:53:01","2016-04-02 03:53:01");
					


			DROP TABLE np_product_quick_details;

            CREATE TABLE `np_product_quick_details` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  `categoryname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `categorycontent` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `product_quick_details_user_id_foreign` (`user_id`),
  KEY `product_quick_details_product_id_foreign` (`product_id`),
  CONSTRAINT `product_quick_details_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `np_product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `product_quick_details_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `np_member` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

					INSERT INTO np_product_quick_details VALUES("12","2","9","Questions","color","2016-03-02 19:57:10","2016-03-02 19:57:10");
					INSERT INTO np_product_quick_details VALUES("13","2","9","Shoes","red","2016-03-02 19:57:11","2016-03-02 19:57:11");
					INSERT INTO np_product_quick_details VALUES("14","2","9","color","red","2016-03-02 19:57:11","2016-03-02 19:57:11");
					INSERT INTO np_product_quick_details VALUES("25","1","11","Questions","google","2016-03-12 15:02:36","2016-03-12 15:02:36");
					INSERT INTO np_product_quick_details VALUES("26","1","11","Shoes","ok","2016-03-12 15:02:37","2016-03-12 15:02:37");
					INSERT INTO np_product_quick_details VALUES("27","1","11","Color","red","2016-03-12 15:02:37","2016-03-12 15:02:37");
					INSERT INTO np_product_quick_details VALUES("28","1","11","result","test","2016-03-12 15:02:37","2016-03-12 15:02:37");
					INSERT INTO np_product_quick_details VALUES("32","2","15","Questions","great","2016-04-01 16:07:17","2016-04-01 16:07:17");
					INSERT INTO np_product_quick_details VALUES("33","2","15","Shoes","Blue Shoes","2016-04-01 16:07:17","2016-04-01 16:07:17");
					INSERT INTO np_product_quick_details VALUES("34","2","15","color","red","2016-04-01 16:07:17","2016-04-01 16:07:17");
					INSERT INTO np_product_quick_details VALUES("35","2","14","Questions","test","2016-04-02 03:29:49","2016-04-02 03:29:49");
					INSERT INTO np_product_quick_details VALUES("36","2","14","Shoes","red","2016-04-02 03:29:49","2016-04-02 03:29:49");
					INSERT INTO np_product_quick_details VALUES("37","2","14","color","blue","2016-04-02 03:29:49","2016-04-02 03:29:49");
					INSERT INTO np_product_quick_details VALUES("38","2","14","Google","Test","2016-04-02 03:29:49","2016-04-02 03:29:49");
					INSERT INTO np_product_quick_details VALUES("42","2","16","Questions","test","2016-04-14 17:18:46","2016-04-14 17:18:46");
					INSERT INTO np_product_quick_details VALUES("43","2","16","Shoes","test","2016-04-14 17:18:46","2016-04-14 17:18:46");
					INSERT INTO np_product_quick_details VALUES("44","2","16","test","sdfsd","2016-04-14 17:18:46","2016-04-14 17:18:46");
					INSERT INTO np_product_quick_details VALUES("51","1","17","Questions","test","2016-04-18 16:58:37","2016-04-18 16:58:37");
					INSERT INTO np_product_quick_details VALUES("52","1","17","Shoes","test","2016-04-18 16:58:37","2016-04-18 16:58:37");
					INSERT INTO np_product_quick_details VALUES("53","1","17","test","test","2016-04-18 16:58:37","2016-04-18 16:58:37");
					


			DROP TABLE np_product_shipping;

            CREATE TABLE `np_product_shipping` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  `shipping_type1` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `shipping_type2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `shipping_type3` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `flat_rate1` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `flat_rate2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `flat_rate3` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `estimated_time1` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `estimated_time2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `estimated_time3` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `add1` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `add2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `add3` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `product_shipping_user_id_foreign` (`user_id`),
  KEY `product_shipping_product_id_foreign` (`product_id`),
  CONSTRAINT `product_shipping_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `np_product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `product_shipping_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `np_member` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

					INSERT INTO np_product_shipping VALUES("2","2","16","1","2","3","12.21","","","    2 weeks ","    2 week ","    1 week ","3","","","2016-04-14 17:18:46","2016-04-14 17:18:46");
					INSERT INTO np_product_shipping VALUES("5","1","17","1","1","1","12","10.5","10","        2 days  ","        1 week  ","        2 week  ","3","3","3","2016-04-18 16:58:37","2016-04-18 16:58:37");
					


			DROP TABLE np_productfocus;

            CREATE TABLE `np_productfocus` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `productfocus` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

					INSERT INTO np_productfocus VALUES("2","Automobile","2015-06-03 15:55:29","2015-06-03 15:55:29");
					


			DROP TABLE np_productpicture;

            CREATE TABLE `np_productpicture` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  `picture_url` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `productpicture_user_id_foreign` (`user_id`),
  KEY `productpicture_product_id_foreign` (`product_id`),
  CONSTRAINT `productpicture_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `np_product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `productpicture_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `np_member` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=153 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

					INSERT INTO np_productpicture VALUES("38","1","7","0YiNr7nyfYZxzMSe7BBEkFr6.gif","2015-06-29 15:30:08","2015-06-29 15:30:08");
					INSERT INTO np_productpicture VALUES("39","1","7","wVUee9VHBuTDtpm1yjKWmnQh.jpg","2015-06-29 15:30:08","2015-06-29 15:30:08");
					INSERT INTO np_productpicture VALUES("40","1","7","vxnHcfdPA8aEAIV7N9jBiIlX.jpg","2015-06-29 15:30:08","2015-06-29 15:30:08");
					INSERT INTO np_productpicture VALUES("41","1","7","fRnRBhStpICXgqRDytdzSNrm.jpg","2015-06-29 15:30:08","2015-06-29 15:30:08");
					INSERT INTO np_productpicture VALUES("47","1","5","vZbdlFcCrBTwlweaGXHRTGDh.jpg","2015-08-12 04:10:08","2015-08-12 04:10:08");
					INSERT INTO np_productpicture VALUES("48","1","5","LGyLMfierBmghhPGm3hR0B9l.jpg","2015-08-12 04:10:08","2015-08-12 04:10:08");
					INSERT INTO np_productpicture VALUES("49","1","5","TFTShrin3dSGMHhknTu5XR6O.jpg","2015-08-12 04:10:08","2015-08-12 04:10:08");
					INSERT INTO np_productpicture VALUES("50","1","5","aKdX4H6hnyXA0oguytz4fO6Q.jpg","2015-08-12 04:10:08","2015-08-12 04:10:08");
					INSERT INTO np_productpicture VALUES("86","1","6","NIkRayA4gKii9ERozPeBHpkX.jpg","2016-01-27 21:13:18","2016-01-27 21:13:18");
					INSERT INTO np_productpicture VALUES("87","1","6","YJPdbVJkII0jQ0nGofprOBCO.jpg","2016-01-27 21:13:18","2016-01-27 21:13:18");
					INSERT INTO np_productpicture VALUES("88","1","6","fuaeV0LftzgOBnj86uxWIUH9.jpg","2016-01-27 21:13:18","2016-01-27 21:13:18");
					INSERT INTO np_productpicture VALUES("89","1","6","5Si0pG6UU38PVT35pgVQfSFB.jpg","2016-01-27 21:13:18","2016-01-27 21:13:18");
					INSERT INTO np_productpicture VALUES("90","1","6","CD7LHwkf8znYB9lyGAtgHNcZ.jpg","2016-01-27 21:13:18","2016-01-27 21:13:18");
					INSERT INTO np_productpicture VALUES("91","1","6","iwOT0sZGRDmCczJPQwqEoG3g.jpg","2016-01-27 21:13:18","2016-01-27 21:13:18");
					INSERT INTO np_productpicture VALUES("110","2","9","VBRqOl9H5c7bwJKoxBUfIevL.jpg","2016-03-02 19:57:10","2016-03-02 19:57:10");
					INSERT INTO np_productpicture VALUES("111","2","9","ILM4Mdj90Oik6dmUWd2hMFG7.jpg","2016-03-02 19:57:10","2016-03-02 19:57:10");
					INSERT INTO np_productpicture VALUES("117","1","10","ILM4Mdj90Oik6dmUWd2hMFG7.jpg","2016-03-08 11:11:57","2016-03-08 11:11:57");
					INSERT INTO np_productpicture VALUES("118","1","10","1IR050YbWinQLUkXLgLIcLu0.gif","2016-03-08 11:11:57","2016-03-08 11:11:57");
					INSERT INTO np_productpicture VALUES("119","1","10","pj00q9sXbB5SURfWRzEfpRF5.jpg","2016-03-08 11:11:57","2016-03-08 11:11:57");
					INSERT INTO np_productpicture VALUES("120","1","11","Zo1KXSbxYddTNAQWUap46pRu.gif","2016-03-11 22:16:41","2016-03-11 22:16:41");
					INSERT INTO np_productpicture VALUES("121","1","11","G3ppUAyHXIlv0c229LZeK2eK.png","2016-03-11 22:16:41","2016-03-11 22:16:41");
					INSERT INTO np_productpicture VALUES("129","1","8","erscwQUAZXkS4iEbitna0uvA.jpg","2016-03-31 14:54:07","2016-03-31 14:54:07");
					INSERT INTO np_productpicture VALUES("130","1","8","Af2FpkWfkfXiIhmFKPtszaD0.jpg","2016-03-31 14:54:07","2016-03-31 14:54:07");
					INSERT INTO np_productpicture VALUES("131","1","8","kCI1uxp5BaHFICaaslYmO8lH.jpg","2016-03-31 14:54:07","2016-03-31 14:54:07");
					INSERT INTO np_productpicture VALUES("132","1","8","vqWslJlwSXwGFT7r01DoX30X.jpg","2016-03-31 14:54:07","2016-03-31 14:54:07");
					INSERT INTO np_productpicture VALUES("133","1","8","9imUT12oHORYDBBGrwHeyvZD.jpg","2016-03-31 14:54:07","2016-03-31 14:54:07");
					INSERT INTO np_productpicture VALUES("134","1","8","dLvnd1iunS5ysObhWr65RpBe.jpg","2016-03-31 14:54:07","2016-03-31 14:54:07");
					INSERT INTO np_productpicture VALUES("135","1","8","FAxZSF31U6E3jF4Q9bCKlltc.jpg","2016-03-31 14:54:07","2016-03-31 14:54:07");
					INSERT INTO np_productpicture VALUES("138","2","15","myCWVQ6MEs1s54PQyXCyDyhT.jpg","2016-04-01 16:07:41","2016-04-01 16:07:41");
					INSERT INTO np_productpicture VALUES("139","2","15","r56qKT6nbJT2RgY5tmsCh8o5.jpg","2016-04-01 16:07:41","2016-04-01 16:07:41");
					INSERT INTO np_productpicture VALUES("142","2","14","4wnmWrg0kEWICxBhYvJxA6YS.jpg","2016-04-02 03:53:00","2016-04-02 03:53:00");
					INSERT INTO np_productpicture VALUES("143","2","14","E9ADPAbbmHs5wNR0rSO1tNHT.jpg","2016-04-02 03:53:00","2016-04-02 03:53:00");
					INSERT INTO np_productpicture VALUES("144","2","14","Cwhlio58sezpnPKbuJvyRS8v.jpg","2016-04-02 03:53:00","2016-04-02 03:53:00");
					INSERT INTO np_productpicture VALUES("147","2","16","fEKTdiptNTLdqQejOA7oo9EN.jpg","2016-04-14 17:20:44","2016-04-14 17:20:44");
					INSERT INTO np_productpicture VALUES("152","1","17","UneRgF11c4TmaFq0hmvCJo8S.jpg","2016-04-18 16:13:08","2016-04-18 16:13:08");
					


			DROP TABLE np_quick_details;

            CREATE TABLE `np_quick_details` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(10) unsigned NOT NULL,
  `quick_details_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `quick_details_sub` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `quick_details_category_id_foreign` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

					INSERT INTO np_quick_details VALUES("7","4","shoes","","2016-02-13 11:39:48","2016-02-13 11:42:47");
					INSERT INTO np_quick_details VALUES("8","3","Questions","","2016-02-13 12:04:45","2016-02-13 12:04:45");
					


			DROP TABLE np_quick_details_categories;

            CREATE TABLE `np_quick_details_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `categoryname` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

					INSERT INTO np_quick_details_categories VALUES("2","test123123","2016-02-13 09:54:11","2016-02-13 10:24:13");
					INSERT INTO np_quick_details_categories VALUES("3","list","2016-02-13 11:10:06","2016-02-13 11:10:06");
					INSERT INTO np_quick_details_categories VALUES("4","list-test","2016-02-13 11:42:40","2016-02-13 11:42:40");
					


			DROP TABLE np_rfq;

            CREATE TABLE `np_rfq` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `buyer_id` int(10) unsigned NOT NULL,
  `rfq_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `rfq_description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `rfq_quantity` int(11) NOT NULL,
  `rfq_unitprice` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `rfq_itemunit` int(11) NOT NULL,
  `rfq_type` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `rfq_approve` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `rfq_unit` int(11) unsigned NOT NULL,
  `admin_active` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `rfq_buyer_id_foreign` (`buyer_id`),
  KEY `rfq_unit` (`rfq_unit`),
  CONSTRAINT `np_rfq_ibfk_1` FOREIGN KEY (`rfq_unit`) REFERENCES `np_unit` (`id`),
  CONSTRAINT `rfq_buyer_id_foreign` FOREIGN KEY (`buyer_id`) REFERENCES `np_member` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

					INSERT INTO np_rfq VALUES("8","1","g","gdfgdf","12","32","1","standard","1","2015-06-08 16:30:28","2015-06-08 16:30:28","2","0");
					INSERT INTO np_rfq VALUES("9","1","forest","this is forest test","21","21","2","detailed","1","2015-06-09 05:33:52","2015-06-09 05:33:52","3","0");
					INSERT INTO np_rfq VALUES("10","1","test product","This is our product ","13","21.4","3","detailed","1","2015-06-09 05:36:32","2015-06-09 12:39:10","2","0");
					INSERT INTO np_rfq VALUES("11","1","Test with client","This is my test with client ","12","21","2","detailed","1","2016-03-08 21:48:57","2015-07-19 08:54:47","2","0");
					INSERT INTO np_rfq VALUES("12","3","forest test","This is our test  product description","12","12","3","standard","1","2016-03-27 11:10:04","2015-07-17 11:10:04","3","0");
					INSERT INTO np_rfq VALUES("13","3","forest company title","This is forest company title list","13","12","3","detailed","1","2016-03-27 12:02:12","2016-03-29 19:23:04","3","1");
					INSERT INTO np_rfq VALUES("14","3","Hose 3/4","3/4  water hose with brass ends ","500","22.5","1","standard","1","2016-03-28 14:08:27","2016-03-29 19:22:54","2","1");
					


			DROP TABLE np_rfq_email;

            CREATE TABLE `np_rfq_email` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rfq_id` int(10) unsigned NOT NULL,
  `quote_id` int(10) unsigned NOT NULL,
  `sender_id` int(10) unsigned NOT NULL,
  `receiver_id` int(10) unsigned NOT NULL,
  `subject` longtext COLLATE utf8_unicode_ci NOT NULL,
  `message` longtext COLLATE utf8_unicode_ci NOT NULL,
  `sender_red` int(11) NOT NULL,
  `receiver_red` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `rfq_email_rfq_id_foreign` (`rfq_id`),
  KEY `rfq_email_quote_id_foreign` (`quote_id`),
  KEY `rfq_email_sender_id_foreign` (`sender_id`),
  KEY `rfq_email_receiver_id_foreign` (`receiver_id`),
  CONSTRAINT `rfq_email_quote_id_foreign` FOREIGN KEY (`quote_id`) REFERENCES `np_seller_quote` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `rfq_email_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `np_member` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `rfq_email_rfq_id_foreign` FOREIGN KEY (`rfq_id`) REFERENCES `np_rfq` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `rfq_email_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `np_member` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

					INSERT INTO np_rfq_email VALUES("3","13","4","3","2","send list","Hello.
Thank you for your reply.
My email address is ##################
Best Regards","1","0","2015-07-22 12:43:31","2015-07-22 12:43:31");
					INSERT INTO np_rfq_email VALUES("4","13","4","3","2","send list","Hello.
Thank you for your reply.
My email address is ##################
Best Regards","1","0","2015-07-22 12:44:18","2015-07-22 12:44:18");
					INSERT INTO np_rfq_email VALUES("5","13","4","3","2","send list","Hello.
Thank you for your reply.
My email address is ##################
Best Regards","1","0","2015-07-22 12:45:42","2015-07-22 12:45:42");
					INSERT INTO np_rfq_email VALUES("6","13","4","3","2","RE-Quote","This is my reQuote page page ","1","0","2015-07-22 13:57:05","2015-07-22 13:57:05");
					INSERT INTO np_rfq_email VALUES("7","13","4","2","3","this is test","Hello.
My email address is ##################","1","0","2015-08-01 04:47:19","2015-08-01 04:47:19");
					INSERT INTO np_rfq_email VALUES("8","13","4","3","2","test","This is my test ","1","0","2015-10-12 09:24:36","2015-10-12 09:24:36");
					INSERT INTO np_rfq_email VALUES("9","13","4","3","2","This is rest","This is my test list... ","1","0","2015-10-12 09:27:40","2015-10-12 09:27:40");
					INSERT INTO np_rfq_email VALUES("10","13","4","3","2","Test list for product","This is my testsdfsdf sdf sdf sdaf sdaf sdf dsaf adf da","1","0","2015-10-13 09:41:20","2015-10-13 09:41:20");
					INSERT INTO np_rfq_email VALUES("11","13","4","2","3","sdfsdfsd","sdfsdfsdf","1","0","2015-10-14 11:03:24","2015-10-14 11:03:24");
					INSERT INTO np_rfq_email VALUES("12","13","4","2","3","sdfsdf","fsda fdsaf sdaf sdaf ","1","0","2015-10-14 11:07:34","2015-10-14 11:07:34");
					


			DROP TABLE np_rfq_file;

            CREATE TABLE `np_rfq_file` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rfq_id` int(10) unsigned NOT NULL,
  `buyer_id` int(10) unsigned NOT NULL,
  `file_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `file_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `file_type` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `rfq_file_rfq_id_foreign` (`rfq_id`),
  KEY `rfq_file_buyer_id_foreign` (`buyer_id`),
  CONSTRAINT `rfq_file_buyer_id_foreign` FOREIGN KEY (`buyer_id`) REFERENCES `np_member` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `rfq_file_rfq_id_foreign` FOREIGN KEY (`rfq_id`) REFERENCES `np_rfq` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

					INSERT INTO np_rfq_file VALUES("1","8","1","svn.txt","MX2qLP9nAnoCMJffUCSY3LH1.txt","TXT","2015-06-08 17:14:03","2015-06-08 17:14:03");
					INSERT INTO np_rfq_file VALUES("2","8","1","joomla.txt","4PqnwMvDcSGVKrugPXxDYxel.txt","TXT","2015-06-08 17:14:03","2015-06-08 17:14:03");
					INSERT INTO np_rfq_file VALUES("17","10","1","google map.txt","P4eqOmG4iSBM0czNgmm1gCoI.txt","TXT","2015-06-09 14:28:11","2015-06-09 14:28:11");
					INSERT INTO np_rfq_file VALUES("18","10","1","svn.txt","H9WJVqpbRg216mKuBLwbqLNn.txt","TXT","2015-06-09 14:28:11","2015-06-09 14:28:11");
					INSERT INTO np_rfq_file VALUES("34","11","1","shopify.txt","YGJ2CPiCKtDBdzq2GnadQhi2.txt","PDF","2015-07-19 08:54:47","2015-07-19 08:54:47");
					INSERT INTO np_rfq_file VALUES("35","11","1","2015-05-13-02.pdf","PYt3MyHxni1y5IuLr0z4Rt3j.pdf","PDF","2015-07-19 08:54:47","2015-07-19 08:54:47");
					INSERT INTO np_rfq_file VALUES("41","12","1","jQuery.pdf","5c2ezeFwm2h9IDaVCrKe0PLv.pdf","PDF","2016-03-02 09:36:30","2016-03-02 09:36:30");
					INSERT INTO np_rfq_file VALUES("42","12","1","LearningjQuery1.3.pdf","Tjer9CyI0vkmlHDrVeHxTuEO.pdf","PDF","2016-03-02 09:36:30","2016-03-02 09:36:30");
					INSERT INTO np_rfq_file VALUES("77","14","1","jQuery.pdf","Qdrbo08R1NX1leJubcjCKyU3.pdf","PDF","2016-03-02 18:59:04","2016-03-02 18:59:04");
					INSERT INTO np_rfq_file VALUES("78","13","1","jQuery.pdf","f5rElBUwhbeEwTfTO6mRVRtP.pdf","PDF","2016-03-02 19:31:45","2016-03-02 19:31:45");
					


			DROP TABLE np_rfq_picture;

            CREATE TABLE `np_rfq_picture` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rfq_id` int(10) unsigned NOT NULL,
  `buyer_id` int(10) unsigned NOT NULL,
  `picture_url` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `rfq_picture_rfq_id_foreign` (`rfq_id`),
  KEY `rfq_picture_buyer_id_foreign` (`buyer_id`),
  CONSTRAINT `rfq_picture_buyer_id_foreign` FOREIGN KEY (`buyer_id`) REFERENCES `np_member` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `rfq_picture_rfq_id_foreign` FOREIGN KEY (`rfq_id`) REFERENCES `np_rfq` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

					INSERT INTO np_rfq_picture VALUES("2","8","1","TFnNvUloxfLDpUYGLCYGkKWK.png","2015-06-08 16:40:04","2015-06-08 16:40:04");
					INSERT INTO np_rfq_picture VALUES("3","8","1","OBFJe38moD12OJrepu0VvRaU.png","2015-06-08 16:40:04","2015-06-08 16:40:04");
					INSERT INTO np_rfq_picture VALUES("4","9","1","blTtPYRGHOBNRUTnWj5Ug8ow.png","2015-06-09 05:33:52","2015-06-09 05:33:52");
					INSERT INTO np_rfq_picture VALUES("5","9","1","IoSVdm6WxHQ4VTGqmirFBG33.jpg","2015-06-09 05:33:52","2015-06-09 05:33:52");
					INSERT INTO np_rfq_picture VALUES("6","9","1","blTtPYRGHOBNRUTnWj5Ug8ow.png","2015-06-09 05:33:52","2015-06-09 05:33:52");
					INSERT INTO np_rfq_picture VALUES("7","9","1","IoSVdm6WxHQ4VTGqmirFBG33.jpg","2015-06-09 05:33:52","2015-06-09 05:33:52");
					INSERT INTO np_rfq_picture VALUES("13","10","1","NOWOmZM7boHmr9WMFruD7qG0.png","2015-06-09 14:28:11","2015-06-09 14:28:11");
					INSERT INTO np_rfq_picture VALUES("14","10","1","LL1DPmBes3CK98SSY295CMpw.jpg","2015-06-09 14:28:11","2015-06-09 14:28:11");
					INSERT INTO np_rfq_picture VALUES("15","10","1","I1KbbC4LJ2LAPBvgIWj3GhJG.jpg","2015-06-09 14:28:11","2015-06-09 14:28:11");
					INSERT INTO np_rfq_picture VALUES("36","11","1","MB38HaRQxV7aUgJnxOdqYleK.jpg","2015-07-19 08:54:47","2015-07-19 08:54:47");
					INSERT INTO np_rfq_picture VALUES("37","11","1","BqKZ5yL69NWD5R93DOyWjbPI.jpg","2015-07-19 08:54:47","2015-07-19 08:54:47");
					INSERT INTO np_rfq_picture VALUES("45","12","1","TZLBA8Qwd8Zec5bY6KdiXPgk.jpg","2016-03-02 09:36:30","2016-03-02 09:36:30");
					INSERT INTO np_rfq_picture VALUES("46","12","1","2yrpLbnnLKvbEkglpIjUTSuM.jpg","2016-03-02 09:36:30","2016-03-02 09:36:30");
					INSERT INTO np_rfq_picture VALUES("47","12","1","JDXIOhemKYpZpaiK9OMBTFTp.jpg","2016-03-02 09:36:30","2016-03-02 09:36:30");
					INSERT INTO np_rfq_picture VALUES("93","14","1","94pDbXFiWEmySUZdatbx90H6.jpg","2016-03-02 18:59:04","2016-03-02 18:59:04");
					INSERT INTO np_rfq_picture VALUES("94","13","1","GaizyTJyZ3lr1BS9zvAStyxC.jpg","2016-03-02 19:31:45","2016-03-02 19:31:45");
					INSERT INTO np_rfq_picture VALUES("95","13","1","B8jPYnqSwpzEtG9SbH8uZOdh.jpg","2016-03-02 19:31:45","2016-03-02 19:31:45");
					INSERT INTO np_rfq_picture VALUES("96","13","1","1EFqnjPtqluLWSWBJ8b8LJVt.jpg","2016-03-02 19:31:45","2016-03-02 19:31:45");
					


			DROP TABLE np_rfq_specification;

            CREATE TABLE `np_rfq_specification` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rfq_id` int(10) unsigned NOT NULL,
  `buyer_id` int(10) unsigned NOT NULL,
  `rfq_description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `rfq_alternative_ok` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `rfq_specification_rfq_id_foreign` (`rfq_id`),
  KEY `rfq_specification_buyer_id_foreign` (`buyer_id`),
  CONSTRAINT `rfq_specification_buyer_id_foreign` FOREIGN KEY (`buyer_id`) REFERENCES `np_member` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `rfq_specification_rfq_id_foreign` FOREIGN KEY (`rfq_id`) REFERENCES `np_rfq` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

					INSERT INTO np_rfq_specification VALUES("16","10","1","first","1","2015-06-09 05:49:12","2015-06-09 13:30:12");
					INSERT INTO np_rfq_specification VALUES("17","10","1","second","0","2015-06-09 05:49:12","2015-06-09 13:30:12");
					INSERT INTO np_rfq_specification VALUES("18","10","1","third","0","2015-06-09 05:49:12","2015-06-09 13:30:12");
					INSERT INTO np_rfq_specification VALUES("19","10","1","fourth","0","2015-06-09 13:30:12","2015-06-09 13:30:12");
					INSERT INTO np_rfq_specification VALUES("20","11","1","first","1","2015-06-09 21:48:59","2015-06-09 21:48:59");
					INSERT INTO np_rfq_specification VALUES("21","11","1","Second","0","2015-06-09 21:49:00","2015-06-09 21:49:00");
					INSERT INTO np_rfq_specification VALUES("22","11","1","Third","0","2015-06-09 21:55:20","2015-07-19 08:54:48");
					INSERT INTO np_rfq_specification VALUES("23","13","1","This is my good developer","1","2015-07-17 12:02:12","2015-07-17 12:35:13");
					INSERT INTO np_rfq_specification VALUES("24","13","1","This is our quality list","0","2015-07-17 12:02:12","2016-03-02 09:08:10");
					INSERT INTO np_rfq_specification VALUES("25","13","1","this is our quantitly","0","2015-07-17 12:02:12","2015-07-17 12:35:13");
					INSERT INTO np_rfq_specification VALUES("26","13","1","test","0","2016-03-02 13:10:32","2016-03-02 13:21:09");
					


			DROP TABLE np_rfq_specificationpicture;

            CREATE TABLE `np_rfq_specificationpicture` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rfq_id` int(10) unsigned NOT NULL,
  `buyer_id` int(10) unsigned NOT NULL,
  `specification_id` int(10) unsigned NOT NULL,
  `picture_url` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `rfq_specificationpicture_rfq_id_foreign` (`rfq_id`),
  KEY `rfq_specificationpicture_buyer_id_foreign` (`buyer_id`),
  KEY `rfq_specificationpicture_specification_id_foreign` (`specification_id`),
  CONSTRAINT `rfq_specificationpicture_buyer_id_foreign` FOREIGN KEY (`buyer_id`) REFERENCES `np_member` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `rfq_specificationpicture_rfq_id_foreign` FOREIGN KEY (`rfq_id`) REFERENCES `np_rfq` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `rfq_specificationpicture_specification_id_foreign` FOREIGN KEY (`specification_id`) REFERENCES `np_rfq_specification` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=200 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

					INSERT INTO np_rfq_specificationpicture VALUES("31","10","1","16","57A7y0jbBHFqun9IBUwJ2tRQ.jpg","2015-06-09 14:28:11","2015-06-09 14:28:11");
					INSERT INTO np_rfq_specificationpicture VALUES("32","10","1","17","hYqEHtipHbEUcfQpHhFtaE6H.png","2015-06-09 14:28:11","2015-06-09 14:28:11");
					INSERT INTO np_rfq_specificationpicture VALUES("33","10","1","17","9B5m6UUTa17yTkmZ6mAzLHc0.jpg","2015-06-09 14:28:11","2015-06-09 14:28:11");
					INSERT INTO np_rfq_specificationpicture VALUES("34","10","1","18","57A7y0jbBHFqun9IBUwJ2tRQ.jpg","2015-06-09 14:28:11","2015-06-09 14:28:11");
					INSERT INTO np_rfq_specificationpicture VALUES("35","10","1","19","TEn1ggjZXSD92JcnZRDygOV7.png","2015-06-09 14:28:11","2015-06-09 14:28:11");
					INSERT INTO np_rfq_specificationpicture VALUES("78","11","1","20","98EWhzFDsJ32peANWSb5d09o.jpg","2015-07-19 08:54:48","2015-07-19 08:54:48");
					INSERT INTO np_rfq_specificationpicture VALUES("79","11","1","20","8Qi8cZ7yEUVKd3GABLq7ZXJM.jpg","2015-07-19 08:54:48","2015-07-19 08:54:48");
					INSERT INTO np_rfq_specificationpicture VALUES("80","11","1","21","wsPw0JklcQQt7ZvCpOE7mIdl.jpg","2015-07-19 08:54:48","2015-07-19 08:54:48");
					INSERT INTO np_rfq_specificationpicture VALUES("81","11","1","21","nDpH1BfOritxwR2TmByxo0HC.jpg","2015-07-19 08:54:48","2015-07-19 08:54:48");
					INSERT INTO np_rfq_specificationpicture VALUES("82","11","1","22","G63KmKRsrZ7vobAg9mJO9wIU.jpg","2015-07-19 08:54:48","2015-07-19 08:54:48");
					INSERT INTO np_rfq_specificationpicture VALUES("83","11","1","22","nBbINfKEIZ9NWHsR60xowJYr.jpg","2015-07-19 08:54:48","2015-07-19 08:54:48");
					INSERT INTO np_rfq_specificationpicture VALUES("89","11","1","22","nBbINfKEIZ9NWHsR60xowJYr.jpg","0000-00-00 00:00:00","0000-00-00 00:00:00");
					INSERT INTO np_rfq_specificationpicture VALUES("189","13","1","23","s42n2H8BxhR9LBwocU82p6b7.jpg","2016-03-02 19:31:45","2016-03-02 19:31:45");
					INSERT INTO np_rfq_specificationpicture VALUES("190","13","1","23","AkW3ryBcj3Y4gRAo434uQUf3.jpg","2016-03-02 19:31:45","2016-03-02 19:31:45");
					INSERT INTO np_rfq_specificationpicture VALUES("191","13","1","23","ORAV5sqAkLitr17JD4TDS9Fi.jpg","2016-03-02 19:31:45","2016-03-02 19:31:45");
					INSERT INTO np_rfq_specificationpicture VALUES("192","13","1","24","SVuS2NcZJs12PerhPsF9sEuQ.jpg","2016-03-02 19:31:45","2016-03-02 19:31:45");
					INSERT INTO np_rfq_specificationpicture VALUES("193","13","1","24","PaCgkxYLBgkj8As3fieNHVL9.gif","2016-03-02 19:31:45","2016-03-02 19:31:45");
					INSERT INTO np_rfq_specificationpicture VALUES("194","13","1","24","fPNG7D15PXxaOcxSDpqS2CCJ.jpg","2016-03-02 19:31:45","2016-03-02 19:31:45");
					INSERT INTO np_rfq_specificationpicture VALUES("195","13","1","25","B9EWffxy7oV5DjrW6IJHAcwU.jpg","2016-03-02 19:31:45","2016-03-02 19:31:45");
					INSERT INTO np_rfq_specificationpicture VALUES("196","13","1","25","6O2GOi0RftlznUDda9xJRUXZ.jpg","2016-03-02 19:31:45","2016-03-02 19:31:45");
					INSERT INTO np_rfq_specificationpicture VALUES("197","13","1","25","iBSVixB066VRYnwfINUQbAyD.png","2016-03-02 19:31:45","2016-03-02 19:31:45");
					INSERT INTO np_rfq_specificationpicture VALUES("198","13","1","26","YzEGruOz1JatC6bJb9VfcFu8.png","2016-03-02 19:31:46","2016-03-02 19:31:46");
					INSERT INTO np_rfq_specificationpicture VALUES("199","13","1","26","0s9OWl9b2VH6WTrIVhFKTp9z.jpg","2016-03-02 19:31:46","2016-03-02 19:31:46");
					


			DROP TABLE np_seller_accept;

            CREATE TABLE `np_seller_accept` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rfq_id` int(10) unsigned NOT NULL,
  `quote_id` int(10) unsigned NOT NULL,
  `seller_id` int(10) unsigned NOT NULL,
  `buyer_id` int(10) unsigned NOT NULL,
  `buyer_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `buyer_city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `buyer_state` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `buyer_zip` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `buyer_country` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `invoice_number` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `invoice_date` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `escrow_no` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tracking_number1` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tracking_date` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tracking_number2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `seller_accept_rfq_id_foreign` (`rfq_id`),
  KEY `seller_accept_quote_id_foreign` (`quote_id`),
  KEY `seller_accept_seller_id_foreign` (`seller_id`),
  KEY `seller_accept_buyer_id_foreign` (`buyer_id`),
  CONSTRAINT `seller_accept_buyer_id_foreign` FOREIGN KEY (`buyer_id`) REFERENCES `np_member` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `seller_accept_quote_id_foreign` FOREIGN KEY (`quote_id`) REFERENCES `np_seller_quote` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `seller_accept_rfq_id_foreign` FOREIGN KEY (`rfq_id`) REFERENCES `np_rfq` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `seller_accept_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `np_member` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

					INSERT INTO np_seller_accept VALUES("1","13","4","2","3","turlkork          ","turlkork","","12531","4","2015-08-16 17:14:12","2015-09-16 10:33:58","THU04SK3K0SEQ4P","2015-09-16 14:33:58","","","","");
					INSERT INTO np_seller_accept VALUES("2","12","5","2","3","turlkork  ","turlkork","","12531","4","2015-09-15 23:01:31","2015-09-16 19:24:24","QUNVUEZE68JF4NE","2015-09-16 23:24:24","","","","");
					


			DROP TABLE np_seller_quote;

            CREATE TABLE `np_seller_quote` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rfq_id` int(10) unsigned NOT NULL,
  `buyer_id` int(10) unsigned NOT NULL,
  `seller_id` int(10) unsigned NOT NULL,
  `quantity` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `unit` int(11) NOT NULL,
  `price` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `price_currency` int(11) NOT NULL,
  `sample_price` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sample_price_currency` int(11) DEFAULT NULL,
  `seller_product` longtext COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `accept` varchar(255) COLLATE utf8_unicode_ci DEFAULT '0',
  `accept_status` varchar(255) COLLATE utf8_unicode_ci DEFAULT '0' COMMENT '1:accpet,2:escrow,3:seller_made,4:product_finished,5:shipping,6:product_recevied,7:finish',
  `admin_active` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `seller_quote_rfq_id_foreign` (`rfq_id`),
  KEY `seller_quote_buyer_id_foreign` (`buyer_id`),
  KEY `seller_quote_seller_id_foreign` (`seller_id`),
  CONSTRAINT `seller_quote_buyer_id_foreign` FOREIGN KEY (`buyer_id`) REFERENCES `np_member` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `seller_quote_rfq_id_foreign` FOREIGN KEY (`rfq_id`) REFERENCES `np_rfq` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `seller_quote_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `np_member` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

					INSERT INTO np_seller_quote VALUES("4","13","3","2","500","3","11","1","12","2","This is my test quote.
I want to contact with you.
Best Regards","6","2015-07-20 06:05:53","2015-08-16 17:45:13","1","1","0");
					INSERT INTO np_seller_quote VALUES("5","12","3","2","1000","3","12","3","15","3","This is my test with client.
I want it will be good.","6","2015-07-26 11:44:24","2015-09-15 23:01:31","1","1","0");
					INSERT INTO np_seller_quote VALUES("6","11","2","3","200","3","12","2","23","2","saasd
","6","0000-00-00 00:00:00","0000-00-00 00:00:00","0","0","0");
					


			DROP TABLE np_seller_quote_note;

            CREATE TABLE `np_seller_quote_note` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `quote_id` int(10) unsigned NOT NULL,
  `rfq_id` int(10) unsigned NOT NULL,
  `buyer_id` int(10) unsigned NOT NULL,
  `seller_id` int(10) unsigned NOT NULL,
  `note` longtext COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `seller_quote_note_quote_id_foreign` (`quote_id`),
  KEY `seller_quote_note_rfq_id_foreign` (`rfq_id`),
  KEY `seller_quote_note_buyer_id_foreign` (`buyer_id`),
  KEY `seller_quote_note_seller_id_foreign` (`seller_id`),
  CONSTRAINT `seller_quote_note_buyer_id_foreign` FOREIGN KEY (`buyer_id`) REFERENCES `np_member` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `seller_quote_note_quote_id_foreign` FOREIGN KEY (`quote_id`) REFERENCES `np_seller_quote` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `seller_quote_note_rfq_id_foreign` FOREIGN KEY (`rfq_id`) REFERENCES `np_rfq` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `seller_quote_note_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `np_member` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

					INSERT INTO np_seller_quote_note VALUES("15","4","13","3","2","This is my test","2015-07-22 08:17:33","2015-07-22 08:17:33");
					INSERT INTO np_seller_quote_note VALUES("16","4","13","3","2","This is my test 1","2015-07-22 08:17:33","2015-07-22 08:17:33");
					INSERT INTO np_seller_quote_note VALUES("17","4","13","3","2","This is my test 2","2015-07-22 08:17:33","2015-07-22 08:17:33");
					INSERT INTO np_seller_quote_note VALUES("18","5","12","3","2","Test1","2015-07-26 11:44:24","2015-07-26 11:44:24");
					INSERT INTO np_seller_quote_note VALUES("19","5","12","3","2","test2","2015-07-26 11:44:24","2015-07-26 11:44:24");
					INSERT INTO np_seller_quote_note VALUES("20","5","12","3","2","test3","2015-07-26 11:44:24","2015-07-26 11:44:24");
					


			DROP TABLE np_seller_quote_picture;

            CREATE TABLE `np_seller_quote_picture` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `quote_id` int(10) unsigned NOT NULL,
  `rfq_id` int(10) unsigned NOT NULL,
  `buyer_id` int(10) unsigned NOT NULL,
  `seller_id` int(10) unsigned NOT NULL,
  `picture_url` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `seller_quote_picture_quote_id_foreign` (`quote_id`),
  KEY `seller_quote_picture_rfq_id_foreign` (`rfq_id`),
  KEY `seller_quote_picture_buyer_id_foreign` (`buyer_id`),
  KEY `seller_quote_picture_seller_id_foreign` (`seller_id`),
  CONSTRAINT `seller_quote_picture_buyer_id_foreign` FOREIGN KEY (`buyer_id`) REFERENCES `np_member` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `seller_quote_picture_quote_id_foreign` FOREIGN KEY (`quote_id`) REFERENCES `np_seller_quote` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `seller_quote_picture_rfq_id_foreign` FOREIGN KEY (`rfq_id`) REFERENCES `np_rfq` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `seller_quote_picture_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `np_member` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

					INSERT INTO np_seller_quote_picture VALUES("13","4","13","3","2","NqyXzD6N8wiXNHiv6D1LMnUH.jpg","2015-07-22 08:17:33","2015-07-22 08:17:33");
					INSERT INTO np_seller_quote_picture VALUES("14","4","13","3","2","UkP86vUnzGTjL9WU5fgN2wPl.jpg","2015-07-22 08:17:33","2015-07-22 08:17:33");
					INSERT INTO np_seller_quote_picture VALUES("15","4","13","3","2","MxR8uKO7IWPcjfoKKeiyc73d.jpg","2015-07-22 08:17:33","2015-07-22 08:17:33");
					INSERT INTO np_seller_quote_picture VALUES("16","4","13","3","2","0VCxCUySKLL3qbacwoPlSafO.jpg","2015-07-22 08:17:33","2015-07-22 08:17:33");
					


			DROP TABLE np_seller_quote_specification;

            CREATE TABLE `np_seller_quote_specification` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `quote_id` int(10) unsigned NOT NULL,
  `rfq_id` int(10) unsigned NOT NULL,
  `buyer_id` int(10) unsigned NOT NULL,
  `seller_id` int(10) unsigned NOT NULL,
  `specification_id` int(11) NOT NULL,
  `specification` longtext COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `seller_quote_specification_quote_id_foreign` (`quote_id`),
  KEY `seller_quote_specification_rfq_id_foreign` (`rfq_id`),
  KEY `seller_quote_specification_buyer_id_foreign` (`buyer_id`),
  KEY `seller_quote_specification_seller_id_foreign` (`seller_id`),
  CONSTRAINT `seller_quote_specification_buyer_id_foreign` FOREIGN KEY (`buyer_id`) REFERENCES `np_member` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `seller_quote_specification_quote_id_foreign` FOREIGN KEY (`quote_id`) REFERENCES `np_seller_quote` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `seller_quote_specification_rfq_id_foreign` FOREIGN KEY (`rfq_id`) REFERENCES `np_rfq` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `seller_quote_specification_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `np_member` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

					INSERT INTO np_seller_quote_specification VALUES("16","4","13","3","2","23","test","2015-07-22 08:17:33","2015-07-22 08:17:33");
					INSERT INTO np_seller_quote_specification VALUES("17","4","13","3","2","24","rewre","2015-07-22 08:17:33","2015-07-22 08:17:33");
					INSERT INTO np_seller_quote_specification VALUES("18","4","13","3","2","25","this is our quantitly","2015-07-22 08:17:33","2015-07-22 08:17:33");
					


			DROP TABLE np_seller_sample;

            CREATE TABLE `np_seller_sample` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rfq_id` int(10) unsigned NOT NULL,
  `quote_id` int(10) unsigned NOT NULL,
  `seller_id` int(10) unsigned NOT NULL,
  `buyer_id` int(10) unsigned NOT NULL,
  `shippingprice` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `shippingcurrency` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `invoicenumber` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `createInvoiceDate` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `totalprice` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `shippingwidth` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `shippingheight` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `shippinglength` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `packagecount` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `shippingname` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `shippingaddress` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `shippingcity` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `shippingstate` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `shippingpostalcode` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `shippingcountry` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL,
  `shippingweight` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `shippingweightunit` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `shippingservicetype` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `shippingphonenumber` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `shippinglabel` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `trackingnumber1` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `trackingnumber2` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `paidcheck` int(11) DEFAULT NULL,
  `invoicepaid` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sampleamount` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `tracking_date` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `seller_sample_rfq_id_foreign` (`rfq_id`),
  KEY `seller_sample_quote_id_foreign` (`quote_id`),
  KEY `seller_sample_seller_id_foreign` (`seller_id`),
  KEY `seller_sample_buyer_id_foreign` (`buyer_id`),
  CONSTRAINT `seller_sample_buyer_id_foreign` FOREIGN KEY (`buyer_id`) REFERENCES `np_member` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `seller_sample_quote_id_foreign` FOREIGN KEY (`quote_id`) REFERENCES `np_seller_quote` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `seller_sample_rfq_id_foreign` FOREIGN KEY (`rfq_id`) REFERENCES `np_rfq` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `seller_sample_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `np_member` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

					INSERT INTO np_seller_sample VALUES("2","13","4","2","3","179.32","USD","23CKV78MLAK4T6R","2015-08-10 19:26:55","270.7399","6","4","6","1","joe hayes","27 winnie rd ","center moriches","ny","11934","US","2","LB","INTERNATIONAL_PRIORITY","6315131865","","","","111","330753","3","2015-07-23 14:35:09","2015-08-10 15:42:37","");
					INSERT INTO np_seller_sample VALUES("3","12","5","2","3","1137.24","USD","5BM8HFT5BQCQBHR","2015-07-28 19:01:53","1346.0037","18","18","18","1","us wire ","27 winnie rd ","center moriches","ny","11934","US","27","LB","INTERNATIONAL_PRIORITY","1234567890","","","","","","2","2015-07-26 13:11:17","2015-07-28 15:01:53","");
					


			DROP TABLE np_subcategory;

            CREATE TABLE `np_subcategory` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(10) unsigned NOT NULL,
  `subcategoryname` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `subcategory_category_id_foreign` (`category_id`),
  CONSTRAINT `subcategory_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `np_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

					INSERT INTO np_subcategory VALUES("1","1","Agrochemicals & pesticides    ","2015-06-04 13:30:28","2015-06-04 13:30:28");
					INSERT INTO np_subcategory VALUES("2","1","Animals    ","2015-06-04 13:31:50","2015-06-04 13:31:50");
					INSERT INTO np_subcategory VALUES("3","2","Apparel & fashion agents","2015-06-04 13:32:25","2015-06-04 13:32:25");
					INSERT INTO np_subcategory VALUES("4","2","Apparel & fashion designers","2015-06-04 13:32:53","2015-06-04 13:32:53");
					INSERT INTO np_subcategory VALUES("5","2","Apparel & fashion wholesalers","2015-06-04 13:33:16","2015-06-04 13:33:16");
					INSERT INTO np_subcategory VALUES("6","4","Metal Crafts","2015-06-04 18:54:11","2015-06-04 18:54:11");
					INSERT INTO np_subcategory VALUES("8","1","Aquaculture equipment & supplies","0000-00-00 00:00:00","0000-00-00 00:00:00");
					INSERT INTO np_subcategory VALUES("9","6","Auto accessories","0000-00-00 00:00:00","0000-00-00 00:00:00");
					INSERT INTO np_subcategory VALUES("10","6","Auto electronics","0000-00-00 00:00:00","0000-00-00 00:00:00");
					INSERT INTO np_subcategory VALUES("11","6","Auto maintenance","0000-00-00 00:00:00","0000-00-00 00:00:00");
					INSERT INTO np_subcategory VALUES("12","7","Advertising","0000-00-00 00:00:00","0000-00-00 00:00:00");
					INSERT INTO np_subcategory VALUES("13","7","Auction","0000-00-00 00:00:00","0000-00-00 00:00:00");
					INSERT INTO np_subcategory VALUES("14","7","Brokerage","0000-00-00 00:00:00","0000-00-00 00:00:00");
					INSERT INTO np_subcategory VALUES("15","7","Cargo & storage","0000-00-00 00:00:00","0000-00-00 00:00:00");
					


			DROP TABLE np_unit;

            CREATE TABLE `np_unit` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `unitname` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

					INSERT INTO np_unit VALUES("2","Kg","2015-07-19 08:30:15","2015-07-19 08:30:15");
					INSERT INTO np_unit VALUES("3","Piece","2015-07-19 08:30:48","2015-07-19 08:30:48");
					INSERT INTO np_unit VALUES("4","Dozen","2015-07-19 08:31:01","2015-07-19 08:31:01");
					


			DROP TABLE np_user_category;

            CREATE TABLE `np_user_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `category_id` int(10) unsigned NOT NULL,
  `picture_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `user_category_user_id_foreign` (`user_id`),
  KEY `user_category_category_id_foreign` (`category_id`),
  CONSTRAINT `user_category_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `np_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user_category_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `np_member` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

					INSERT INTO np_user_category VALUES("1","2","1","mwFfXMBYdtNpz380TwvxVLsP.jpg","2016-01-15 14:00:11","2016-01-23 17:14:19");
					INSERT INTO np_user_category VALUES("3","2","2","8jvFsruJJcjSYhC8nvi2b4yC.jpg","2016-01-23 16:43:01","2016-01-24 18:40:49");
					


			DROP TABLE np_user_sub_category;

            CREATE TABLE `np_user_sub_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `category_id` int(10) unsigned NOT NULL,
  `subcategory_id` int(10) unsigned NOT NULL,
  `picture_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `user_sub_category_user_id_foreign` (`user_id`),
  KEY `user_sub_category_category_id_foreign` (`category_id`),
  KEY `user_sub_category_subcategory_id_foreign` (`subcategory_id`),
  CONSTRAINT `user_sub_category_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `np_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user_sub_category_subcategory_id_foreign` FOREIGN KEY (`subcategory_id`) REFERENCES `np_subcategory` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user_sub_category_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `np_member` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

					INSERT INTO np_user_sub_category VALUES("1","2","1","1","Cvw8lidLFEzxS3d9niipCcvu.jpg","2016-01-19 08:38:23","2016-01-24 18:38:52");
					INSERT INTO np_user_sub_category VALUES("2","2","1","8","oO9AulDlL2CUvMcyOZw27M2S.jpg","2016-01-24 18:01:19","2016-01-24 18:38:23");
					


			DROP TABLE np_usercategory;

            CREATE TABLE `np_usercategory` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `category_id` int(10) unsigned NOT NULL,
  `subcategory_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `usercategory_user_id_foreign` (`user_id`),
  KEY `usercategory_category_id_foreign` (`category_id`),
  KEY `usercategory_subcategory_id_foreign` (`subcategory_id`),
  CONSTRAINT `usercategory_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `np_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `usercategory_subcategory_id_foreign` FOREIGN KEY (`subcategory_id`) REFERENCES `np_subcategory` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `usercategory_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `np_member` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

					INSERT INTO np_usercategory VALUES("6","1","1","2","2015-06-12 07:24:49","2015-06-12 07:24:49");
					INSERT INTO np_usercategory VALUES("7","1","2","3","2015-06-12 07:24:49","2015-06-12 07:24:49");
					INSERT INTO np_usercategory VALUES("8","1","2","4","2015-06-12 07:24:49","2015-06-12 07:24:49");
					INSERT INTO np_usercategory VALUES("9","1","2","5","2015-06-12 07:24:49","2015-06-12 07:24:49");
					INSERT INTO np_usercategory VALUES("18","2","1","1","2015-06-16 18:38:21","2015-06-16 18:38:21");
					INSERT INTO np_usercategory VALUES("19","2","1","2","2015-06-16 18:38:22","2015-06-16 18:38:22");
					INSERT INTO np_usercategory VALUES("20","2","2","3","2015-06-16 18:38:22","2015-06-16 18:38:22");
					INSERT INTO np_usercategory VALUES("21","2","2","4","2015-06-16 18:38:22","2015-06-16 18:38:22");
					INSERT INTO np_usercategory VALUES("22","2","2","5","2015-06-16 18:38:22","2015-06-16 18:38:22");
					INSERT INTO np_usercategory VALUES("23","2","4","6","2015-06-16 18:38:22","2015-06-16 18:38:22");
					INSERT INTO np_usercategory VALUES("24","5","1","1","2015-10-06 00:17:16","2015-10-06 00:17:16");
					INSERT INTO np_usercategory VALUES("25","5","1","2","2015-10-06 00:17:16","2015-10-06 00:17:16");
					INSERT INTO np_usercategory VALUES("26","5","2","4","2015-10-06 00:17:16","2015-10-06 00:17:16");
					INSERT INTO np_usercategory VALUES("27","5","1","1","2015-10-06 00:18:41","2015-10-06 00:18:41");
					INSERT INTO np_usercategory VALUES("28","5","1","2","2015-10-06 00:18:42","2015-10-06 00:18:42");
					INSERT INTO np_usercategory VALUES("29","5","2","4","2015-10-06 00:18:42","2015-10-06 00:18:42");
					INSERT INTO np_usercategory VALUES("30","5","1","1","2015-10-06 00:20:00","2015-10-06 00:20:00");
					INSERT INTO np_usercategory VALUES("31","5","1","2","2015-10-06 00:20:00","2015-10-06 00:20:00");
					INSERT INTO np_usercategory VALUES("32","5","2","4","2015-10-06 00:20:00","2015-10-06 00:20:00");
					


			DROP TABLE np_usermaketingpicture;

            CREATE TABLE `np_usermaketingpicture` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `picture_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `usermaketingpicture_user_id_foreign` (`user_id`),
  CONSTRAINT `usermaketingpicture_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `np_member` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

					INSERT INTO np_usermaketingpicture VALUES("12","1","1.jpg","2015-06-28 23:31:32","2015-06-28 23:31:32");
					INSERT INTO np_usermaketingpicture VALUES("13","1","2.jpg","2015-06-28 23:31:33","2015-06-28 23:31:33");
					INSERT INTO np_usermaketingpicture VALUES("14","1","3.jpg","2015-06-28 23:31:33","2015-06-28 23:31:33");
					INSERT INTO np_usermaketingpicture VALUES("15","1","4.jpg","2015-06-28 23:31:34","2015-06-28 23:31:34");
					INSERT INTO np_usermaketingpicture VALUES("16","1","5.jpg","2015-06-28 23:31:34","2015-06-28 23:31:34");
					INSERT INTO np_usermaketingpicture VALUES("17","1","6.jpg","2015-06-28 23:31:35","2015-06-28 23:31:35");
					INSERT INTO np_usermaketingpicture VALUES("22","5","1n8y0KuLvOYCOx2BuOXFNccs.PNG","2015-10-06 00:19:55","2015-10-06 00:19:55");
					INSERT INTO np_usermaketingpicture VALUES("23","5","xU2DE6pJYDs5pLxj2fwjj9Wu.png","2015-10-06 00:20:00","2015-10-06 00:20:00");
					INSERT INTO np_usermaketingpicture VALUES("49","2","fDXFKVCpGthCwalafSohZ0zY.jpg","2016-01-19 14:02:45","2016-01-19 14:02:45");
					INSERT INTO np_usermaketingpicture VALUES("50","2","DJ2rSklck2U1AaPKNFoL5sjU.jpg","2016-01-19 14:02:45","2016-01-19 14:02:45");
					


			