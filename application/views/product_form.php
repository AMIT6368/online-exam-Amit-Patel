<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<script type="text/javascript" src="//js.stripe.com/v2/"></script>    

<div class="container">

	<div class="row">	

        <div class="col-md-4"> </div>
        <div class="col-md-4"> 
            
            <div class="card mt-5">
                <div class="card-header bg-success text-white"><?php echo $quiz_data->title; ?> (<?php echo $this->settings->paid_currency." ". $quiz_data->price; ?>)</div>
                <div class="card-body bg-light">
                    <?php if (validation_errors()): ?>
                        <div class="alert alert-danger" role="alert">
                            <strong>Oops!</strong>
                            <?php echo validation_errors() ;?> 
                        </div>  
                    <?php endif ?>
                    <div id="payment-errors"></div>  
                    <?php echo form_open_multipart(base_url("stripe/checkout/quiz-pay/$quiz_id"), array('role'=>'form','id'=>'paymentFrm')); ?>
                        <div class="form-group">
                            <input type="text" name="name" class="form-control" placeholder="Name" value="<?php echo set_value('name'); ?>" required>
                        </div>  

                        <div class="form-group">
                            <input type="email" name="email" class="form-control" placeholder="email@you.com" value="<?php echo set_value('email'); ?>" required />
                        </div>



                         <div class="form-group">
                            <label class="form-label ml-2">Credit Card Numbder<?php echo lang('credit_card_number');?></label>
                            <input type="number" name="card_num" id="card_num" class="form-control creditcard " placeholder="Card Number" maxlength="16" autocomplete="off" value="<?php echo set_value('card_num'); ?>" required>
                        </div>
                       
                        
                        <div class="row">

                            <div class="col-sm-8">
                                 <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" name="exp_month" maxlength="2" class="form-control" id="card-expiry-month" placeholder="MM" value="<?php echo set_value('exp_month'); ?>" required>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" name="exp_year" class="form-control" maxlength="4" id="card-expiry-year" placeholder="YYYY" required="" value="<?php echo set_value('exp_year'); ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <input type="text" name="cvc" id="card-cvc" maxlength="3" class="form-control" autocomplete="off" placeholder="CVC" value="<?php echo set_value('cvc'); ?>" required>
                                </div>
                            </div>
                        </div>
                        

                       

                        <div class="form-group ">
                          <button type="submit" id="payBtn" class="btn btn-success btn-block">Pay Now</button>
                          <button class="btn btn-dark btn-block" type="reset">Reset</button>
                        </div>
                    <?php form_close();?>
                </div>
            </div>
                 
        </div>

        <div class="col-md-4"> </div>
        <div class="clearfix"></div>
    </div>
</div> 