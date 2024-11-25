<?php

require_once 'dbConfig.php';

function getAllUsers($pdo)
{
    $sql = "SELECT 
                astronaut_id, 
                first_name, 
                last_name, 
                suffix, 
                bdate, 
                gender, 
                nationality, 
                email, 
                CASE 
                    WHEN status = 1 THEN 'Active' 
                    WHEN status = 2 THEN 'Inactive' 
                    ELSE 'Unknown' 
                END AS status
            FROM astronaut
			ORDER BY astronaut_id ASC";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute();
    if ($executeQuery) {
        return $stmt->fetchAll();
    }
}

function getUserByID($pdo, $astronaut_id)
{
    $sql = "SELECT * from astronaut WHERE astronaut_id = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$astronaut_id]);

    if ($executeQuery) {
        return $stmt->fetch();
    }
}

function searchForAUser($pdo, $searchQuery)
{
    $sql = "SELECT 
                astronaut_id, 
                first_name, 
                last_name, 
                suffix, 
                bdate, 
                gender, 
                nationality, 
                email, 
                CASE 
                    WHEN status = 1 THEN 'Active' 
                    WHEN status = 2 THEN 'Inactive' 
                    ELSE 'Unknown' 
                END AS status
            FROM astronaut
            WHERE CONCAT(first_name, last_name, suffix, bdate, gender, nationality, email, 
                CASE 
                    WHEN status = 1 THEN 'Active' 
                    WHEN status = 2 THEN 'Inactive' 
                    ELSE 'Unknown' 
                END) LIKE ?";

    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute(["%" . $searchQuery . "%"]);
    if ($executeQuery) {
        return $stmt->fetchAll();
    }
}



function insertNewUser(
    $pdo,
    $first_name,
    $last_name,
    $suffix,
    $bdate,
    $gender,
    $nationality,
    $email
) {

    $sql = "INSERT INTO astronaut 
			(
				first_name,
				last_name,
				suffix,
				bdate,
				gender,
				nationality,
				email
			)
			VALUES (?,?,?,?,?,?,?)
			";

    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([
        $first_name,
        $last_name,
        $suffix,
        $bdate,
        $gender,
        $nationality,
        $email
    ]);

    if ($executeQuery) {
        return true;
    }

}

function editUser(
    $pdo,
    $gender,
    $nationality,
    $email,
    $astronaut_id
) {

    $sql = "UPDATE astronaut
				SET 
					gender = ?,
					nationality = ?,
					email = ?
				WHERE astronaut_id = ? 
			";

    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([
        $gender,
        $nationality,
        $email,
        $astronaut_id
    ]);

    if ($executeQuery) {
        return true;
    }

}


function deleteUser($pdo, $astronaut_id)
{
    $sql = "DELETE FROM astronaut 
			WHERE astronaut_id = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$astronaut_id]);

    if ($executeQuery) {
        return true;
    }
}




?>