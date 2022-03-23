<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Begin page content -->
<div class="container">
    <div class="row mt-4">
        <!-- <div class="col-sm-4"></div> -->
        <div class="col-4 mx-auto">
            <div class="card mt-5">
                <div class="card-header bg-danger text-white">
                	<h4 class="card-text">Oops! Payment failed</h4>
                </div>
                <div class="card-body">
                	Transaction has failed. Click here to navigate <br>
                    <a class="btn btn-dark btn-block mt-5" href="<?php echo site_url('/'); ?>"> Home</a>
                </div>
            </div>
        </div>
    </div>
</div> 