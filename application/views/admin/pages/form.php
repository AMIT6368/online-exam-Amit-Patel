<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $update = isset($article_id) && $article_id ? '_update' : '' ?> 
<div class="row page">
  <div class="col-12 col-md-12 col-lg-12">
    <div class="card">
      <div class="card-body"> 
        <?php echo form_open_multipart('', array('role'=>'form','novalidate'=>'novalidate')); ?> 
        <div class="row">

          <div class="col-5">
            <div class="form-group <?php echo form_error('title') ? ' has-error' : ''; ?>">
              <?php echo  form_label(lang('admin_title'), 'title'); ?> 
              <span class="required">*</span>
              <?php 
                $populateData = $this->input->post('title') ? $this->input->post('title') : (isset($page_data->title) ? $page_data->title :  '' );
              ?>

              <input type="text" name="title" id="title" class="form-control" value="<?php echo xss_clean($populateData);?>">
              <span class="small form-error"> <?php echo strip_tags(form_error('title')); ?> </span>
            </div>
          </div>


          <div class="col-5">
            <div class="form-group <?php echo form_error('featured_image') ? ' has-error' : ''; ?>">
              <?php echo  form_label(lang('admin_upload_image'), 'featured_image'); ?>

              <span class="required">*</span>

              <?php 
                $populateData = isset($page_data->featured_image) && $page_data->featured_image ? $page_data->featured_image :  ''; 
              ?> 

              <input type="file" name="featured_image" id="featured_image" class="form-control" value="<?php echo xss_clean($populateData);?>">
              <span class="small form-error"> <?php echo strip_tags(form_error('featured_image')); ?> </span> 
              <?php 
                if($populateData)
                {
              ?> 
                  <div class="">
                    <img class="image_preview popup" src="<?php echo base_url('assets/images/page/').$populateData; ?>">
                  </div>
              <?php
                }
              ?>

            </div>
          </div>

          <div class="col-2">
            <div class="form-group">
              <div class="control-label"><label>Display On Menu</label></div>
              <label class="custom-switch  form-control">
                <?php $checked = $this->input->post('on_menu') ? 'checked' : (isset($page_data->on_menu) && $page_data->on_menu == 1 ? 'checked' : '' );?>
                <input type="checkbox"  name="on_menu" value="0" id="page_menu_togle" class="custom-switch-input" <?php echo xss_clean($checked);?>>
                <span class="custom-switch-indicator"></span>
                <span class="custom-switch-description"></span>
              </label>
            </div>
          </div>

          <div class="clearfix"></div>

          <div class="col-12">
            <div class="form-group <?php echo form_error('content') ? ' has-error' : ''; ?>">
              <?php echo  form_label(lang('admin_content'), 'content'); ?>
              <span class="required">*</span>
              <?php
                $populateData = $this->input->post('content') ? $this->input->post('content') : (isset($page_data->content) ? $page_data->content :  '' );
              ?>
              <textarea name="content" id="p_desc" class="form-control editor" rows="5" ><?php echo xss_clean($populateData);?></textarea>
              <span class="small form-error"> <?php echo strip_tags(form_error('content')); ?> </span>
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
                $populateData = $this->input->post('metatitle') ? $this->input->post('metatitle') : (isset($page_data->meta_title) ? $page_data->meta_title :  '' );
              ?>
              <input type="text" name="metatitle" id="metatitle" class="form-control" value="<?php echo xss_clean($populateData);?>">
              <span class="small form-error"> <?php echo strip_tags(form_error('metatitle')); ?> </span>
            </div>
          </div>
          
          <div class="col-12">
            <div class="form-group <?php echo form_error('meta_kewords') ? ' has-error' : ''; ?>">
              <?php echo  form_label(lang('meta_kewords'), 'metakeywords'); ?>
              <?php
                $populateData = $this->input->post('metakeywords') ? $this->input->post('metakeywords') : (isset($page_data->meta_keywords) ? $page_data->meta_keywords :  '' );
              ?>
              <input type="text" name="metakeywords" id="metakeywords" class="form-control" value="<?php echo xss_clean($populateData);?>" data-role="tagsinput">
            </div>
          </div>    

          <div class="col-12">
            <div class="form-group <?php echo form_error('meta_description') ? ' has-error' : ''; ?>">
              <?php echo  form_label(lang('meta_description'), 'metadescription'); ?>
              <?php
                $populateData = $this->input->post('metadescription') ? $this->input->post('metadescription') : (isset($page_data->meta_description) ? $page_data->meta_description :  '' );
              ?>
              <textarea name="metadescription" id="metadescription" class="form-control " rows="5" ><?php echo xss_clean($populateData);?></textarea>
              <span class="small form-error"> <?php echo strip_tags(form_error('metadescription')); ?> </span>
            </div>
          </div>

          <div class="clearfix"></div>
           <hr />

          <div class="col-12">
            <?php $saveUpdate = isset($page_id) ? lang('core_button_update') : lang('core_button_save'); ?>
            <input type="submit"  value="<?php echo ucfirst($saveUpdate);?>" class="btn btn-primary px-5">
            <a href="<?php echo base_url('admin/pages');?>" class="btn btn-dark px-5"><?php echo lang('core_button_cancel'); ?></a>
          </div>
          <div class="clearfix"></div>
        </div>
        <?php echo form_close();?>
      </div>
    </div>
  </div>
</div>
