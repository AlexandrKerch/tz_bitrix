<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Bitrix\Main\Engine\Contract\Controllerable;
use Bitrix\Main\Entity\Query;
use Bitrix\Main\Application;

class UserListComponent extends CBitrixComponent implements Controllerable
{
	public function onPrepareComponentParams($arParams)
	{
		$arParams["CACHE_TIME"] = intval($arParams["CACHE_TIME"]) > 0 ? $arParams["CACHE_TIME"] : 3600;
		$arParams["PAGE_TITLE"] = trim($arParams["PAGE_TITLE"]);

		return $arParams;
	}

	public function executeComponent()
	{
		$this->arResult = [];

		// Настройка кэширования
		if ($this->startResultCache($this->arParams["CACHE_TIME"])) {
			// Проверка загрузки модуля
			if (!Loader::includeModule("main")) {
				$this->abortResultCache();
				ShowError("Модуль 'main' не загружен.");
				return;
			}

			// Получение списка пользователей
			$this->arResult = $this->getUserList();

			// Устанавливаем заголовок страницы
			 // $APPLICATION->SetTitle($this->arParams["PAGE_TITLE"]);

			// Если результат пустой, устанавливаем сообщение
			if (empty($this->arResult)) {
				$this->arResult['ERROR'] = "Пользователи не найдены.";
			}

			$this->endResultCache();
		}

		$this->includeComponentTemplate();
	}

	protected function getUserList()
	{
		$userList = [];

		// Используем ORM для выборки пользователей
		$query = new Query(\Bitrix\Main\UserTable::getEntity());
		$query->setSelect(['ID', 'DATE_REGISTER', 'EMAIL', 'NAME', 'LAST_NAME', 'PERSONAL_PHONE']);
		$query->setOrder(['ID' => 'ASC']);

		$result = $query->exec();
		while ($user = $result->fetch()) {
			$userList[] = [
				'ID' => $user['ID'],
				'DATE_REGISTER' => $user['DATE_REGISTER'],
				'EMAIL' => $user['EMAIL'],
				'FULL_NAME' => trim($user['NAME'] . ' ' . $user['LAST_NAME']),
				'PHONE' => $user['PERSONAL_PHONE'],
			];
		}

		return $userList;
	}

	public function configureActions()
	{
		return [];
	}
}
?>