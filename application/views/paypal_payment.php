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
                     <?php echo form_open(base_url("paypal/payment/quiz-pay/$quiz_id"), array('role'=>'form'));?>
                        <input type="hidden" name="plan_name" value="<?php echo $quiz_data->title; ?>" /> 
                        <input type="hidden" name="plan_description" value="<?php echo $quiz_data->description; ?>" />
                        <input type="submit" name="subscribe" value="Pay Now" class="btn-subscribe btn btn-primary btn-block" />
                    <?php form_close();?>

                </div>
            </div>      
        </div>

        <div class="col-md-4"> </div>
        <div class="clearfix"></div>
    </div>
</div> 