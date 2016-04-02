<?php
use app\components\SidebarWidget;

$this->title = $region->title_en != 'Crimea' ? $region->title_ru . ' область' : $region->title_ru;
$this->params['breadcrumbs'][] = ['label' => $region->title_en != 'Crimea' ? $region->title_ru . ' область' : $region->title_ru];
?>

<div class="row">
  <div class="col-md-8">
    <!-- Buttons -->
    <ul class="nav nav-tabs nav-justified">
      <li class="active"><a data-toggle="tab" href="#first-block">Высшие учебные заведения</a></li>
      <li><a data-toggle="tab" href="#second-block">Техникумы, колледжы, училища</a></li>
    </ul>
    <!-- show/hide blocks -->
    <div class="tab-content">
      <div id="first-block" class="tab-pane fade in active">
  		 <ul class="list-group">	
  		<?php foreach($insts as $inst): ?>
  			<li class="list-group-item">
  			    <span class="small pull-right"><a href="/inst?city=<?= $inst['city_id']?>"><?= $inst['city'] ?></a></span>
  			    <h3><a href="<?= $inst['title_en'] == '' ? '/inst/'.$inst['id'] : '/'.$inst['title_en'] ?>"><?= $inst['title_ru'] ?></a></h3>
  			</li>
  		<?php endforeach; ?>
  		</ul> 
      </div>
      <div id="second-block" class="tab-pane fade">
        <ul class="list-group">
        <?php foreach($techs as $tech): ?>
          <li class="list-group-item">
              <span class="small pull-right"><a href="/tech?city=<?= $tech['city_id']?>"><?= $tech['city'] ?></a></span>
              <h3><a href="/tech/<?= $tech['id'] ?>"><?= $tech['title_ru'] ?></a></h3>
          </li>
        <?php endforeach; ?>
        </ul>
      </div>
    </div>
  </div>
  <?= SidebarWidget::widget() ?>
</div>