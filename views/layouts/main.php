<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
		<meta charset="<?= Yii::$app->charset ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<?= Html::csrfMetaTags() ?>
		<title><?= Html::encode($this->title) ?></title>
		<?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
		<?php
		NavBar::begin([
				'brandLabel' => '<span class="green">D</span>iftong',
				'brandUrl' => Yii::$app->homeUrl,
				'options' => [
						'class' => 'navbar navbar-default navbar-static-top',
				],
		]);
		echo Nav::widget([
				'options' => ['class' => 'navbar-nav navbar-left'],
				'items' => [
						['label' => 'Высшие учебные заведения', 'url' => ['/inst'], 'active' => \Yii::$app->controller->action->id == 'inst'],
						['label' => 'Технические учебные заведения', 'url' => ['/tech'], 'active' => \Yii::$app->controller->action->id == 'tech'],
						['label' => 'Обратная связь', 'url' => ['/feedback'], 'active' => \Yii::$app->controller->action->id == 'feedback'],
						['label' => 'О нас', 'url' => ['/about'], 'active' => \Yii::$app->controller->action->id == 'about'],
				],
		]);
		echo Nav::widget([
			'options'	=> ['class' => 'navbar-nav navbar-right'],
			'items' 		=> [
				Yii::$app->user->isGuest ? ['label' => 'Авторизация', 'url' => ['/login'],
					'options' => [
						'data-toggle' => 'modal',
						'data-target' => '#auth-form',
					]] :
				['label' => 'Logout (' . Yii::$app->user->identity->username . ')',
					'url' => ['/logout'],
					//'linkOptions' => ['data-method' => 'post']
				],
			],
		]);
		NavBar::end();
		?>

		<div class="container">
				<?= Breadcrumbs::widget([
						'homeLink' => [
								'label' => 'Diftong',
								'url' => '/',
						],
						'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
				]) ?>
				<?= $content ?>
		</div>
</div>

<!-- Modal -->
<div id="auth-form" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Авторизация</h4>
			</div>

			<ul class="nav nav-tabs nav-justified">
				<li class="active">
					<a data-toggle="tab" href="#login-form">Авторизация</a> 
				</li>
				<li>
					<a data-toggle="tab" href="#signup-form">Регистрация</a>
				</li>
			</ul>
			<div class="tab-content">
				<div id="login-form" class="tab-pane fade in active">
					<div class="modal-dialog">
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
					</div>
				</div>
				<div id="signup-form" class="tab-pane fade">
					<div class="modal-dialog">
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
					</div>
				</div>
			</div>
			<div class="modal-footer" >
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>

<footer class="footer">
		<div class="container">
				<p class="pull-left">&copy; Diftong <?= date('Y') ?></p>
		</div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
