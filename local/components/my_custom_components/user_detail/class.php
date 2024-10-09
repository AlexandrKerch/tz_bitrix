<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Bitrix\Main\Entity\Query;
use Bitrix\Main\Context;

class UserDetailComponent extends CBitrixComponent {
	public function onPrepareComponentParams($arParams) {
		$arParams["USE_FILTER"] = $arParams["USE_FILTER"] === "Y" ? "Y" : "N";
		$arParams["FILTER_NAME"] = trim($arParams["FILTER_NAME"]) ?: "arrFilter";
		$arParams["CACHE_TIME"] = intval($arParams["CACHE_TIME"]) > 0 ? $arParams["CACHE_TIME"] : 3600;

		return $arParams;
	}

	public function executeComponent() {
		// Проверяем, нужно ли использовать фильтр
		if ($this->arParams["USE_FILTER"] === "Y") {
			// Проверяем, существует ли фильтр
			if (isset($GLOBALS[$this->arParams["FILTER_NAME"]]) && is_array($GLOBALS[$this->arParams["FILTER_NAME"]])) {
				$filter = $GLOBALS[$this->arParams["FILTER_NAME"]];
			} else {
				ShowError("Фильтр не задан или некорректен.");
				return;
			}
		} else {
			// Если фильтр не используется, устанавливаем пустой фильтр
			$filter = [];
		}

		if ($this->startResultCache()) {
			if (!Loader::includeModule("main")) {
				$this->abortResultCache();
				ShowError("Модуль 'main' не загружен.");
				return;
			}

			// Получение данных пользователя
			$this->arResult = $this->getUserDetails($filter);

			if (!$this->arResult) {
				$this->abortResultCache();
				ShowError("Пользователь не найден.");
				return;
			}

			$this->endResultCache();
		}else{
			$this->arResult = $this->getUserDetails($filter);
		}

		$this->includeComponentTemplate();
	}

	protected function getUserDetails($filter) {
		// Запрос для получения данных о пользователе
		$query = new Query(\Bitrix\Main\UserTable::getEntity());
		$query->setSelect(['ID', 'NAME', 'LAST_NAME', 'EMAIL', 'PERSONAL_PHONE']);
		$query->setFilter($filter);

		$result = $query->exec();
		if ($user = $result->fetch()) {
			// Получаем группы пользователя
			$user['GROUPS'] = $this->getUserGroups($user['ID']);
			return $user;
		}

		return null;
	}

	protected function getUserGroups($userId) {
		// Получаем группы пользователя
		$groups = [];
		$groupQuery = new Query(\Bitrix\Main\UserGroupTable::getEntity());
		$groupQuery->setSelect(['GROUP_ID']);
		$groupQuery->setFilter(['=USER_ID' => $userId]);

		$groupResult = $groupQuery->exec();
		while ($group = $groupResult->fetch()) {
			$groups[] = $group['GROUP_ID'];
		}

		return $groups;
	}
}
?>
