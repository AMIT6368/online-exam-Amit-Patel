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
                     <?php $populateData = (!empty($this->input->post('title')) ? $this->input->post('title') : (!empty($editData['post_title']) && isset($editData['post_title']) ? $editData['post_title'] : '' )); ?>
                     <input type="text" name="title" id="title" class="form-control" value="<?php echo xss_clean($populateData);?>">
                     <span class="small form-error"> <?php echo strip_tags(form_error('title')); ?> </span>  
                  </div>
               </div>
               <div class="col-4">
                  <div class="form-group">
                     <?php echo form_label(lang('admin_status'), 'status');?>
                     <?php $populateData = (!empty($editData['post_status']) && isset($editData['post_status']) ? $editData['post_status'] : (!empty($this->input->post('status')) ? $this->input->post('status') : '' )); 
                        
                     ?>
                     <select class="form-control" name="status">
                        <option value=""><?php echo lang('admin_select_one'); ?></option>
                        <?php $published = ($populateData == '1') ? "selected" : ''; ?>
                        <option <?php echo $published;?> value="1"><?php echo lang('admin_published'); ?></option>
                        <?php $unpublished = ($populateData == '0') ? "selected" : ''; ?>
                        <option <?php echo $unpublished;?> value="0"><?php echo lang('admin_unpublished'); ?></option>
                     </select>
                  </div>
               </div>
               
               <div class="col-4">
                  <div class="form-group">
                     <?php echo form_label(lang('admin_author'), 'author'); ?>
                     <?php $populateData = (!empty($editData['post_author_id']) && isset($editData['post_author_id']) ? $editData['post_author_id'] : (!empty($this->input->post('author')) ? $this->input->post('author') : '' )); ?>
                     <select class="form-control" name="author">
                        <option value=""><?php echo lang('admin_select_one'); ?></option>
                        <?php
                        foreach($author as $author_key=>$author_value)
                        {
                           $selected = ($author_value->id == $populateData) ? "selected" : ''; 
                           ?>
                           <option <?php echo xss_clean($selected);?> value="<?php echo xss_clean($author_value->id);?>"><?php echo xss_clean($author_value->first_name.' '.$author_value->last_name);?>   </option>
                        <?php } ?>
                     </select>
                  </div>
               </div>
               <div class="col-4">
                  <div class="form-group">
                     <?php echo form_label(lang('admin_blog_category_list'), 'blogcategory'); ?>
                     <?php $populateData = (!empty($editData['blog_category_id']) && isset($editData['blog_category_id']) ? $editData['blog_category_id'] : (!empty($this->input->post('blogcategory')) ? $this->input->post('blogcategory') : '' )); ?>
                     <select class="form-control" name="blogcategory">
                        <option value=""><?php echo lang('admin_select_one'); ?></option>
                        <?php
                        foreach($blog_category as $blog_key=>$blog_value)
                        {
                           $selected = ($blog_value->id == $populateData) ? "selected" : ''; 
                           ?>
                           <option <?php echo xss_clean($selected);?> value="<?php echo xss_clean($blog_value->id);?>"><?php echo xss_clean($blog_value->title);?>   </option>
                        <?php } ?>
                     </select>
                  </div>
               </div>
            </div> 
            <div class="form-group">
               <?php echo form_label(lang('description'), 'categorydesc'); ?>
               <?php $populateData = (!empty($this->input->post('description')) ? $this->input->post('description') : (!empty($editData['post_description']) && isset($editData['post_description']) ? $editData['post_description'] : '' )); ?>
               <textarea name="description" id="categorydesc" rows="5" class="form-control editor"><?php echo xss_clean($populateData);?></textarea>
            </div>
            <div class="form-group">
               <?php echo form_label(lang('admin_upload_image'), 'categoryimage'); ?>
               <input type="file" name="image" id="categoryimage" class="form-control">
               <?php 
                 if(!empty($editData['id']) && isset($editData['id']))
                 {
                    $populateData = (!empty($editData['post_image']) && isset($editData['post_image']) ? base_url('assets\images\blog_image\post_image\\'.$editData['post_image']) : (empty($editData['post_image']) ? base_url('assets/images/blog_image/default_category.jpg') : ''));
               ?>
                  <img src="<?php echo xss_clean($populateData);?>" class="img_thumb mt-2 popup">
               <?php } ?>
            </div>

            <div class="col-12"> 
              <h2 class="text-center"><?php echo lang('seo_heading');?></h2>
            </div>

            <div class="clearfix"></div>
            <hr />

            <div class="col-12">
              <div class="form-group <?php echo form_error('meta_title') ? ' has-error' : ''; ?>">
                <?php echo  form_label(lang('meta_title'), 'metatitle'); ?> 
                <?php 
                  $populateData = $this->input->post('metatitle') ? $this->input->post('metatitle') : (isset($editData['meta_title']) ? $editData['meta_title'] :  '' );
                ?>
                <input type="text" name="metatitle" id="metatitle" class="form-control" value="<?php echo xss_clean($populateData);?>">
                <span class="small form-error"> <?php echo strip_tags(form_error('metatitle')); ?> </span>
              </div>
            </div>
            
            <div class="col-12">
              <div class="form-group <?php echo form_error('meta_kewords') ? ' has-error' : ''; ?>">
                <?php echo  form_label(lang('meta_kewords'), 'metakeywords'); ?>
                <?php
                  $populateData = $this->input->post('metakeywords') ? $this->input->post('metakeywords') : (isset($editData['meta_keywords']) ? $editData['meta_keywords'] :  '' );
                ?>
                <input type="text" name="metakeywords" id="metakeywords" class="form-control" value="<?php echo xss_clean($populateData);?>" data-role="tagsinput">
              </div>
            </div>    

            <div class="col-12">
              <div class="form-group <?php echo form_error('meta_description') ? ' has-error' : ''; ?>">
                <?php echo  form_label(lang('meta_description'), 'metadescription'); ?>
                <?php
                  $populateData = $this->input->post('metadescription') ? $this->input->post('metadescription') : (isset($editData['meta_description']) ? $editData['meta_description'] :  '' );
                ?>
                <textarea name="metadescription" id="metadescription" class="form-control " rows="5" ><?php echo xss_clean($populateData);?></textarea>
                <span class="small form-error"> <?php echo strip_tags(form_error('metadescription')); ?> </span>
              </div>
            </div>

            <div class="clearfix"></div>
             <hr />

            <?php 
            $populateData = isset($editData['id']) && $editData['id'] ? lang('core_button_update') : lang('core_button_save'); ?>
            
            <input type="submit" name="<?php echo xss_clean($populateData);?>" value="<?php echo ucfirst($populateData);?>" class="btn btn-primary btn-lg">
            <a href="<?php echo base_url("admin/blog/post");?>" class="btn btn-dark btn-lg"><?php echo lang('core_button_cancel'); ?></a>
            <?php echo form_close(); ?>
         </div>
      </div>
   </div>
</div>