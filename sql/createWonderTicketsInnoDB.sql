/* 
    Create DB first 
*/

CREATE DATABASE WonderTickets

/*
    Enter the DB and execute SQL
*/

CREATE TABLE Category
(
	`category_id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
    `name` VARCHAR(30) NOT NULL,
    `disabled` TINYINT(1) NOT NULL DEFAULT 0
)ENGINE=InnoDB DEFAULT CHARSET=utf16;

CREATE TABLE Hierarchy
(
	`Name` VARCHAR(30) NOT NULL PRIMARY KEY
) ENGINE=InnoDB DEFAULT CHARSET=utf16;

CREATE TABLE `User`
(
	`user_id` INT NOT NULL AUTO_INCREMENT , 
    `email` VARCHAR(30) NOT NULL, 
    `password` CHAR(128) NOT NULL, 
    `name` VARCHAR(30) NOT NULL, 
    `surname` VARCHAR(30) NOT NULL, 
    `vat` VARCHAR(30) NULL, 
    `company` VARCHAR(30) NULL, 
    `salt` CHAR(128) NOT NULL, 
    `privilege` VARCHAR(30) NOT NULL, 
    `user_img` VARCHAR(20) NOT NULL DEFAULT 'a1.png',
    `signup_date` DATE NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `approved` TINYINT(1) NOT NULL DEFAULT 1, 
    CONSTRAINT `PK_User` PRIMARY KEY (`user_id`), 
	CONSTRAINT `UQ_User` UNIQUE (`email`),
    CONSTRAINT `FK_User_ToHierarchy` FOREIGN KEY (`privilege`) REFERENCES Hierarchy(`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf16;

CREATE TABLE Venue
(
	`venue_id` INT NOT NULL AUTO_INCREMENT , 
    `name` VARCHAR(30) NOT NULL, 
    `state` VARCHAR(30) NOT NULL, 
    `city` VARCHAR(30) NOT NULL, 
    `address` VARCHAR(30) NOT NULL, 
    `seats` INT NOT NULL, 
    `disabled` TINYINT(1) NOT NULL DEFAULT 0,
    CONSTRAINT `PK_Venue` PRIMARY KEY (`venue_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf16;

CREATE TABLE `Event`
(
	`event_id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `title` VARCHAR(80) NOT NULL, 
    `date` DATE NOT NULL,
    `time` TIME NOT NULL,
    `artist` VARCHAR(200) NULL,
    `description` VARCHAR(200) NOT NULL,
    `tickets` INT NOT NULL, 
    `event_img` VARCHAR(20) NOT NULL DEFAULT 'bg1.jpg',
    `disabled` TINYINT(1) NOT NULL DEFAULT 0,
    `cancelled` TINYINT(1) NOT NULL DEFAULT 0,
    `category_id` INT NOT NULL, 
    `venue_id` INT NOT NULL, 
    `user_id` INT NOT NULL, 
    CONSTRAINT `FK_Event_ToCategory` FOREIGN KEY (`category_id`) REFERENCES Category(`category_id`), 
    CONSTRAINT `FK_Event_ToVenue` FOREIGN KEY (`venue_id`) REFERENCES Venue(`venue_id`), 
    CONSTRAINT `FK_Event_ToUser` FOREIGN KEY (`user_id`) REFERENCES User(`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf16;

CREATE TABLE Ticket
(
	`ticket_id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
	`seat` INT NOT NULL,
    `price` INT NOT NULL, 
    `available` TINYINT(1) NOT NULL DEFAULT 1, 
    `event_id` INT NOT NULL,
    `user_id` INT NULL, 
    `purchase_date` DATE NULL,
    CONSTRAINT `FK_Ticket_ToEvent` FOREIGN KEY (`event_id`) REFERENCES Event(`event_id`), 
    CONSTRAINT `FK_Ticket_ToUser` FOREIGN KEY (`user_id`) REFERENCES User(`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf16;

CREATE TABLE Cart
(
    `user_id` INT NOT NULL,
    `ticket_id` INT NOT NULL,
    CONSTRAINT `PK_Cart` PRIMARY KEY (`user_id`, `ticket_id`), 
	CONSTRAINT `FK_Cart_ToUser` FOREIGN KEY (`user_id`) REFERENCES User(`user_id`),
    CONSTRAINT `FK_Cart_ToTicket` FOREIGN KEY (`ticket_id`) REFERENCES Ticket(`ticket_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf16;

CREATE TABLE Notify
(
	`notify_id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
    `text` VARCHAR(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16;

CREATE TABLE Login_attempts
(
	`user_id` INT NOT NULL , 
    `time` VARCHAR(30) NOT NULL, 
    CONSTRAINT `FK_Login_attempts_ToUser` FOREIGN KEY (`user_id`) REFERENCES User(`user_id`), 
    CONSTRAINT `PK_Login_attempts` PRIMARY KEY (`user_id`, `time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf16;

CREATE TABLE Submit
(
	`user_id` INT NOT NULL, 
    `event_id` INT NOT NULL, 
    CONSTRAINT `PK_Submit` PRIMARY KEY (`user_id`, `event_id`), 
    CONSTRAINT `FK_Submit_ToUser` FOREIGN KEY (`user_id`) REFERENCES User(`user_id`), 
    CONSTRAINT `FK_Submit_ToEvent` FOREIGN KEY (`event_id`) REFERENCES Event(`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf16;

CREATE TABLE Broadcast 
(
    `broadcast_id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `user_id` INT NOT NULL,
    `text` VARCHAR(200) NOT NULL,
    `date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `read` tinyint(1) DEFAULT 0,
    `title` varchar(10) DEFAULT "System",
    `event_id` int(11) DEFAULT NULL,
     CONSTRAINT `FK_Broadcast_ToUser` FOREIGN KEY (`user_id`) REFERENCES User(`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf16;

CREATE TABLE Alert
(
	`alert_id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
    `date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, 
    `user_id` INT NOT NULL, 
    `event_id` INT NOT NULL, 
    `notify_id` INT NOT NULL,
    `read` TINYINT(1) NOT NULL DEFAULT 0,
    CONSTRAINT `FK_Alert_ToSubmit` FOREIGN KEY (`user_id`, `event_id`) REFERENCES Submit(`user_id`, `event_id`),
    CONSTRAINT `FK_Alert_ToNotify_2` FOREIGN KEY (`notify_id`) REFERENCES Notify(`notify_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf16;

/*
    POPULATE DATABASE
*/

INSERT INTO Venue(`name`, `state`, `city`, `address`, `seats`)
    VALUES ('Teatro La Fenice', 'Italy', 'Venice', 'Campo San Fantin, 1965', 1126);
INSERT INTO Venue(`name`, `state`, `city`, `address`, `seats`, `disabled`)
    VALUES ('Royal Opera House', 'United Kingdom', 'London', 'Bow St', 2256, 0);
INSERT INTO Venue(`name`, `state`, `city`, `address`, `seats`)
    VALUES ('Teatro Alla Scala', 'Italy', 'Milan', 'Via Filodrammatici 2', 3030);
INSERT INTO Venue(`name`, `state`, `city`, `address`, `seats`)
    VALUES ('Bayerische Staatsoper', 'Germany', 'Munich', 'Max-Joseph-Platz, 2', 3000);
INSERT INTO Venue(`name`, `state`, `city`, `address`, `seats`)
    VALUES ('Mediolanum Forum', 'Italy', 'Milan', 'Via Giuseppe di Vittorio, 6', 12700);

INSERT INTO Hierarchy(`name`) VALUES('customer');
INSERT INTO Hierarchy(`name`) VALUES('seller');
INSERT INTO Hierarchy(`name`) VALUES('admin');

INSERT INTO Category(`name`) VALUES('Festival');
INSERT INTO Category(`name`) VALUES('Concert');
INSERT INTO Category(`name`) VALUES('Sport');
INSERT INTO Category(`name`) VALUES('Theatre');
INSERT INTO Category(`name`) VALUES('Opera');

/* Every notify is linked (visually) to the event in the Alert table */
INSERT INTO Notify(`text`) VALUES('Sold out.'); /* consumer */
INSERT INTO Notify(`text`) VALUES('Tickets running out.'); /* consumer */
INSERT INTO Notify(`text`) VALUES('Comes in 15 days.'); /* consumer */
INSERT INTO Notify(`text`) VALUES('Comes in 7 days.'); /* consumer */
INSERT INTO Notify(`text`) VALUES('Comes in 3 days.'); /* consumer */
INSERT INTO Notify(`text`) VALUES('Comes tomorrow.'); /* consumer */
INSERT INTO Notify(`text`) VALUES('Ticket sold.'); /* When an event owned by a seller is sold - seller */
INSERT INTO Notify(`text`) VALUES('Successfully submitted.'); /* When 'receive alert' is clicked - consumer. */
INSERT INTO Notify(`text`) VALUES('Your order has been received.'); /* When the user go ahead in the cart - consumer. */

INSERT INTO User(`email`, `password`, `name`, `surname`, `salt`, `privilege`) 
    VALUES('admin@wondertickets.it', 'c0a906cb22c758859ddc02273218959ae9696e6f996476092c6c3efb627552a9bfb7a6ee217f028c083be07eebf9d0d1f2318c2e9e94dafe9ddbd0a7c2a8d619', 'Elia', 'Marcatognini',
    '4f76b0b8897a3233d40954f48dc807f0f95e9e24cc7f341b03b9e3bef46630c39d00f00f25793ec110b99a0f8931391148938301d93b360a3cf494a2348d42bb', 'admin');
INSERT INTO User(`email`, `password`, `name`, `surname`, `vat`, `company`, `salt`, `privilege`, `approved`)
    VALUES('seller@wondertickets.it', '62db181a4688fd73be6eb92b6f46c58732da46edb1928ccd460a1e817e853675d332a353897bf5a602786441af33e5f32099c6941ec329425bc7194c3ac4bbde', 'Alberto', 'Marfoglia',
    '25121998123', 'Seller s.r.l.', '7417220ed2fa48e199ad0a8cb4df5e5f27e5e88cd405f9ad1c3cf04655bf0ed3dad51cdbd035e2d0f6d4547de0a3ada51d6fbd235cd8340cf12c32a9aee92ec0', 'seller', 0);
INSERT INTO User(`email`, `password`, `name`, `surname`, `salt`, `privilege`) 
    VALUES('customer@wondertickets.it', 'a6f88308e200208eff8a39278342e393e62351d474d7a0414edfbe09af70e2743c1bc2b03c859ee5b60b90e0aa33fbfcf99d4ef51fa61cf3f4ebf0391a3521b2', 'Tommaso', 'Mandoloni',
    'bb554d64102227be9b598a8a5a3d38725fbd089a572e6f637239be5b6f1dc06dda282d3fac82b4505300286687aeb72ab685a0b38a634c58369a9c4d2f3114ee', 'customer');

INSERT INTO Event(`title`, `date`, `time`, `artist`, `tickets`, `description`, `category_id`, `venue_id`, `user_id`)
    VALUES('Summer later Party', '2019-12-12', '21:30:00', 'Vasco Rossi', 100, 'Partying like no tomorrow.' , 2, 5, 2);
INSERT INTO Event(`title`, `date`, `time`, `artist`, `tickets`, `description`, `category_id`, `venue_id`, `user_id`)
    VALUES('Unix birthday', '2019-12-25', '21:15:00', 'DJUnix', 100, 'Come here to party with us!', 5, 1, 2);
INSERT INTO Event(`title`, `date`, `time`, `artist`, `tickets`, `description`, `category_id`, `venue_id`, `user_id`, `disabled`)
    VALUES('AAAA', '2019-12-25', '21:15:00', 'prova', 140, 'prova AAAA', 5, 1, 2, 1);
INSERT INTO Event(`title`, `date`, `time`, `artist`, `tickets`, `description`, `category_id`, `venue_id`, `user_id`, `disabled`)
    VALUES('DDDD', '2019-12-25', '21:15:00', 'prova', 120, 'prova DDDD', 5, 1, 2, 1);
INSERT INTO Event(`title`, `date`, `time`, `artist`, `tickets`, `description`, `category_id`, `venue_id`, `user_id`, `cancelled`)
    VALUES('BBBB', '2019-12-25', '21:15:00', 'prova', 180, 'prova BBBB', 5, 2, 2, 1);
INSERT INTO Event(`title`, `date`, `time`, `artist`, `tickets`, `description`, `category_id`, `venue_id`, `user_id`, `cancelled`)
    VALUES('CCCC', '2019-12-25', '21:15:00', 'prova', 123, 'prova CCCC', 5, 4, 2, 1);

INSERT INTO Submit(`user_id`, `event_id`) VALUES(3, 2);
INSERT INTO Submit(`user_id`, `event_id`) VALUES(3, 1);

INSERT INTO Ticket(`price`, `event_id`, `seat`) VALUES(100, 1, 1);
INSERT INTO Ticket(`price`, `event_id`, `available`, `user_id`, `purchase_date`, `seat`) VALUES(50, 1, 0, 3, '2019-12-5', 2);
INSERT INTO Ticket(`price`, `event_id`, `available`, `user_id`, `purchase_date`, `seat`) VALUES(50, 1, 0, 3, '2019-12-6', 3);
INSERT INTO Ticket(`price`, `event_id`, `seat`) VALUES(100, 1, 4);
INSERT INTO Ticket(`price`, `event_id`, `seat`) VALUES(100, 1, 5);
INSERT INTO Ticket(`price`, `event_id`, `seat`) VALUES(150, 1, 6);
INSERT INTO Ticket(`price`, `event_id`, `seat`) VALUES(150, 2, 1);
INSERT INTO Ticket(`price`, `event_id`, `seat`) VALUES(100, 2, 2);
INSERT INTO Ticket(`price`, `event_id`, `seat`) VALUES(100, 2, 3);
INSERT INTO Ticket(`price`, `event_id`, `seat`) VALUES(150, 2, 4);
INSERT INTO Ticket(`price`, `event_id`, `seat`) VALUES(150, 2, 5);
