<?php

Route::get('/folders/{id}/tasks', 'TaskController@index') -> name('tasks.index');
// getリクエストがきたら，TaskControllerのindexを呼ぶ，最後のnameはアプリ内の名称