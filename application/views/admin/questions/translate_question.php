<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row">

	<div class="col-12 col-md-12 col-lg-12">
	<hr>
	<div class="clearfix"></div>

		<div class="col-12">
			<ul class="nav nav-tabs" id="quiz_translate_Tab" role="tablist">
			<?php
			$active = ' active';
			foreach ($languages as $language) { ?>
					<li class="nav-item">
			    		<a class="nav-link <?php echo $active; ?>" id="tab-<?php echo $language->id; ?>" data-toggle="tab" href="#lang-<?php echo $language->id; ?>" role="tab" aria-controls="<?php echo $language->lang; ?>" aria-selected="true"><?php echo $language->lang; ?></a>
			  		</li>

				<?php
				$active = '';
			} ?>
			</ul>
			<?php echo form_open_multipart('', array('role'=>'form','novalidate'=>'novalidate')); ?>
				<input type="hidden" name="question_id" value="<?php echo $question_id; ?>">
				<div class="tab-content" id="quiz_translate_Content">

					<?php
					$active = ' active';
					foreach ($languages as $language) { ?>

						<div class="tab-pane fade show <?php echo $active; ?>" id="lang-<?php echo $language->id; ?>" role="tabpanel" aria-labelledby="<?php echo $language->lang; ?>">
						  	<div class="row">
						  		
						          	<div class="col-12">
							            <div class="form-group <?php echo form_error('title') ? ' has-error' : ''; ?>">
							              <?php echo  form_label(lang('admin_title'), 'title'); ?> 
							              <span class="required">*</span>
							              <?php 
							                $populateData = isset($translated_data_array[$language->id]['title']) ? $translated_data_array[$language->id]['title'] : $question_data->title;
							              ?>
							              <input type="text" name="translate[<?php echo $language->id; ?>][title]" id="title" class="form-control" value="<?php echo xss_clean($populateData);?>">
							              <span class="small form-error"> <?php echo strip_tags(form_error('title')); ?> </span>
						            	</div>
						          	</div>

					          		<div class="clearfix"></div>

					          		<?php

					          		$choices_array = json_decode($question_data->choices);
            						$correct_choice_array = json_decode($question_data->correct_choice);
            						foreach ($choices_array as $key => $choices) 
            						{ 
            							$choices_no = $key + 1;

            							?>
            							
						          	<div class="col-12">
							            <div class="form-group">
							              <?php echo  form_label(lang('question_choices').' ('.$choices_no.')' , 'choices'); ?> 
							              <?php 
							                $populateData = isset($translated_data_array[$language->id]['choices'][$key]) ? $translated_data_array[$language->id]['choices'][$key] : '';
							              ?>
							              <input type="text" name="translate[<?php echo $language->id; ?>][choices][<?php echo $key; ?>]" id="title" class="form-control" value="<?php echo xss_clean($populateData);?>">
							              
						            	</div>
						          	</div>
						          	<div class="clearfix"></div>

            						<?php } ?>
					          		

            						<?php
					          		foreach ($correct_choice_array as $key => $choices) 
            						{ 
            							$choices_no = $key + 1;

            							?>
            							
						          	<div class="col-12">
							            <div class="form-group">
							              <?php echo form_label(lang('correct_choice').'Correct Choice ('.$choices_no.')' , 'correct_choice'); ?> 
							              <?php 
							                $populateData = isset($translated_data_array[$language->id]['correct_choice'][$key]) ? $translated_data_array[$language->id]['correct_choice'][$key] : '';
							              ?>
							              <input type="text" name="translate[<?php echo $language->id; ?>][correct_choice][<?php echo $key; ?>]" id="title" class="form-control" value="<?php echo xss_clean($populateData);?>">
							              
						            	</div>
						          	</div>
						          	<div class="clearfix"></div>

            						<?php }
					          		?>


					  		</div>
						</div>

						<?php
						$active = '';
					} ?>

				</div>

				<div class="row mt-3">
					<div class="clearfix"></div>
		          	<hr/>

		          	<div class="col-12">
		            	<?php $saveUpdate = isset($quiz_id) ? lang('core_button_save') : lang('core_button_save'); ?>
		            	<input type="submit"  value="<?php echo ucfirst($saveUpdate);?>" class="btn btn-primary px-5">
		            	<a href="<?php echo base_url('admin/questions/update/'.$question_data->quiz_id.'/'.$question_id);?>" class="btn btn-dark px-5"><?php echo lang('core_button_cancel'); ?></a>
		          	</div>
		          <div class="clearfix"></div>
		        </div>
		    <?php echo form_close();?>
		</div>
	</div>      	
</div>