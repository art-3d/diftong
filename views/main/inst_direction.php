<?php
use yii\widgets\LinkPager;
use app\components\SidebarWidget;


$this->title = $direction->title_ru;
$this->params['breadcrumbs'][] = ['label' => 'Список направлений учебных заведений', 'url' => '/directions'];
$this->params['breadcrumbs'][] = ['label' => 'Высшие учебные заведения', 'url' => '/inst'];
$this->params['breadcrumbs'][] = ['label' => $direction->title_ru];
?>

<div class="row">
  <div class="col-md-8">
      <h3 class="page-header">
        <?= $direction->title_ru ?>
        <small>
         Высшие учебные заведения         
        </small>
      </h3>
    <ul class="list-group"> 
    <?php foreach($insts as $inst): ?>
      <li class="list-group-item">
          <span class="small pull-right"><a href="/inst?city=<?=$inst['city_id'];?>"><?= $inst['city']?></a></span>
          <h4><a href="<?= $inst['title_en'] == '' ? '/inst/'.$inst['id'] : '/'.$inst['title_en'] ?>"><?= $inst['title_ru'] ?></a></h4>
      </li>
    <?php endforeach; ?>
    </ul>
    <?= LinkPager::widget(['pagination' => $pagination]) ?>
  </div>
  <?= SidebarWidget::widget() ?>
</div>
