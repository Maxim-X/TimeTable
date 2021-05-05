<?php

if (!Account::$AUTH || !(Account::$ACCOUNT_TYPE != 1 || Account::$ACCOUNT_TYPE != 2)) {
	header('Location: /login');
	exit;
}

Route::$TITLE = "Таблица групп";
Route::$DESCRIPTION = "Таблица групп";