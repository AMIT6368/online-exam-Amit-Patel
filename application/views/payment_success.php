<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>


<!-- Begin page content -->
<div class="container">
    <div class="row mt-3">
        <!-- <div class="col-sm-4"></div> -->
        <div class="col-4 mx-auto">
            <div class="card mt-5">
                <img class="card-imgs-top" src="https://cdn.dribbble.com/users/411286/screenshots/2619563/desktop_copy.png" alt="Card image cap"  height="250">
                <div class="card-block" style="padding: 20px;">
                    <h4 class="card-title font-weight-bolder"><?php echo $quiz_data->title.' ('.$quiz_data->price.'₹)'; ?><?php  $payment_id; ?></h4>
                    <p class="card-text">Hello<span class="text-success"> <?php echo $payment_data->name; ?></span> We received your payment on your purchase, check your email for more information. And Your Transcation Id Is <span class="text-primary"><?php echo $payment_data->txn_id; ?></span></p>
                    <a href="<?php echo base_url("instruction/$quiz_id"); ?>" class="btn btn-info btn-block float-right">Start Quiz Now</a>
                </div>
            </div>
        </div>
    </div>
</div> 