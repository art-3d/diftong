<?php
use app\components\SidebarWidget;

$this->title = 'Список направлений учебных заведений';
$this->params['breadcrumbs'][] = ['label' => 'Список направлений учебных заведений'];
?>

<div class="row">
  <div class="col-md-8">
    <h3>Поиск учебного заведения по <i>направлениям</i></h3>          
        <!-- Buttons -->
    <ul class="nav nav-tabs nav-justified">
      <li class="active"><a data-toggle="tab" href="#first-block">Высшие учебные заведения</a></li>
      <li><a data-toggle="tab" href="#second-block">Техникумы, колледжы, училища</a></li>
    </ul>
    <!-- show/hide blocks -->
    <div class="tab-content">
    <!-- first block -->
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
      <!-- second block -->
      <div id="second-block" class="tab-pane fade">
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
  </div>
  <?= SidebarWidget::widget() ?>
</div>
