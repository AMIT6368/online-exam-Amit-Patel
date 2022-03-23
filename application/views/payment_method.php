<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container">
	<div class="row">	
        <div class="col-md-4"> </div>
        <div class="col-md-4">  
            <div class="card mt-5">
                <div class="card-header bg-success text-white"><?php echo $quiz_data->title; ?> (<?php echo $this->settings->paid_currency ." ". $quiz_data->price; ?>)</div>
                <div class="card-body bg-light">
                    <div class="mb-3">
                        <?php echo form_open(base_url("paypal/payment/quiz-pay/$quiz_id"), array('role'=>'form')); ?>
                                <input type="hidden" name="plan_name" value="<?php echo $quiz_data->title; ?>" /> 
                                <input type="hidden" name="plan_description" value="<?php echo $quiz_data->description; ?>" />
                                <?php 
                                    if(!empty($this->settings->paypal_key) && !empty($this->settings->paypal_secret_key) && !empty($this->settings->paid_currency))
                                    {
                                ?>
                                    <input type="submit" name="subscribe" value="Paypal" class="btn-subscribe btn btn-primary btn-block" />
                                <?php } ?>    
                        <?php echo form_close();  ?>
                    </div>
                    <?php     
                        if(!empty($this->settings->stripe_key) && !empty($this->settings->stripe_secret_key) && !empty($this->settings->paid_currency))
                        { 
                    ?>        
                            <a href="<?php echo base_url("stripe/checkout/quiz/$quiz_id"); ?>" class="btn   btn-block btn-warning mb-3">Stripe</a>  
                    <?php } ?>
                    <?php    
                        if(!empty($this->settings->razorpay_key) && !empty($this->settings->razorpay_secret_key) && !empty($this->settings->paid_currency))
                        {    
                    ?>

                        <a href="<?php echo base_url("razorpay/checkout/quiz/$quiz_id"); ?>" class="btn btn-block btn-danger mb-3">Razorpay</a>  
                    <?php } ?>
                    <?php if(!empty($this->settings->bank_transfer) && !empty($this->settings->paid_currency)) { ?>
                        <span class="btn btn-block btn-info mb-3" data-toggle="modal" data-target="#myModal" title="Bank Transfer">Bank Transfer</span>
                    <?php } ?>    
                </div>
            </div>      
        </div>

        <div class="col-md-4"> </div>
        <div class="clearfix"></div>
    </div>
</div> 

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Bank Transfer Detail</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

       <?php //echo form_open('',array('role'=>'form')); ?>      
            <div class="modal-body">
                <?php echo $this->settings->bank_transfer;?>   
                  <div class="form-group">
                    <label for="transaction-no" class="col-form-label">Reference No / Transaction No.:</label>
                    
                    <?php $token_value = (isset($payment_pending_status->token_no) && !empty($payment_pending_status->token_no) ? $payment_pending_status->token_no : "");?>
                    <input type="text" class="form-control" name="transaction_no" id="transaction-no" value="<?php echo $token_value;?>" placeholder="Enter your transaction/reference number">
                    <span class="bank text-danger"></span>
                    <input type="hidden" class="quiz_id" value="<?php echo $quiz_id;?>">
                    <input type="hidden" class="quiz-price" value="<?php echo $quiz_data->price;?>">
                  </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <?php $save_update = (isset($token_value) && !empty($token_value) ? 'update-data' : 'save-data');?>
                <input type="submit" name="save" class="btn btn-primary <?php echo $save_update;?>">
            </div>

      <?php //echo form_close();?>    

    </div>
  </div>
</div>
