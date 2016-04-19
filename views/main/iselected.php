<?php
use app\components\SidebarWidget;

$this->title = $inst['title_ru'];

$this->params['breadcrumbs'][] = ['label' => 'Высшие учебные заведения', 'url' => '/inst'];
$this->params['breadcrumbs'][] = ['label' => $inst['city'], 'url' => '/inst?city='.$inst['city_id']];
$this->params['breadcrumbs'][] = ['label' => $inst['title_ru']];
?>

<div class="row">
	<div class="col-md-8">
		<h3 class="page-header">
			<?= $inst['title_ru'] ?>
			<small><?= $inst['city']?></small>
		</h3>
		<div class="well row">
			<h4 name="directions">Направления</h4>
		</div>
		<ul class="list-group directions">
			<?php foreach($directions as $direction): ?>
				<li class="list-group-item direction" >
					<a href="?direct=<?= $direction['id'] ?>" >
						<?= $direction['title_ru'] ?>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
	<?= SidebarWidget::widget() ?>
</div>