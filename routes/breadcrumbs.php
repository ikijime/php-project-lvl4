<?php

// routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;
// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Home
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('home.index'));
});

Breadcrumbs::for('login', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Login', route('login'));
});

Breadcrumbs::for('register', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Register', route('register'));
});

Breadcrumbs::for('tasks.index', function (BreadcrumbTrail $trail) {
    $trail->push('Tasks', route('tasks.index'));
});

Breadcrumbs::for('labels.index', function (BreadcrumbTrail $trail) {
    $trail->push('Labels', route('labels.index'));
});

Breadcrumbs::for('task_statuses.index', function (BreadcrumbTrail $trail) {
    $trail->push('Statuses', route('task_statuses.index'));
});
