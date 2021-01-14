DELIMITER |

CREATE PROCEDURE get_State (IN p_Account_id INT UNSIGNED)  
BEGIN
	SELECT Privilege_id
	FROM Task_Has_State
	LEFT JOIN (
		SELECT *
		FROM Task_State
		) AS noms
		ON noms.id = Task_Has_State.Task_State_id
	WHERE Account_id = p_Account_id;
END |

CREATE PROCEDURE add_State (IN p_Account_id INT UNSIGNED,
								IN p_Privilege_id INT UNSIGNED)
BEGIN
	INSERT INTO Account_Has_Privilege (Account_id, Privilege_id)
				VALUES ( p_Account_id, p_Privilege_id);
END |

CREATE PROCEDURE remove_State (IN p_Account_id INT UNSIGNED,
									IN p_Privilege_id INT UNSIGNED)
BEGIN
	DELETE FROM Account_Has_Privilege
			WHERE Account_id = p_Account_id
					AND Privilege_id = p_Privilege_id;
END |



DELIMITER ;