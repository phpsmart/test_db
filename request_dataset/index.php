<?php

/**
 * Поиск по датасету
 *
 */

$time_start = time();

require $_SERVER['DOCUMENT_ROOT'].'/../core/db.php';
$db_conn = require $_SERVER['DOCUMENT_ROOT'].'/../config/db_conn.php';
$pdo = DB::pdo($db_conn);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response['rows'] = [0];
    $response['error'] = 'Неверный метод передачи данных.';
    echo json_encode($response);
    exit;
}

if ($_REQUEST['search']) {
    $check = filter_var(
        $_REQUEST['search'],
        FILTER_VALIDATE_REGEXP,
        array('options'=>array('regexp'=>'/[a-zA-Z]+/is'))
    );

    if ($check) {
        $search_param = $_REQUEST['search'];
    } else {
        // Обрабатываем ошибку
        $response['rows'] = [0];
        $response['error'] = 'Передан неверный параметр.';
        echo json_encode($response);
        exit;
    }

} else {
    $response['rows'] = [0];
    $response['error'] = 'Передан пустой параметр.';
    echo json_encode($response);
    exit;
}

$records = 100;
$from = 1;
$to = $records;

if ($_REQUEST['data_from']) {
    $from = $_REQUEST['data_from'];
}

if ($_REQUEST['data_to']) {
    $to = $_REQUEST['data_to'];
}

$search_param = "$search_param%";

if (strlen($search_param) == 0) {
    $response['rec_count'] = 0;
    $response['rows'] = 0;
    echo json_encode($response);
    exit;
}

$queryRecCount = "
    SELECT
        count(1) rec_count
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

    WHERE 
	(
		(e.first_name LIKE :first_name_param OR e.last_name LIKE :last_name_param) OR 
		(d.dept_name LIKE :dept_param) OR
		(t.title LIKE :title_param)
	)	
	";

$query = "
    SELECT
        e.emp_no,
        e.first_name,
        e.last_name,
        d.dept_name,
        t.title
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
    
    WHERE 
        (
            (e.first_name LIKE :first_name_param OR e.last_name LIKE :last_name_param) OR 
            (d.dept_name LIKE :dept_param) OR
            (t.title LIKE :title_param)
        )
    LIMIT $from, $to	
	";

$stmt = $pdo->prepare($queryRecCount);
$stmt->bindParam(':dept_param', $search_param, PDO::PARAM_STR, 20);
$stmt->bindParam(':title_param', $search_param, PDO::PARAM_STR, 20);
$stmt->bindParam(':first_name_param', $search_param, PDO::PARAM_STR, 20);
$stmt->bindParam(':last_name_param', $search_param, PDO::PARAM_STR, 20);
$stmt->execute();
$row = $stmt->fetch();
$response['rec_count'] = (int)$row['rec_count'];
$page_count = intdiv($row['rec_count'], $records);
$modulo = $row['rec_count']%$records;
$response['records'] = $records;
$response['data_from'] = $from;
$response['data_to'] = $to;
$response['page_count'] = $page_count;
$response['modulo'] = $modulo;

$stmt = $pdo->prepare($query);
$stmt->bindParam(':dept_param', $search_param, PDO::PARAM_STR, 20);
$stmt->bindParam(':title_param', $search_param, PDO::PARAM_STR, 20);
$stmt->bindParam(':first_name_param', $search_param, PDO::PARAM_STR, 20);
$stmt->bindParam(':last_name_param', $search_param, PDO::PARAM_STR, 20);
$stmt->execute();
$rows = $stmt->fetchAll();
$response['rows'] = $rows;
$time_end = time();
$time_execute = $time_end - $time_start;
$response['time_execute'] = $time_execute;

echo json_encode($response);





