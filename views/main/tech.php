<?php
use app\components\SidebarWidget;
use yii\widgets\LinkPager;
$this->title = 'Технические учебные заведения';

$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => '/tech'];
?>
<div class="row">
	<div class="col-md-8">
		<h3>Технические учебные заведения</h3>
		<ul class="list-group">	
		<?php foreach($techs as $tech): ?>
			<li class="list-group-item">
			    <span class="small pull-right"><a href="/tech?city=<?=$tech->city->id;?>"><?= $tech->city->title_ru ?></a></span>
			    <h4><a href="/tech/<?= $tech->id ?>"><?= $tech->title_ru ?></a></h4>
			</li>
		<?php endforeach; ?>
		</ul>
		<?= LinkPager::widget(['pagination' => $pagination]) ?>
	</div>
 	 <?= SidebarWidget::widget() ?>
</div>
