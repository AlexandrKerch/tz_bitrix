<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
if ($arResult) {
	?>
	<h2>Детали пользователя</h2>
	<p><strong>ID:</strong> <?= htmlspecialchars($arResult['ID']) ?></p>
	<p><strong>ФИО:</strong> <?= htmlspecialchars($arResult['NAME'] . ' ' . $arResult['LAST_NAME']) ?></p>
	<p><strong>Email:</strong> <?= htmlspecialchars($arResult['EMAIL']) ?></p>
	<p><strong>Телефон:</strong> <?= htmlspecialchars($arResult['PERSONAL_PHONE']) ?></p>
	<p><strong>Группы:</strong> <?= implode(', ', $arResult['GROUPS']) ?></p>
	<?php
} else {
	echo "Пользователь не найден.";
}
?>
