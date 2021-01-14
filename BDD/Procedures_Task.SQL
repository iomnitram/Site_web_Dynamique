DELIMITER |

CREATE PROCEDURE get_Task (IN p_id INT UNSIGNED)  
BEGIN
	SELECT *
	FROM Task
	WHERE id = p_id;
END |

CREATE PROCEDURE new_Task (IN p_Name VARCHAR(40),
							IN p_Description TEXT,
							IN p_Done INT)  
BEGIN
	INSERT INTO Task (id, Name, Description, Done)
				VALUES (NULL, p_Name, p_Description,p_Done);
	SELECT LAST_INSERT_ID() AS id;
END |

CREATE PROCEDURE delete_Task (IN p_id INT UNSIGNED)
BEGIN
	DELETE FROM Task
			WHERE id = p_id;
END |

CREATE PROCEDURE update_Task (IN p_id INT UNSIGNED,
								IN p_Name VARCHAR(40),
								IN p_Description TEXT,
								IN p_Done INT)  
BEGIN
	UPDATE Task
		SET Name = p_Name,
			Description = p_Description
			Done = p_Done
		WHERE id = p_id;
END |

CREATE PROCEDURE get_Task_All ()  
BEGIN
	SELECT *
	FROM Task;
END |

CREATE PROCEDURE exist_Task (IN p_id INT UNSIGNED)  
BEGIN
	SELECT COUNT(*) AS num
	FROM Task
	WHERE id = p_id;
END |

CREATE PROCEDURE get_Task_OnDone (IN p_Done INT)  
BEGIN
	SELECT id, Name , Description , Done
	FROM Task
	WHERE Done = p_Done;
END |



CREATE PROCEDURE get_Task_Client_OnDone (IN p_Account_id INT UNSIGNED,
											IN p_Done INT)  
BEGIN
	SELECT Task.id, Task.Name , Task.Description, Task.Done
	FROM Task
	LEFT JOIN (
		SELECT Task_id
		FROM Customer_Order
		WHERE Account_id = p_Account_id
		) AS Client
		ON Task.id = Client.Task_id
	WHERE Client.Task_id IS NOT NULL
			AND Done = p_Done;
END |



CREATE PROCEDURE get_Task_Trav_OnDone (IN p_Account_id INT UNSIGNED,
											IN p_Done INT)  
BEGIN
	SELECT Task.id, Task.Name , Task.Description, Task.Done
	FROM Task
	LEFT JOIN (
		SELECT Task_id
		FROM Work_On
		WHERE Account_id = p_Account_id
		) AS Trav
		ON Task.id = Trav.Task_id
	WHERE Trav.Task_id IS NOT NULL
			AND Done = p_Done;
END |



CREATE PROCEDURE add_Order (IN p_Task_id INT UNSIGNED,
							IN p_Account_id INT UNSIGNED)  
BEGIN
	INSERT INTO Customer_Order (Task_id, Account_id)
				VALUES (p_Task_id, p_Account_id);
END |

CREATE PROCEDURE delete_Order (IN p_Task_id INT UNSIGNED,
							IN p_Account_id INT UNSIGNED)
BEGIN
	DELETE FROM Customer_Order
			WHERE Task_id = p_Task_id AND Account_id = p_Account_id;
END |

CREATE PROCEDURE exist_Order (IN p_Task_id INT UNSIGNED,
							IN p_Account_id INT UNSIGNED)  
BEGIN
	SELECT COUNT(*) AS num
	FROM Customer_Order
	WHERE Task_id = p_Task_id AND Account_id = p_Account_id;
END |

CREATE PROCEDURE add_Work (IN p_Task_id INT UNSIGNED,
							IN p_Account_id INT UNSIGNED)  
BEGIN
	INSERT INTO Work_On (Task_id, Account_id)
				VALUES (p_Task_id, p_Account_id);
END |

CREATE PROCEDURE delete_Work (IN p_Task_id INT UNSIGNED,
							IN p_Account_id INT UNSIGNED)
BEGIN
	DELETE FROM Work_On
			WHERE Task_id = p_Task_id AND Account_id = p_Account_id;
END |

CREATE PROCEDURE exist_Work (IN p_Task_id INT UNSIGNED,
							IN p_Account_id INT UNSIGNED)  
BEGIN
	SELECT COUNT(*) AS num
	FROM Work_On
	WHERE Task_id = p_Task_id AND Account_id = p_Account_id;
END |

DELIMITER ;