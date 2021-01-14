DELIMITER |

CREATE PROCEDURE get_Privilege (IN p_Account_id INT UNSIGNED)  
BEGIN
	SELECT Privilege_id
	FROM Account_Has_Privilege
	WHERE Account_id = p_Account_id;
END |

CREATE PROCEDURE add_Privilege (IN p_Account_id INT UNSIGNED,
								IN p_Privilege_id INT UNSIGNED)
BEGIN
	INSERT INTO Account_Has_Privilege (Account_id, Privilege_id)
				VALUES ( p_Account_id, p_Privilege_id);
END |

CREATE PROCEDURE remove_Privilege (IN p_Account_id INT UNSIGNED,
									IN p_Privilege_id INT UNSIGNED)
BEGIN
	DELETE FROM Account_Has_Privilege
			WHERE Account_id = p_Account_id
					AND Privilege_id = p_Privilege_id;
END |

DELIMITER ;