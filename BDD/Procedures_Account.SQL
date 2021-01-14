DELIMITER |

CREATE PROCEDURE get_Account (IN p_id INT UNSIGNED)  
BEGIN
	SELECT id, FirstName, Name, Pseudo, Password 
	FROM Account
	WHERE id = p_id;
END |

CREATE PROCEDURE get_Accounts ()
BEGIN
	SELECT id, FirstName, Name, Pseudo, Password 
	FROM Account;
END |

CREATE PROCEDURE get_Connection (IN p_Pseudo VARCHAR(40),
							IN p_Password VARCHAR(40))  
BEGIN
	SELECT id, FirstName, Name, Pseudo, Password 
	FROM Account
	WHERE Pseudo = p_Pseudo AND Password = p_Password;
END |

CREATE PROCEDURE new_Account (IN p_FirstName VARCHAR(40),
							IN p_Name VARCHAR(40),
							IN p_Pseudo VARCHAR(40),
							IN p_Password VARCHAR(40))  
BEGIN
	INSERT INTO Account (id, FirstName, Name, Pseudo, Password)
				VALUES (NULL, p_FirstName, p_Name, p_Pseudo, p_Password);
	SELECT LAST_INSERT_ID() AS id;
END |

CREATE PROCEDURE update_Account (IN p_id INT UNSIGNED,
								IN p_FirstName VARCHAR(40),
								IN p_Name VARCHAR(40),
								IN p_Pseudo VARCHAR(40),
								IN p_Password VARCHAR(40))  
BEGIN
	UPDATE Account
		SET FirstName = p_FirstName,
			Name = p_Name,
			Pseudo = p_Pseudo,
			Password = p_Password
		WHERE id = p_id;
END |

CREATE PROCEDURE remove_Account (IN p_id INT UNSIGNED)  
BEGIN
	DELETE FROM Account
			WHERE id = p_id;
END |

CREATE PROCEDURE get_AccountPrivilegied (IN p_Privilege_id INT UNSIGNED)  
BEGIN
	SELECT id, FirstName, Name, Pseudo, Password 
	FROM Account
	JOIN (
			SELECT Account_id
			FROM Account_Has_Privilege
			WHERE privilege_id = p_Privilege_id
			) AS Priv
	ON Priv.Account_id = Account.id;
END |

CREATE PROCEDURE count_Account ()  
BEGIN
	SELECT COUNT(*) AS num
	FROM Account;
END |

CREATE PROCEDURE count_AccountPrivilegied (IN p_Privilege_id INT UNSIGNED)  
BEGIN
	SELECT COUNT(*) AS num
	FROM Account
	JOIN (
			SELECT Account_id
			FROM Account_Has_Privilege
			WHERE privilege_id = p_Privilege_id
			) AS Priv
	ON Priv.Account_id = Account.id;
END |

CREATE PROCEDURE exist_Account (IN p_id INT UNSIGNED)  
BEGIN
	SELECT COUNT(*) AS num
	FROM Account
	WHERE id = p_id;
END |


CREATE PROCEDURE work_on (IN p_Task_id INT UNSIGNED)  
BEGIN
	SELECT Account.id, Account.FirstName, Account.Name, Account.Pseudo, Account.Password
	FROM Account
	LEFT JOIN (
			SELECT Account_id
			FROM Work_On
			WHERE Task_id = p_Task_id
			) AS work
	ON work.Account_id = Account.id;
	WHERE work.Account_id IS NOT NULL;
END |

CREATE PROCEDURE dont_work_on (IN p_Task_id INT UNSIGNED)  
BEGIN
	SELECT Account.id, Account.FirstName, Account.Name, Account.Pseudo, Account.Password
	FROM Account
	LEFT JOIN (
			SELECT Account_id
			FROM Work_On
			WHERE Task_id = p_Task_id
			) AS work
	ON work.Account_id = Account.id;
	WHERE work.Account_id IS NULL;
END |

CREATE PROCEDURE client (IN p_Task_id INT UNSIGNED)  
BEGIN
	SELECT Account.id, Account.FirstName, Account.Name, Account.Pseudo, Account.Password
	FROM Account
	LEFT JOIN (
			SELECT Account_id
			FROM Customer_Order
			WHERE Task_id = p_Task_id
			) AS work
	ON work.Account_id = Account.id;
	WHERE work.Account_id IS NOT NULL;
END |

CREATE PROCEDURE not_client (IN p_Task_id INT UNSIGNED)  
BEGIN
	SELECT Account.id, Account.FirstName, Account.Name, Account.Pseudo, Account.Password
	FROM Account
	LEFT JOIN (
			SELECT Account_id
			FROM Customer_Order
			WHERE Task_id = p_Task_id
			) AS work
	ON work.Account_id = Account.id;
	WHERE work.Account_id IS NOT NULL;
END |

DELIMITER ;


