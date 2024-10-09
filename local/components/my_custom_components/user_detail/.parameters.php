<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$arComponentParameters = [
	"PARAMETERS" => [
		"USE_FILTER" => [
			"PARENT" => "BASE",
			"NAME" => "Использовать фильтр",
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
		],
		"FILTER_NAME" => [
			"PARENT" => "BASE",
			"NAME" => "Имя фильтра",
			"TYPE" => "STRING",
			"DEFAULT" => "arrFilter",
		],
		"CACHE_TIME" => [
			"DEFAULT" => 3600,
		],
	],
];
?>