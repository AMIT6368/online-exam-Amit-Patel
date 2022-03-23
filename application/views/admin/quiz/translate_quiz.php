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
				<input type="hidden" name="quiz_id" value="<?php echo $quiz_id; ?>">
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
							                $populateData = isset($translated_data_array[$language->id]['title']) ? $translated_data_array[$language->id]['title'] : $quiz_data->title;
							              ?>
							              <input type="text" name="translate[<?php echo $language->id; ?>][title]" id="title" class="form-control" value="<?php echo xss_clean($populateData);?>">
							              <span class="small form-error"> <?php echo strip_tags(form_error('title')); ?> </span>
						            	</div>
						          	</div>

					          		<div class="clearfix"></div>

						          	<div class="col-12">
							            <div class="form-group <?php echo form_error('description') ? ' has-error' : ''; ?>">
							              <?php echo  form_label(lang('description'), 'description'); ?>
							              <span class="required">*</span>
							              <?php
							                $populateData = isset($translated_data_array[$language->id]['description']) ? $translated_data_array[$language->id]['description'] : $quiz_data->description;
							              ?>
							              <textarea name="translate[<?php echo $language->id; ?>][description]" id="p_desc" class="form-control editorr" rows="5" ><?php echo xss_clean($populateData);?></textarea>
							              <span class="small form-error"> <?php echo strip_tags(form_error('description')); ?> </span>
							            </div>
						          	</div>

					          		<div class="clearfix"></div>


							         <div class="col-12">
							            <div class="form-group <?php echo form_error('quiz_instruction') ? ' has-error' : ''; ?>">
							              <?php echo  form_label(lang('instruction'), 'quiz_instruction'); ?>
							              <?php

							               $populateData = isset($translated_data_array[$language->id]['quiz_instruction']) ? $translated_data_array[$language->id]['quiz_instruction'] : $quiz_data->quiz_instruction;
							               
							              ?>
							              <textarea name="translate[<?php echo $language->id; ?>][quiz_instruction]" id="quiz_instruction" class="form-control editor" rows="5" ><?php echo xss_clean($populateData);?></textarea>
							              <span class="small form-error"> <?php echo strip_tags(form_error('quiz_instruction')); ?> </span>
							            </div>
							         </div>
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
		            	<a href="<?php echo base_url('admin/quiz/update/'.$quiz_id);?>" class="btn btn-dark px-5"><?php echo lang('core_button_cancel'); ?></a>
		          	</div>
		          <div class="clearfix"></div>
		        </div>
		    <?php echo form_close();?>
		</div>
	</div>      	
</div>