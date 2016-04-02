<?php
use yii\widgets\LinkPager;
use app\components\SidebarWidget;

$this->title = 'Высшие учебные заведения';

$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => '/inst'];
?>
<div class="row">
	<div class="col-md-8">
		<h3>Высшие учебные заведения</h3>
		<ul class="list-group">	
		<?php foreach($insts as $inst): ?>
			<li class="list-group-item">
			    <span class="small pull-right"><a href="/inst?city=<?=$inst->city->id;?>"><?= $inst->city->title_ru ?></a></span>
			    <h4><a href="<?= $inst->title_en == '' ? '/inst/'.$inst->id : '/'.$inst->title_en ?>"><?= $inst->title_ru ?></a></h4>
			</li>
		<?php endforeach; ?>
		</ul>
		<?= LinkPager::widget(['pagination' => $pagination]) ?>
	</div>
  <?= SidebarWidget::widget() ?>
</div>
