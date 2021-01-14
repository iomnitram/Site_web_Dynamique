CREATE DATABASE IF NOT EXISTS Task_Manager CHARACTER SET 'utf8';

USE Task_Manager;

CREATE TABLE IF NOT EXISTS Account (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	FirstName VARCHAR(40),
	Name VARCHAR(40),
	Pseudo VARCHAR(40) NOT NULL,
	Password VARCHAR(40) NOT NULL,
	PRIMARY KEY (id),
	UNIQUE INDEX ind__Account__Pseudo (Pseudo(10)) 
)
ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS Privilege (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	Name VARCHAR(20),
	PRIMARY KEY (id)
)
ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS Task (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	Name VARCHAR(40),
	Description TEXT,
	PRIMARY KEY (id)
)
ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS Task_State (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	Name VARCHAR(20),
	PRIMARY KEY (id)
)
ENGINE=INNODB;


CREATE TABLE IF NOT EXISTS Account_Has_Privilege (
	Privilege_id INT UNSIGNED NOT NULL,
	Account_id INT UNSIGNED NOT NULL,
	UNIQUE INDEX ind_uni__Account_Has_Privilege__Privilege_Account (Privilege_id, Account_id),
	CONSTRAINT fk__Account_Has_Privilege__Privilege
		FOREIGN KEY (Privilege_id)
		REFERENCES Privilege(id)
		ON DELETE CASCADE
		ON UPDATE CASCADE,
	CONSTRAINT fk__Account_Has_Privilege__Account
		FOREIGN KEY (Account_id)
		REFERENCES Account(id)
		ON DELETE CASCADE
		ON UPDATE CASCADE
)
ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS Task_Has_State (
	Task_id INT UNSIGNED NOT NULL,
	Task_State_id INT UNSIGNED NOT NULL,
	moment DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	UNIQUE INDEX ind_uni__Task_Has_State__Task_State (Task_id, Task_State_id),
	CONSTRAINT fk__Task_Has_State__Task
		FOREIGN KEY (Task_id)
		REFERENCES Task(id)
		ON DELETE CASCADE
		ON UPDATE CASCADE
)
ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS Work_On (
	Task_id INT UNSIGNED NOT NULL,
	Account_id INT UNSIGNED NOT NULL,
	UNIQUE INDEX ind_uni__Work_on__Task_Account (Task_id, Account_id),
	CONSTRAINT fk__Work_on__Task
		FOREIGN KEY (Task_id)
		REFERENCES Task(id)
		ON DELETE CASCADE
		ON UPDATE CASCADE,
	CONSTRAINT fk__Work_on__Account
		FOREIGN KEY (Account_id)
		REFERENCES Account(id)
		ON DELETE CASCADE
		ON UPDATE CASCADE
)
ENGINE=INNODB;


CREATE TABLE IF NOT EXISTS Customer_Order (
	Task_id INT UNSIGNED NOT NULL,
	Account_id INT UNSIGNED NOT NULL,
	UNIQUE INDEX ind_uni__Customer_Order__Task (Task_id),
	CONSTRAINT fk__Customer_Order__Task
		FOREIGN KEY (Task_id)
		REFERENCES Task(id)
		ON DELETE CASCADE
		ON UPDATE CASCADE,
	CONSTRAINT fk__Customer_Order__Account
		FOREIGN KEY (Account_id)
		REFERENCES Account(id)
		ON DELETE CASCADE
		ON UPDATE CASCADE
)
ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS Sub_Task (
	Task_id_Father INT UNSIGNED NOT NULL,
	Task_id_Son INT UNSIGNED NOT NULL,
	UNIQUE INDEX ind_uni__Sub_Task__Task_Son (Task_id_Son),
	CONSTRAINT fk__Sub_Task__Father
		FOREIGN KEY (Task_id_Father)
		REFERENCES Task(id)
		ON DELETE CASCADE
		ON UPDATE CASCADE,
	CONSTRAINT fk__Sub_Task__Son
		FOREIGN KEY (Task_id_Son)
		REFERENCES Task(id)
		ON DELETE CASCADE
		ON UPDATE CASCADE
)
ENGINE=INNODB;