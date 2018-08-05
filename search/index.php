<!doctype html>
<html lang="ru">
    <head>
        <title>Поиск по базе данных</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <?php require_once $_SERVER['DOCUMENT_ROOT'].'/../header.php'; ?>
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
                    $active_search = active;
                    include $_SERVER['DOCUMENT_ROOT'].'/../nav.php';
                ?>
            </div>
        </nav>
    </header>
        <!-- Begin page content -->
        <main class="container">
            <h1 class="m-top-75">Поиск по базе данных</h1>

            <hr />

            <form class="form-inline" id="search_form">
                <input id="search-text" class="form-control mr-sm-2" type="text" placeholder="Строка поиска..." aria-label="Поиск" value="Bre">
                <button id="search-db-btn" class="btn btn-success" type="button">Искать</button>
            </form>

            <hr />

            <span id="set_count"></span>

            <div class="preloader hidden">
                <div>Загрузка... &nbsp;&nbsp;&nbsp;</div>
                <div class="item-1"></div>
                <div class="item-2"></div>
                <div class="item-3"></div>
                <div class="item-4"></div>
                <div class="item-5"></div>
            </div>

            <div id="execute-time"></div>
            <div id="data-show"></div>
            <div id="bracket"></div>
            <div id="employee-detail"></div>
            <div id="query"></div>
            <div id="error"></div>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Идентификатор</th>
                        <th>Отдел</th>
                        <th>Имя</th>
                        <th>Фамилия</th>
                        <th>Статус</th>

                    </tr>
                </thead>
                <tbody id="result">

                </tbody>
            </table>

        </main>

        <footer class="footer">
            <div class="container">
                <span class="text-muted">Copyright &#169; <?php include $_SERVER['DOCUMENT_ROOT'].'/../footer.php';?></span>
            </div>
        </footer>
    </body>
</html>


