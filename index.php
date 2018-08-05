<!doctype html>
<html lang="ru">
<head>
    <title>Задание</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <?php require_once $_SERVER['DOCUMENT_ROOT'].'/header.php'; ?>
</head>

<body>
    <header>
        <!-- Fixed navbar -->
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <a class="navbar-brand" href="/">
                <img src="nginx-logo.png" alt="[ Powered by nginx ]" width="121" height="32" />
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarCollapse">
                <?php
                    $active_main = active;
                    include $_SERVER['DOCUMENT_ROOT'].'/nav.php';
                ?>

            </div>
        </nav>
    </header>
    <!-- Begin page content -->
    <main class="container">
        <h1 class="m-top-75">Задание</h1>

        <hr />

        <pre>
Имеется тестовый  датасет  `MySQL Employees Sample`.

Необходимо сделать 2 страницы: поиск по датасету и отображение информации по сотруднику.

Решить задачу необходимо используя:

PHP 5.6+

ООП

PDO

MySQL

Чистый PHP(Без фреймворков и библиотек)

Для стилизации можно использовать bootstrap

Репозиторий с дампом - https://github.com/datacharmer/test_db

Структура базы - https://dev.mysql.com/doc/employee/en/sakila-structure.html			
        </pre>

    </main>

    <footer class="footer">
        <div class="container">
            <span class="text-muted">Copyright &#169; <?php include './footer.php';?></span>
        </div>
    </footer>
</body>
</html>


