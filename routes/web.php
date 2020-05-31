<?php
// getリクエストがきたら，TaskControllerのindexを呼ぶ，最後のnameはアプリ内での名称
Route::get('/folders/{id}/tasks', 'TaskController@index') -> name('tasks.index');
Route::get('/folders/create', 'FolderController@showCreateForm') -> name('folders.create');
Route::post('/folders/create', 'FolderController@create');