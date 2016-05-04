<?php
use app\components\SidebarWidget;

$this->title = 'Авторизация';
$this->params['breadcrumbs'][] = ['label' => 'Авторизация'];
?>

<div class="loginmodal-container">
	<h1>Авторизация</h1><br>
	<form action="/login" method="post" name="login">
		<input type="text" name="login" placeholder="Логин">
		<input type="password" name="password" placeholder="Пароль">
		<input type="submit" name="login-btn" class="login loginmodal-submit" value="Войти">
	</form>
	<div class="login-help">
		<label>
			<input type="checkbox" name="remember_me" value="1" />
			Запомнить
		</label>
		<p>
			<a href="/forgot-password">Забыли пароль?</a>
		</p>
	</div>
</div>
