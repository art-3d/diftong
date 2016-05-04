<?php
use app\components\SidebarWidget;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = ['label' => 'Регистрация'];
?>

<div class="loginmodal-container">
	<h1>Регистрация</h1><br>
	<form action="/signup" method="post" name="signup">
		<input type="text" name="login" placeholder="Логин">
		<input type="text" name="email" placeholder="E-mail">
		<input type="password" name="password" placeholder="Пароль">
		<input type="password" name="re-password" placeholder="Повторите пароль">
		<input type="submit" name="signup-btn" class="login loginmodal-submit" value="Зарегистрироваться">
	</form>
	<div class="signup-help">
	  <!-- signup help -->
	</div>
</div>
