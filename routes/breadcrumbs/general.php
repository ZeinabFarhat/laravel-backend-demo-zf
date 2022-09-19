<?php

use App\Models\User\User;

Breadcrumbs::resource('general_submissions', 'Submissions');

Breadcrumbs::for('general_submissions_form_page', function ($trail, $model) {
    $trail->parent('home');
    $trail->push('Submissions Per Form Page', route("general_submissions_form_page", $model));
});
