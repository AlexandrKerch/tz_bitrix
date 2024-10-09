<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<h2><?= htmlspecialchars($arParams['PAGE_TITLE']) ?></h2>
<?php if (!empty($arResult['ERROR'])): ?>
	<p><?= htmlspecialchars($arResult['ERROR']) ?></p>
<?php else: ?>
	<table border="1" cellpadding="5">
		<thead>
		<tr>
			<th>ID</th>
			<th>Дата регистрации</th>
			<th>Email</th>
			<th>ФИО</th>
			<th>Детали</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($arResult as $user): ?>
			<tr>
				<td><?= htmlspecialchars($user['ID']) ?></td>
				<td><?= htmlspecialchars($user['DATE_REGISTER']) ?></td>
				<td><?= htmlspecialchars($user['EMAIL']) ?></td>
				<td><?= htmlspecialchars($user['FULL_NAME']) ?></td>
				<td><a href="<?= $arParams['SEF_FOLDER'] . $user['ID']?>/">Посмотреть</a></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
<?php endif; ?>
