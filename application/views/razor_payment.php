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
                     <!--  The entire list of Checkout fields is available at
                     https://docs.razorpay.com/docs/checkout-form#checkout-fields -->

                    <?php echo form_open(base_url("razorpay/verify/quiz/$payment_id"), array('role'=>'form'));?>
                      
                      <script
                        src="https://checkout.razorpay.com/v1/checkout.js"
                        data-key="<?php echo $data['key']?>"
                        data-amount="<?php echo $data['amount']?>"
                        data-currency="INR"
                        data-name="<?php echo $data['name']?>"
                        data-image="<?php echo $data['image']?>"
                        data-description="<?php echo $data['description']?>"
                        data-prefill.name="<?php echo $data['prefill']['name']?>"
                        data-prefill.email="<?php echo $data['prefill']['email']?>"
                        data-prefill.contact="<?php echo $data['prefill']['contact']?>"
                        data-notes.shopping_order_id="3456"
                        data-order_id="<?php echo $data['order_id']?>"
                      >
                      </script>
                      <!-- Any extra fields to be submitted with the form but not sent to Razorpay -->
                      <input type="hidden" name="shopping_order_id" value="">
                    <?php form_close();?>
                </div>
            </div>      
        </div>

        <div class="col-md-4"> </div>
        <div class="clearfix"></div>
    </div>
</div> 
