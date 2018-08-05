<?php

/**
 * Обработчик запроса к базе данных для получения информации по сотруднику
 *
 */

require $_SERVER['DOCUMENT_ROOT'].'/../core/db.php';
$db_conn = require $_SERVER['DOCUMENT_ROOT'].'/../config/db_conn.php';
$pdo = DB::pdo($db_conn);

if ($_REQUEST['search']) {
    $value = filter_input(INPUT_POST, "search", FILTER_VALIDATE_INT);
//    array("options" => array("min_range" => 1, "max_range" => 999999)));

    if ($value) {
        // Выполняем обработку данных
        $emp_no = $_REQUEST['search'];
    } else {
        // Обрабатываем ошибку
        $response['emp_row'] = [];
        $response['rows'] = [0];
        $response['error'] = 'Передан неверный параметр.';
        echo json_encode($response);
        exit;
    }
} else {
    $response['emp_row'] = [];
    $response['rows'] = [0];
    $response['error'] = 'Передан пустой параметр.';
    echo json_encode($response);
    exit;
}

$queryRecCount = "
    SELECT
        COUNT(1) rec_count
    FROM 
        employees AS e
    LEFT JOIN 
        dept_emp AS de 
        ON	(de.emp_no = e.emp_no)
    INNER JOIN dept_emp_latest_date l
        ON de.emp_no = l.emp_no AND de.from_date = l.from_date AND l.to_date = de.to_date         
    LEFT JOIN 
        departments AS d 
        ON de.dept_no = d.dept_no 
    LEFT JOIN 
        titles AS t 
        ON e.emp_no = t.emp_no
    LEFT JOIN 
        salaries AS s 
        ON e.emp_no = s.emp_no
    WHERE
		(e.emp_no = :emp_no)";

$stmt = $pdo->prepare($queryRecCount);
$stmt->bindParam(':emp_no', $emp_no, PDO::PARAM_STR, 20);
$stmt->execute();
$row = $stmt->fetch();
$response['recCount'] = $row['rec_count'];

$query = "
    SELECT 
        e.emp_no, 
        e.first_name, 
        e.last_name
    FROM 
        employees AS e 
    WHERE 
        e.emp_no = :e_emp_no
        ";

$stmt = $pdo->prepare($query);
$stmt->bindParam(':e_emp_no', $emp_no, PDO::PARAM_STR, 20);
$stmt->execute();
$rows = $stmt->fetchAll();
$response['rows'] = $rows;
$response['emp_row'] = $rows;

if (!$rows) {
    $response['error'] =  'Нет сотрудника с таким номером.';
    echo json_encode($response);
    exit;
}

$query = "
    SELECT
        e.emp_no,
        e.first_name,
        e.last_name,
        d.dept_name,
        t.title,
        s.salary,
        s.from_date,
        s.to_date
    FROM 
        employees AS e
    LEFT JOIN 
        dept_emp AS de 
        ON	(de.emp_no = e.emp_no)
    INNER JOIN dept_emp_latest_date l
        ON de.emp_no = l.emp_no AND de.from_date = l.from_date AND l.to_date = de.to_date         
    LEFT JOIN 
        departments AS d 
        ON de.dept_no = d.dept_no 
    LEFT JOIN 
        titles AS t 
        ON e.emp_no = t.emp_no
    LEFT JOIN 
        salaries AS s 
        ON e.emp_no = s.emp_no
        AND (s.to_date < '9999-01-01')
    WHERE
		e.emp_no = :e_emp_no AND 
		s.emp_no = :s_emp_no
		";

$stmt = $pdo->prepare($query);
$stmt->bindParam(':e_emp_no', $emp_no, PDO::PARAM_STR, 20);
$stmt->bindParam(':s_emp_no', $emp_no, PDO::PARAM_STR, 20);
$stmt->execute();
$rows = $stmt->fetchAll();
$response['rows'] = $rows;
//$response['query'] = $query;

if (empty($rows))
{
    $response['error'] =  'Нет данных по зарплате.';
}

echo json_encode($response);




















