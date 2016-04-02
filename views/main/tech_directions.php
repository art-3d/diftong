<?php
use app\components\SidebarWidget;

$this->title = 'Направления технических учебных заведений';
$this->params['breadcrumbs'][] = ['label' => 'Список направлений учебных заведений', 'url' => '/directions'];
$this->params['breadcrumbs'][] = ['label' => 'Технические учебные заведения'];
?>

<div class="row">
  <div class="col-md-8">
    <h3>Направления технических учебных заведений</h3>          
      <div id="first-block" class="tab-pane fade in active">
        <ul class="list-group">
        <?php foreach($tech_directions as $dir): ?>
          <li class="list-group-item">
            <span class="badge"><?= $dir['count']; ?></span>
            <a href="/directions/tech/<?=$dir['id'];?>">
              <?= $dir['title_ru']; ?>
            </a>
          </li>
        <?php endforeach; ?>
        </ul>
      </div>   
  </div>
  <?= SidebarWidget::widget() ?>
</div>
