CREATE TABLE `AUT_USER` (
  `usr_id` INT UNSIGNED AUTO_INCREMENT NOT NULL,
  CONSTRAINT `PRIMARY_KEY` PRIMARY KEY (`usr_id`)
);

insert into `AUT_USER`(usr_id) values(3);

commit;
