//Hand only use

CREATE TABLE IF NOT EXISTS Users (
                                     `id` int NOT NULL AUTO_INCREMENT,
                                     `login` varchar(32) NOT NULL UNIQUE,
                                     `hash` varchar(256) NOT NULL,
                                     `sault` varchar(16) NOT NULL,
                                     `email` varchar(320) NOT NULL,
                                     `permissionLevel` TINYINT DEFAULT 0,
                                     `registerDate` DATE DEFAULT (CURRENT_DATE),
                                     PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8 COLLATE utf8_bin AUTO_INCREMENT=0

CREATE TABLE IF NOT EXISTS BlogList (
                                        `blogid` int NOT NULL AUTO_INCREMENT,
                                        `userid` int NOT NULL,
                                        `title` varchar(180) NOT NULL,
                                        `description` varchar(1200) NOT NULL,
                                        `region` varchar(16) NOT NULL,
                                        `createDate` DATE DEFAULT (CURRENT_DATE),
                                        PRIMARY KEY (`blogid`)
) DEFAULT CHARSET=utf8 COLLATE utf8_bin AUTO_INCREMENT=0

CREATE TABLE IF NOT EXISTS BlogRecords (
                                           `blogid` int NOT NULL,
                                           `title` varchar(180) NOT NULL,
                                           `text` varchar(5000) NOT NULL,
                                           `createDate` DATE DEFAULT (CURRENT_DATE)
) DEFAULT CHARSET=utf8 COLLATE utf8_bin