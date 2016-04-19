<?php
use app\components\SidebarWidget;

$this->title = $tech['title_ru'];

$this->params['breadcrumbs'][] = ['label' => 'Технические учебные заведения', 'url' => '/tech'];
$this->params['breadcrumbs'][] = ['label' => $tech['city'], 'url' => '/tech?city='.$tech['city_id']];
$this->params['breadcrumbs'][] = ['label' => $tech['title_ru']];
?>

<div class="row">
	<div class="col-md-8">
		<h3 class="page-header">
			<?= $tech['title_ru'] ?>
			<small><?= $tech['city']?></small>
		</h3>
		<div class="well row">
			<h4 name="directions">Направления</h4>
		</div>
		<ul class="list-group directions">
			<?php foreach($directions as $direction): ?>
				<li class="list-group-item direction">
					<a href="?direct=<?= $direction['id'] ?>">
						<?= $direction['title_ru'] ?>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
	<?= SidebarWidget::widget() ?>
</div>