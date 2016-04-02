<?php
/* @var $this yii\web\View */
use app\components\SidebarWidget;

$this->title = 'GetUp';
?>

<div class="row">
	<div class="col-md-8">
	    <h1 class="page-header">
	        Page Heading
	        <small>Welcome</small>
	    </h1>
	    <form>
	      <div class="form-group">
	        <button type="button" class="btn btn-lg btn-primary btn-block select-inst">Выбор учебного заведения</button>
	      </div>
	      <div class="hidden search-block">
	        <div class="form-group">
	         <label for="inst">Поиск по названию:</label>
				<!-- typeahead form -->
				<form name="inst-form" action="/search">
				    <div class="typeahead-container">
				        <div class="typeahead-field"> 
				            <span class="typeahead-query">
				                <input id="inst-query" name="inst" type="search" placeholder="Название учебного заведения" autocomplete="off">
				            </span>
				            <span class="typeahead-button">
				                <button type="submit">
				                    <i class="typeahead-search-icon"></i>
				                </button>
				            </span> 
				        </div>
				    </div>
				</form>		    
	        </div>
	        <div class="form-group btn-group">
	         <button type="button" class="btn btn-primary search-region-btn">Поиск по областям</button>
	         <button type="button" class="btn btn-primary search-direction-btn">Поиск по направлениям</button>
	        </div>
        	<div class="search-region-list hidden">      
        		<h3>Поиск учебного заведения по <i>областям</i></h3>
		        <ul class="list-group">
		          <?php foreach($regions as $region): ?>
					  	<li class="list-group-item">
				  			<span class="badge"><?= $region['count']; ?></span>
					  		<a href="/<?= strtolower( $region['title_en'] ); ?>">
				  			<?= $region['title_ru']; ?>
				  			</a>
				  		</li>
		          <?php endforeach; ?> 
		        </ul>
		    </div>
			<div class="search-direction-list hidden">
	        	<h3>Поиск учебного заведения по <i>направлениям</i></h3>
		            <!-- Buttons -->
					  <ul class="nav nav-tabs nav-justified">
					    <li class="active"><a data-toggle="tab" href="#first-block">Высшие учебные заведения</a></li>
					    <li><a data-toggle="tab" href="#second-block">Технические учебные заведения</a></li>
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
	       </div>
	     </form>  
	</div>
  <?= SidebarWidget::widget() ?>	
</div>