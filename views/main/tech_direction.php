<?php
use yii\widgets\LinkPager;
use app\components\SidebarWidget;


$this->title = $direction->title_ru;
$this->params['breadcrumbs'][] = ['label' => 'Список направлений учебных заведений', 'url' => '/directions'];
$this->params['breadcrumbs'][] = ['label' => 'Технические учебные заведения', 'url' => '/tech'];
$this->params['breadcrumbs'][] = ['label' => $direction->title_ru];
?>

<div class="row">
  <div class="col-md-8">
      <h3 class="page-header">
        <?= $direction->title_ru ?>
        <small>
         Технические учебные заведения        
        </small>
      </h3>
    <ul class="list-group"> 
    <?php foreach($techs as $tech): ?>
      <li class="list-group-item">
          <span class="small pull-right"><a href="/tech?city=<?=$tech['city_id'];?>"><?= $tech['city']?></a></span>
          <h4><a href="<?= $tech['title_en'] == '' ? '/tech/'.$tech['id'] : '/'.$tech['title_en'] ?>"><?= $tech['title_ru'] ?></a></h4>
      </li>
    <?php endforeach; ?>
    </ul>
    <?= LinkPager::widget(['pagination' => $pagination]) ?>
  </div>
  <?= SidebarWidget::widget() ?>
</div>
