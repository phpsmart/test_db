				<ul class="navbar-nav mr-auto">
					<li class="nav-item <?php if ($active_main == 'active') {echo ' active';} ?>">
						<a class="nav-link" href="/">Задание <span class="sr-only"></span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="javascript: void();">|</a>
					</li>
					<li class="nav-item <<?php if ($active_search == 'active') {echo ' active';} ?>">
						<a class="nav-link" href="/search">Поиск по базе данных</a>
					</li>
                    <li class="nav-item">
                        <a class="nav-link" href="javascript: void();">|</a>
                    </li>
                    <li class="nav-item <<?php if ($active_search_emp == 'active') {echo ' active';} ?>">
                        <a class="nav-link" href="/employees">Информация по сотруднику</a>
                    </li>
				</ul>


