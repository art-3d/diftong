<?php
use app\components\SidebarWidget;

$this->title = 'Направления высших учебных заведений';
$this->params['breadcrumbs'][] = ['label' => 'Список направлений учебных заведений', 'url' => '/directions'];
$this->params['breadcrumbs'][] = ['label' => 'Высшие учебные заведения'];
?>

<div class="row">
  <div class="col-md-8">
    <h3>Направления высших учебных заведений</h3>          
      <div id="first-block" class="tab-pane fade in active">
        <ul class="list-group">
        <?php foreach($inst_directions as $dir): ?>
          <li class="list-group-item">
            <span class="badge"><?= $dir['count']; ?></span>
            <a href="/directions/inst/<?=$dir['id'];?>">
              <?= $dir['title_ru']; ?>
            </a>
          </li>
        <?php endforeach; ?>
        </ul>
      </div>   
  </div>
  <?= SidebarWidget::widget() ?>
</div>
