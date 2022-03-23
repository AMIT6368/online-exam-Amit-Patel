<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php
   $currency =  get_admin_setting('currency_code');
   $currency_code =  get_currency_symbol($currency);
?>
<div class="container-fluid pt-5 body_background profile_update_page">
   <div class="container">
      <div class="row">
         <div class="col-12 "> 
            <ul class="nav nav-tabs m-0 p-0 bg-white" id="my-profile-Tab" role="tablist">
               <li class="nav-item w-30">
                  <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false"><?php echo lang('profile_user'); ?></a>
               </li>
            </ul>
            <div class="tab-content" id="my-profile-TabContent">
               <div class="tab-pane fade active show" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                  <div class="bg-white card-primary">
                     <div class="card-header">
                        <h4><?php echo lang('Update Profile'); ?></h4>
                     </div>
                     <div class="card-body">
                        <?php echo form_open_multipart('', array('role'=>'form')); ?>
                        <?php // username ?>
                        <div class="row">
                           <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
                              <div class="row">
                                 <div class="form-group col-12<?php echo form_error('username') ? ' has-error' : ''; ?>">
                                    <?php echo form_label(lang('username'), 'username', array('class'=>'control-label')); ?>
                                    <span class="required"> * </span>
                                    <?php echo form_input(array('name'=>'username', 'id'=>'username','value'=>set_value('username', (isset($user['username']) ? $user['username'] : '')), 'class'=>'form-control')); ?>
                                    <span class="small text-danger"> <?php echo strip_tags(form_error('username')); ?> </span>
                                 </div>
                              </div>
                              <div class="row">
                                 <?php // first name ?>    
                                 <div class="form-group col-6<?php echo form_error('first_name') ? ' has-error' : ''; ?>">
                                    <?php echo form_label(lang('front_first_name'), 'first_name', array('class'=>'control-label')); ?>
                                    <span class="required">*</span>
                                    <?php echo form_input(array('name'=>'first_name','id'=>'first_name', 'value'=>set_value('first_name', (isset($user['first_name']) ? $user['first_name'] : '')), 'class'=>'form-control')); ?>
                                    <span class="small text-danger"> <?php echo strip_tags(form_error('first_name')); ?> </span>
                                 </div>
                                 <?php // last name ?>
                                 <div class="form-group col-6<?php echo form_error('last_name') ? ' has-error' : ''; ?>">
                                    <?php echo form_label(lang('front_last_name'), 'last_name', array('class'=>'control-label')); ?>
                                    <span class="required">*</span>
                                    <?php echo form_input(array('name'=>'last_name','id'=>'last_name', 'value'=>set_value('last_name', (isset($user['last_name']) ? $user['last_name'] : '')), 'class'=>'form-control')); ?>
                                    <span class="small text-danger"> <?php echo strip_tags(form_error('last_name')); ?> </span>
                                 </div>
                              </div>
                              <div class="row">
                                 <?php // email ?>
                                 <div class="form-group col-6<?php echo form_error('email') ? ' has-error' : ''; ?>">
                                    <?php echo form_label(lang('front_email'), 'email', array('class'=>'control-label')); ?>
                                    <span class="required">*</span>
                                    <?php echo form_input(array('name'=>'email', 'value'=>set_value('email', (isset($user['email']) ? $user['email'] : '')), 'class'=>'form-control', 'type'=>'email')); ?>
                                    <span class="small text-danger"> <?php echo strip_tags(form_error('email')); ?> </span>
                                 </div>
                                 <?php // language ?>
                                 <div class="form-group col-6<?php echo form_error('language') ? ' has-error' : ''; ?>">
                                    <?php echo form_label(lang('front_language'), 'language', array('class'=>'control-label')); ?>
                                    <span class="required">*</span>
                                    <?php echo form_dropdown('language', $this->languages, (isset($user['language']) ? $user['language'] : $this->config->item('language')), 'id="language" class="form-control"'); ?>
                                    <span class="small text-danger"> <?php echo strip_tags(form_error('language')); ?> </span>
                                 </div>
                              </div>
                              <div class="row">
                                 <?php // password ?>
                                 <div class="form-group col-6<?php echo form_error('password') ? ' has-error' : ''; ?>">
                                    <?php echo form_label(lang('password'), 'password', array('class'=>'control-label')); ?>
                                    <?php if ($password_required) : ?>
                                    <span class="required">* </span>
                                    <?php endif; ?>
                                    <?php echo form_password(array('name'=>'password', 'value'=>'', 'class'=>'form-control', 'autocomplete'=>'off')); ?>
                                    <span class="small text-danger"> <?php echo strip_tags(form_error('password')); ?> </span>
                                 </div>
                                 <?php // password repeat ?>
                                 <div class="form-group col-6<?php echo form_error('password_repeat') ? ' has-error' : ''; ?>">
                                    <?php echo form_label(lang('front_password_repeat'), 'password_repeat', array('class'=>'control-label')); ?>
                                    <?php if ($password_required) : ?>
                                    <span class="required">* </span>
                                    <?php endif; ?>
                                    <?php echo form_password(array('name'=>'password_repeat', 'value'=>'', 'class'=>'form-control', 'autocomplete'=>'off')); ?>
                                    <span class="small text-danger"> <?php echo strip_tags(form_error('password_repeat')); ?> </span>
                                 </div>
                                 <?php if ( ! $password_required) : ?>
                                 <div class="col-12 mb-3">
                                    <span class="help-block text-warning"><?php echo lang('help_passwords'); ?></span>
                                 </div>
                                 <?php endif; ?>
                              </div>
                              <div class="row d-none">
                                 <div class="form-group col-12<?php echo form_error('password_repeat') ? ' has-error' : ''; ?>">
                                    <?php echo form_label(lang('front_upload_image'), 'user_image', array('class'=>'control-label')); ?>
                                    <?php echo form_upload(array('name'=>'user_image','class'=>'form-control'));?>
                                 </div>
                              </div>
                              <?php // buttons ?>
                              <div class="row ">
                                 <div class="form-group col-12 mt-3"> 
                                    <?php if ($this->session->userdata('logged_in')) : ?>
                                    <button type="submit" name="submit" class="btn btn-block btn-primary"><span class="glyphicon glyphicon-save"></span> <?php echo lang('core_button_save'); ?></button>
                                    <?php else : ?>
                                    <button type="submit" name="submit" class="btn btn-block btn-primary btn-lg"><?php echo lang('users_register'); ?></button>
                                    <?php endif; ?>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <?php echo form_close(); ?>      
                     </div>
                  </div>
               </div>
               <div class="tab-pane fade " id="quiz-purchased" role="tabpanel" aria-labelledby="quiz-purchased-tab">
                  <div class="bg-white card-primary">
                    <div class="card-header">
                      <h4></h4>
                    </div>
                    <div class="card-body">
                      <div class="row">
                        <?php 
                              $data['quiz_list_data'] = $purchased_quiz;
                              $this->load->view('quiz_data_list',$data); 
                            ?> 
                      </div>
                    </div>    
                  </div>  
               </div>
               <div class="tab-pane fade " id="quiz-like" role="tabpanel" aria-labelledby="quiz-like-tab">
                  <div class="bg-white card-primary">
                     <div class="card-header">
                        <h4></h4>
                     </div>
                     <div class="card-body">
                        <div class="row">
                            <?php 
                              $data['quiz_list_data'] = $quiz_data;
                              $this->load->view('quiz_data_list',$data); 
                            ?>   
                        </div>
                     </div>
                  </div>
               </div>
               <div class="tab-pane fade " id="post-like" role="tabpanel" aria-labelledby="post-like-tab">
                 <div class="bg-white card-primary">
                     <div class="card-header">
                        <h4></h4>
                     </div>
                     <div class="card-body">
                        <div class="row">
                           <?php 
                              $data['blog_list_data'] = $like_post;
                              $this->load->view('common_blog_list',$data);
                           ?>
                        </div>      
                     </div>      
                  </div>
               </div>
               <div class="tab-pane fade " id="payment-list" role="tabpanel" aria-labelledby="payment-list-tab">
                  <div class="bg-white card-primary">
                     <div class="card-header">
                        <h4></h4>
                     </div> 
                     <div class="card-body">
                        <div class="row">
                           <div class="col-12 my-5">
                              <?php if($payment_list){ ?>                            
                              <table class="table">
                                <thead class="thead-dark">
                                  <tr class="py-5">
                                    <th scope="col" class="py-5"><?php echo lang('name'); ?></th>
                                    <th scope="col" class="py-5"><?php echo lang('dashboard_quiz'); ?></th>
                                    <th scope="col" class="py-5"><?php echo lang('amount'); ?></th>
                                    <th scope="col" class="py-5"><?php echo lang('payment_method'); ?></th>
                                    <th scope="col" class="py-5"><?php echo lang('admin_status'); ?></th>
                                    <th scope="col" class="py-5"><?php echo lang('admin_table_action'); ?></th>
                                  </tr>
                                </thead>
                                <tbody>
                                 <?php
                                   foreach ($payment_list as  $payment_array) 
                                   {
                                     
                                 ?>   
                                    <tr>
                                       <td class="py-5"><?php echo $payment_array->first_name.' '.$payment_array->last_name;?></td>
                                       <td class="py-5"><?php echo $payment_array->item_name;?></td>
                                       <td class="py-5"><?php echo $payment_array->item_price_currency.' '.$payment_array->item_price;?></td>
                                       <td class="py-5"><?php echo $payment_array->payment_gateway;?></td>
                                       <?php $status = ($payment_array->payment_status == 'pending' ? 'text-warning' : ($payment_array->payment_status == 'fail' ? 'text-danger' : ($payment_array->payment_status == 'succeeded' ? 'text-success' : ''))); ?>
                                       <td class="<?php echo $status;?> py-5 "><?php echo $payment_array->payment_status;?></td>
                                       
                                       <?php 
                        
                                        $encrypted_payment_id = $this->encrypt->encode($payment_array->id);
                                        $encrypted_payment_id = str_replace("=","","$encrypted_payment_id");
                                      ?>
                                       <td>
                                          <span class="btn btn-warning my-3 myBtn" data-payment_id="<?php echo $payment_array->id;?>" data-toggle="modal" data-target="#myModal" data-whatever="@mdo" data-encrypted_payment_id="<?php echo $encrypted_payment_id;?>">View Detail</span>
                                          <a href="<?php echo base_url('invoice/'.$encrypted_payment_id);?>" target="_blank" class="btn btn-info text-white"><?php echo lang('invoice');?></a>
                                       </td>
                                    </tr>
                                 <?php } ?>   
                                </tbody>
                              </table>
                              <?php } else { ?>
                                  <span class="text-center text-danger"><?php echo lang('no_payment_found'); ?></span>
                              <?php }    ?>
                           </div>
                        </div>      
                     </div>
                  </div>   
               </div>   
            </div>
            <!-- card premium-->
         </div>
         <!-- <col-12> -->
      </div>
      <!---row-->
   </div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
               <h4 class="modal-title" id="myModalLabel">Payment Detail</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 

            </div>
            <div class="modal-body payment-data"></div>
            <div class="modal-footer">
                <a target="_blank" class="btn btn-info invoice-bill"><?php echo lang('invoice');?></a>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<?php
  if ($this->session->userdata('logged_in')) : 
    if(uri_string() == 'user/register')
      {
        return redirect(base_url('profile'));
      }
  endif;
?>