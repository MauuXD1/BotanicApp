<?php

use Illuminate\Support\Facades\Route;
use App\MoonShine\Resources\MongoUser\Pages\MongoUserIndexPage;
use App\MoonShine\Resources\MongoUser\Pages\MongoUserFormPage;

Route::get('/mongo-users', MongoUserIndexPage::class)->name('mongo-users.index');
Route::get('/mongo-users/create', MongoUserFormPage::class)->name('mongo-users.create');
Route::get('/mongo-users/{id}/edit', MongoUserFormPage::class)->name('mongo-users.edit');