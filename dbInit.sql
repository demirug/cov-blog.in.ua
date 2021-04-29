//Hand use only

CREATE TABLE IF NOT EXISTS Users (
                                     `id` int NOT NULL AUTO_INCREMENT,
                                     `login` varchar(32) NOT NULL UNIQUE,
                                     `hash` varchar(256) NOT NULL,
                                     `sault` varchar(16) NOT NULL,
                                     `email` varchar(320) NOT NULL,
                                     `permissionLevel` TINYINT DEFAULT 0,
                                     `registerDate` TIMESTAMP DEFAULT (CURRENT_TIMESTAMP),
                                     PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8

CREATE TABLE IF NOT EXISTS BlogList (
                                        `blogid` int NOT NULL AUTO_INCREMENT,
                                        `userid` int NOT NULL,
                                        `title` varchar(180) NOT NULL,
                                        `description` varchar(1200) NOT NULL,
                                        `region` varchar(16) NOT NULL,
                                        `createDate` TIMESTAMP DEFAULT (CURRENT_TIMESTAMP),
                                        PRIMARY KEY (`blogid`),
                                        UNIQUE (`blogid`, `title`),

                                        CONSTRAINT user_fk FOREIGN KEY (`userid`)
                                        REFERENCES Users (`id`) ON DELETE CASCADE
) DEFAULT CHARSET=utf8

CREATE TABLE IF NOT EXISTS BlogRecords (
                                           `blogid` int NOT NULL,
                                           `title` varchar(180) NOT NULL,
                                           `text` varchar(5000) NOT NULL,
                                           `createDate` TIMESTAMP DEFAULT (CURRENT_TIMESTAMP),
                                           CONSTRAINT blog_fk FOREIGN KEY (`blogid`)
                                           REFERENCES BlogList (`blogid`) ON DELETE CASCADE
) DEFAULT CHARSET=utf8