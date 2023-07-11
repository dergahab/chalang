<?php

Breadcrumbs::for('/', function ($trail) {
    $trail->push('Uawe', route('/'));
});

Breadcrumbs::for('user', function ($trail) {
    $trail->parent('user');
    $trail->push('User', route('user.index'));
});
