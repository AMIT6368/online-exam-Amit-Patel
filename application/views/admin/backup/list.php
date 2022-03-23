<?php defined('BASEPATH') OR exit('No direct script access allowed');
   if($this->session->flashdata('success')) {
      echo '<div class="alert alert-success alert-dismissible">
      <button type="button" class="close" aria-label="close" data-dismiss="alert">&times;</button>
      <strong>Success!</strong> '.$this->session->flashdata("success").'
      </div>';
   }
?>
<div class="panel panel-default">
   <a href="<?php echo base_url('admin/backup/database_backup');?>" class="btn btn-primary cat float-right" ><?php echo lang('admin_backup_now'); ?></a>
   <div class="clearfix"></div>
   <hr>
   <table id="table" class="display table table-striped table-bordered" cellspacing="0" width="100%">
      <thead>
         <tr>
            <th><?php echo lang('admin_table_no'); ?></th>
            <th><?php echo lang('admin_datetime'); ?></th>
            <th><?php echo lang('admin_table_action'); ?></th>
         </tr>
      </thead>
      <tbody>
         <?php 
            $no = 0;           
            foreach($backup_list as $backup_key => $backup_value)
            {
               $no++;
         ?>      
            <tr>
               <td><?php echo $no;?></td>
               <td><?php echo $backup_value;?></td>
               <td>
                  <a href="<?php echo base_url('admin/backup/download/').$backup_value;?>" data-toggle="tooltip" title="<?php echo lang('admin_record_download');?>" class="btn btn-primary btn-action mr-1"><i class="fas fa-file-download"></i></a>
                  <a href="<?php echo base_url('admin/backup/restore/').$backup_value;?>" data-toggle="tooltip" title="<?php echo lang('admin_record_restore');?>" class="btn btn-info btn-action mr-1 restore"><i class="fas fa-window-restore"></i></a>
                  <a href="<?php echo base_url('admin/backup/delete/').$backup_value;?>" data-toggle="tooltip"  title="<?php echo lang('admin_delete_record');?>" class="btn btn-danger btn-action mr-1 blog_cat_delete"><i class="fas fa-trash"></i></a>
               </td>
            </tr>
         <?php } ?>   
      </tbody>
   </table>
</div>