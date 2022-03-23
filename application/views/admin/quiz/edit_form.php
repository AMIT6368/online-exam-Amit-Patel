<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row">

	<div class="col-12 col-md-12 col-lg-12">
    	<div class="card">
    		<?php
    			$data['tab_quiz_id'] = $quiz_id;
    		 	$this->load->view('admin/quiz/tab_list',$data);
    		?>
    	</div>
    	<hr>	

    	  <div class="col-md-12"><a href="<?php echo base_url('admin/quiz/translate-quiz/').$quiz_id ?>" class="btn btn-warning float-right"><?php echo lang('translate_quiz_btn'); ?></a></div>
    	  <div class="clearfix"></div>
    	 <hr>	

    	<div class="col-12">	
			<?php echo form_open_multipart('', array('role'=>'form','novalidate'=>'novalidate')); ?>
				<div class="row mt-3">

		          <div class="col-6">
		            <div class="form-group <?php echo form_error('category_id') ? ' has-error' : ''; ?>">
		              <?php echo  form_label(lang('quiz_category_name'), 'category_id'); ?>

		              <span class="required">*</span>
		              <?php 
		                $populateData = $this->input->post('category_id') ? $this->input->post('category_id') : (isset($quiz_data['category_id']) ? $quiz_data['category_id'] :  '' );                     
		                echo form_dropdown('category_id', $category_data, $populateData, 'id="category_id" class="form-control select_dropdown"'); 
		              ?> 
		              <span class="small form-error"> <?php echo strip_tags(form_error('category_id')); ?> </span>  
		            </div>
		          </div>

		          <div class="col-6">
		            <div class="form-group <?php echo form_error('title') ? ' has-error' : ''; ?>">
		              <?php echo  form_label(lang('admin_title'), 'title'); ?> 
		              <span class="required">*</span>
		              <?php 
		                $populateData = $this->input->post('title') ? $this->input->post('title') : (isset($quiz_data['title']) ? $quiz_data['title'] :  '' );
		              ?>
		              <input type="text" name="title" id="title" class="form-control" value="<?php echo xss_clean($populateData);?>">
		              <span class="small form-error"> <?php echo strip_tags(form_error('title')); ?> </span>
		            </div>
		          </div>

		          <div class="clearfix"></div>

		          <div class="col-6">
		            <div class="form-group <?php echo form_error('number_questions') ? ' has-error' : ''; ?>">
		              <?php echo  form_label(lang('admin_quiz_number_of_questions'), 'number_questions'); ?>
		              <span class="required">*</span>
		              <?php 
		                $populateData = $this->input->post('number_questions') ? $this->input->post('number_questions') : (isset($quiz_data['number_questions']) ? $quiz_data['number_questions'] :  '' );
		              ?>
		              <input type="number" name="number_questions" id="number_questions" class="form-control" value="<?php echo xss_clean($populateData);?>">
		              <span class="small form-error"> <?php echo strip_tags(form_error('number_questions')); ?> </span>
		            </div>
		          </div>
		          

		           <div class="col-6">
		              <div class="form-group <?php echo form_error('price') ? ' has-error' : ''; ?>">
		                 <?php echo  form_label(lang('quiz_price'), 'price'); ?>
		                 <span class="required">*</span>
		                 <?php 
		                 $populateData = $this->input->post('price') ? $this->input->post('price') : (isset($quiz_data['price']) ? $quiz_data['price'] :  '' );
		                 ?>
		                 <input type="number" name="price" id="price" class="form-control" value="<?php echo $populateData;?>">
		                 <span class="small form-error"> <?php echo strip_tags(form_error('price')); ?> </span>
		              </div>
		           </div>
		           <div class="clearfix"></div>

		          <div class="col-6">
		            <div class="form-group <?php echo form_error('duration_min') ? ' has-error' : ''; ?>">
		              <?php echo  form_label(lang('quiz_duration_in_minute'), 'duration_min'); ?>
		              <span class="required">*</span>
		              <?php 
		                $populateData = $this->input->post('duration_min') ? $this->input->post('duration_min') : (isset($quiz_data['duration_min']) ? $quiz_data['duration_min'] :  '' );
		              ?>
		              <input type="text" name="duration_min" id="duration_min" class="form-control" value="<?php echo xss_clean($populateData);?>">
		              <span class="small form-error"> <?php echo strip_tags(form_error('duration_min')); ?> </span>
		            </div>
		          </div>


		          <div class="col-6">
		            <div class="form-group <?php echo form_error('user_id') ? ' has-error' : ''; ?>">
		              <?php echo  form_label('Asign Quiz To User', 'user_id'); ?>

		              <span class="required">*</span>

		              <?php 
		                $populateData = $this->input->post('user_id') ? $this->input->post('user_id') : (isset($quiz_data['user_id']) ? $quiz_data['user_id'] :  '' ); 

		              echo form_dropdown('user_id', $all_user_data, $populateData, 'id="user_id" class="form-control select_dropdown"'); 
		              ?> 
		              <span class="small form-error"> <?php echo strip_tags(form_error('user_id')); ?> </span>  

		            </div>
		          </div>
		          <div class="clearfix"></div>

		          <?php 
		            $populateData = $this->input->post('leader_board') == 1 ? 'checked' : (isset($quiz_data['leader_board']) && $quiz_data['leader_board'] == 1 ? 'checked' :  '' );
		          ?>

		          <div class="col-3">
		            <div class="form-group togle_button">
		              <?php echo  form_label(lang('display_on_leaderboard'), 'leader_board'); ?>
		              <label class="custom-switch form-control">
		                <input type="checkbox" name="leader_board" value="1" <?php echo xss_clean($populateData); ?> class="custom-switch-input leader_board"  data-size="sm">
		                <span class="custom-switch-indicator"></span>
		              </label>
		            </div>
		          </div>

		          <?php 
		            $populateData = $this->input->post('is_random') == 1 ? 'checked' : (isset($quiz_data['is_random']) && $quiz_data['is_random'] == 1 ? 'checked' :  '' );
		          ?>

		          <div class="col-3">
		            <div class="form-group togle_button">
		              <?php echo  form_label(lang('question_is_random'), 'is_random'); ?>
		              <label class="custom-switch form-control">
		                <input type="checkbox" name="is_random" value="1" <?php echo xss_clean($populateData); ?> class="custom-switch-input is_random"  data-size="sm">
		                <span class="custom-switch-indicator"></span>
		              </label>
		            </div>
		          </div>


		          <?php 
		            $populateData = $this->input->post('is_random_option') == 1 ? 'checked' : (isset($quiz_data['is_random_option']) && $quiz_data['is_random_option'] == 1 ? 'checked' :  '' );
		          ?>

		          <div class="col-3">
		            <div class="form-group togle_button">
		              <?php echo  form_label(lang('is_random_option'), 'is_random'); ?>
		              <label class="custom-switch form-control">
		                <input type="checkbox" name="is_random_option" value="1" <?php echo xss_clean($populateData); ?> class="custom-switch-input is_random_option"  data-size="sm">
		                <span class="custom-switch-indicator"></span>
		              </label>
		            </div>
		          </div>

		          <?php 
		            $populateData = $this->input->post('is_registered') == 1 ? 'checked' : (isset($quiz_data['is_registered']) && $quiz_data['is_registered'] == 1 ? 'checked' :  '' );
		            $d_none = $populateData == 'checked' ? ' ' : 'd-none';
		          ?>

		          <div class="col-3">
		            <div class="form-group togle_button">
		              <?php echo  form_label(lang('is_registered'), 'is_random'); ?>
		              <label class="custom-switch form-control">
		                <input type="checkbox" name="is_registered" value="1" <?php echo xss_clean($populateData); ?> class="custom-switch-input is_registered"  data-size="sm">
		                <span class="custom-switch-indicator"></span>
		              </label>
		            </div>
		          </div>
		          
		          <div class="clearfix"></div>
		          
		          <div class="col-3">
		            <div class="form-group togle_button attempt <?php echo  $d_none; ?>">
		              <?php echo  form_label(lang('attempt'), 'is_random'); ?>
		              <?php
		                $populateData = $this->input->post('quiz_attempt') ? $this->input->post('quiz_attempt') : (isset($quiz_data['attempt']) ? $quiz_data['attempt'] :  '' );
		              ?>
		              <input type="text" name="quiz_attempt" id="quiz_attempt" class="form-control attempt" value="<?php echo xss_clean($populateData); ?>">
		                
		            </div>
		          </div>          

		          <div class="clearfix"></div>

		          <div class="col-12">
		            <div class="form-group <?php echo form_error('description') ? ' has-error' : ''; ?>">
		              <?php echo  form_label(lang('description'), 'description'); ?>
		              <span class="required">*</span>
		              <?php
		                $populateData = $this->input->post('description') ? $this->input->post('description') : (isset($quiz_data['description']) ? $quiz_data['description'] :  '' );
		              ?>
		              <textarea name="description" id="p_desc" class="form-control editorr" rows="5" ><?php echo xss_clean($populateData);?></textarea>
		              <span class="small form-error"> <?php echo strip_tags(form_error('description')); ?> </span>
		            </div>
		          </div>

		          <div class="clearfix"></div>

		          <div class="col-12 mt-4">
		            <div class="form-group <?php echo form_error('featured_image[]') ? ' has-error' : ''; ?>">
		              <?php echo  form_label(lang('admin_upload_image'), 'featured_image');  ?>
		              <div class="dropzone clsbox form-control" id="imageupload">
		              </div>
		              <span class="small form-error"> <?php echo strip_tags(form_error('featured_image[]')); ?> </span>

		              <?php 
		                if(isset($quiz_data['featured_image']) && $quiz_data['featured_image'])
		                {
		                  $featured_image_array = json_decode($quiz_data['featured_image']); 
		              ?>
		                <div class="row product_uploded_image mt-3">
		                  <?php foreach ($featured_image_array as  $featured_image_name) { ?>
		                    <div class="col-1">
		                      <img class="img-thumbnail popup" src="<?php echo  base_url('assets/images/quiz')?>/<?php echo xss_clean($featured_image_name)?>">
		                      <a href="/javascript:void(0)" class="btn btn-link p-0 delete_featured_image" data-image_name = "<?php echo xss_clean($featured_image_name)?>" data-quiz_id="<?php echo xss_clean($quiz_data['id'])?>"><?php echo lang('delete'); ?></a>
		                    </div>
		                  <?php } ?>
		                </div>
		              <?php } ?>
		            </div>
		            <div class="featured_image_block">
		            </div>
		          </div>

		          <div class="clearfix"></div>
		          <div class="col-12">
		            <div class="form-group <?php echo form_error('quiz_instruction') ? ' has-error' : ''; ?>">
		              <?php echo  form_label(lang('instruction'), 'quiz_instruction'); ?>
		              <?php
		                $populateData = $this->input->post('quiz_instruction') ? $this->input->post('quiz_instruction') : (isset($quiz_data['quiz_instruction']) ? $quiz_data['quiz_instruction'] :  '' );
		              ?>
		              <textarea name="quiz_instruction" id="quiz_instruction" class="form-control editor" rows="5" ><?php echo xss_clean($populateData);?></textarea>
		              <span class="small form-error"> <?php echo strip_tags(form_error('quiz_instruction')); ?> </span>
		            </div>
		          </div>

		          <div class="clearfix"></div>
		          <hr />

		          <div class="col-12"> 
		            <h2 class="text-center"><?php echo lang('seo_heading');?></h2>
		          </div>

		          <div class="clearfix"></div>
		          <hr />

		          <div class="col-12">
		            <div class="form-group <?php echo form_error('meta_title') ? ' has-error' : ''; ?>">
		              <?php echo  form_label(lang('meta_title'), 'metatitle'); ?> 
		              <?php 
		                $populateData = $this->input->post('metatitle') ? $this->input->post('metatitle') : (isset($quiz_data['meta_title']) ? $quiz_data['meta_title'] :  '' );
		              ?>
		              <input type="text" name="metatitle" id="metatitle" class="form-control" value="<?php echo xss_clean($populateData);?>">
		              <span class="small form-error"> <?php echo strip_tags(form_error('metatitle')); ?> </span>
		            </div>
		          </div>

		          <div class="clearfix"></div>
		          <hr />
		          
		          <div class="col-12">
		            <div class="form-group <?php echo form_error('meta_kewords') ? ' has-error' : ''; ?>">
		              <?php echo  form_label(lang('meta_kewords'), 'metakeywords'); ?>
		              <?php
		                $populateData = $this->input->post('metakeywords') ? $this->input->post('metakeywords') : (isset($quiz_data['meta_keywords']) ? $quiz_data['meta_keywords'] :  '' );
		              ?>
		              <input type="text" name="metakeywords" id="metakeywords" class="form-control" value="<?php echo xss_clean($populateData);?>" data-role="tagsinput">
		            </div>
		          </div>    

		          <div class="col-12">
		            <div class="form-group <?php echo form_error('meta_description') ? ' has-error' : ''; ?>">
		              <?php echo  form_label(lang('meta_description'), 'metadescription'); ?>
		              <?php
		                $populateData = $this->input->post('metadescription') ? $this->input->post('metadescription') : (isset($quiz_data['meta_description']) ? $quiz_data['meta_description'] :  '' );
		              ?>
		              <textarea name="metadescription" id="metadescription" class="form-control " rows="5" ><?php echo xss_clean($populateData);?></textarea>
		              <span class="small form-error"> <?php echo strip_tags(form_error('metadescription')); ?> </span>
		            </div>
		          </div>

		          <div class="clearfix"></div>
          		  <hr />

		          <div class="col-12">
		            <?php $saveUpdate = isset($quiz_id) ? lang('core_button_update') : lang('core_button_save'); ?>
		            <input type="submit"  value="<?php echo ucfirst($saveUpdate);?>" class="btn btn-primary px-5">
		            <a href="<?php echo base_url('admin/quiz');?>" class="btn btn-dark px-5"><?php echo lang('core_button_cancel'); ?></a>
		          </div>
		          <div class="clearfix"></div>

		        </div>
			<?php echo form_close();?>
    	</div>
	</div>      	
</div>