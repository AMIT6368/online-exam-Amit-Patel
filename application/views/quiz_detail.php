<div class="container">
	<div class="row">
    	<div class="col-md-12">
      		<div class="card mt-5">
      			<div class="card-body">
      				<div class="text-wrap p-lg-6"> 
			            <h1 class="text-primary text-center"><?php echo $quiz_data->title; ?></h1>
			            <hr>
			        </div>
			        <div class="row">
				        <div class="col-xs-6 col-sm-6 col-md-4 col-lg-3"> 
				        	<div class="detail-left">
				        		<?php  
				        			$quiz_title = strlen($quiz_data->title) > 40 ? substr($quiz_data->title,0,40)."..." : $quiz_data->title;
				        		?>
				        		<div class="detail_quiz_title">Quiz Title: <?php echo xss_clean($quiz_title); ?></div>
				        		<div class="detail_quiz_title">No. Of Questions: <?php echo xss_clean($quiz_data->number_questions); ?> </div>
				        		<div class="detail_quiz_title">Duration: <?php echo xss_clean($quiz_data->duration_min); ?> </div>
				        	</div>
				        </div>
				        <div class="col-xs-6 col-sm-6 col-md-4 col-lg-9"> 
				        	<p class="text-justify"><?php echo xss_clean($quiz_data->description);?></p>
				        </div>
				    </div>
      			</div>
    		</div>
    	</div>
    </div>
</div>