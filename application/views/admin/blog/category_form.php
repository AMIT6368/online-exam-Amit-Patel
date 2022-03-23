<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="row">
   <div class="col-12 col-md-12 col-lg-12">
      <div class="card">
         <div class="card-body">
            <?php echo form_open_multipart('', array('role'=>'form')); ?>
            <div class="row">
               <div class="col-12">
                  <div class="form-group <?php echo form_error('title') ? ' has-error' : ''; ?>">
                     <?php echo form_label(lang('admin_title'), 'title'); ?>  
                     <span class="required">*</span>
                     <?php $populateData = (!empty($this->input->post('title')) ? $this->input->post('title') : (!empty($editData['title']) && isset($editData['title']) ? $editData['title'] : '' )); ?>
                     <input type="text" name="title" id="title" class="form-control" value="<?php echo xss_clean($populateData);?>">
                     <span class="small form-error"> <?php echo strip_tags(form_error('title')); ?> </span>  
                  </div>
               </div>
               <div class="col-6">
                  <div class="form-group">
                     <?php echo form_label(lang('admin_parent_category'), 'parentcategory'); ?>
                     <?php $populateData = (!empty($editData['parent_category']) && isset($editData['parent_category']) ? $editData['parent_category'] : (!empty($this->input->post('parentcat')) ? $this->input->post('parentcat') : '' )); ?>
                     <select class="select_dropdown form-control" name="parentcat">
                        <option value=""><?php echo lang('admin_select_one'); ?></option>
                        <?php
                        foreach($cat_title as $key=>$parentCategory)
                        {
                           $selected = ($parentCategory['id'] == $populateData) ? "selected" : ''; 
                           ?>
                           <option <?php echo xss_clean($selected);?> value="<?php echo xss_clean($parentCategory['id']);?>"><?php echo xss_clean($parentCategory['title']);?>   </option>
                        <?php } ?>
                     </select>
                  </div>
               </div>
               <?php
                $checked = $this->input->post('display_on_home') ? 'checked' : (isset($editData['display_on_home']) && $editData['display_on_home'] == 1 ? 'checked' : '');
               
               ?>
               <div class="col-6">
                  <div class="form-group">
                     <div class="control-label"><?php echo lang('admin_category_display_on_home_or_menu'); ?></div>
                     <label class="custom-switch mt-2 form-control">
                        <input type="checkbox" <?php echo xss_clean($checked); ?> name="display_on_home" value="1" class="custom-switch-input">
                        <span class="custom-switch-indicator"></span>
                        <span class="custom-switch-description"><?php echo lang('admin_category_display_on_home_or_menu_msg'); ?></span>
                     </label>
                  </div>
               </div>
            </div> 
            <div class="form-group">
               <?php echo form_label(lang('description'), 'categorydesc'); ?>
               <?php $populateData = (!empty($this->input->post('description')) ? $this->input->post('description') : (!empty($editData['description']) && isset($editData['description']) ? $editData['description'] : '' )); ?>
               <textarea name="description" id="categorydesc" rows="5" class="form-control"><?php echo xss_clean($populateData);?></textarea>
            </div>
            <div class="form-group">
               <?php echo form_label(lang('admin_upload_image'), 'categoryimage'); ?>
               <input type="file" name="image" id="categoryimage" class="form-control">
               <?php 
                if(!empty($editData['id']) && isset($editData['id']))
                {
                   $populateData = (!empty($editData['image']) && isset($editData['image']) ? base_url('assets\images\blog_image\\'.$editData['image']) : (empty($editData['image']) ? base_url('assets/images/blog_image/default_category.jpg') : ''));
               ?>
                  <img src="<?php echo xss_clean($populateData);?>" class="img_thumb mt-2 popup">
               <?php } ?>
            </div>
            <?php 
            $populateData = isset($editData['id']) && $editData['id'] ? lang('core_button_update') : lang('core_button_save'); ?>
            
            <input type="submit" name="<?php echo xss_clean($populateData);?>" value="<?php echo ucfirst($populateData);?>" class="btn btn-primary btn-lg">
            <a href="<?php echo base_url("admin/blog");?>" class="btn btn-dark btn-lg"><?php echo lang('core_button_cancel'); ?></a>
            <?php echo form_close(); ?>
         </div>
      </div>
   </div>
</div>