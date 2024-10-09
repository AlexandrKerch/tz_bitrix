<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$arComponentParameters = [
	"PARAMETERS" => [
		"SEF_MODE" => [
			"user_list" => [
				"NAME" => "Страница списка пользователей",
				"DEFAULT" => "/user_lists/",
				"VARIABLES" => []
			],
			"user_detail" => [
				"NAME" => "Страница детальной информации о пользователе",
				"DEFAULT" => "/user_lists/#USER_ID#/",
				"VARIABLES" => ["USER_ID"]
			],
		],
		"CACHE_TIME" => ["DEFAULT" => 3600],
		"PAGE_TITLE" => [
			"PARENT" => "BASE",
			"NAME" => "Заголовок страницы",
			"TYPE" => "STRING",
			"DEFAULT" => "Список пользователей",
		],
	],
];
?>