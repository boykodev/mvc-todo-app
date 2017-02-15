<?php
return array(
    // homepage
    '' => 'index/index',
    // tasks
	'tasks' => 'tasks/index',
    'task/new' => 'tasks/new',
    'task/([0-9]+)' => 'tasks/single/:id',
    'task/edit/([0-9]+)' => 'tasks/edit/:id',
    // ajax
    'ajax/preview' => 'ajax/preview',
    'ajax/login' => 'ajax/login',
    'ajax/logout' => 'ajax/logout',
    'ajax/upload' => 'ajax/upload'
);