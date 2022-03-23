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
    data-button-theme="brand-color"
    data-order_id="<?php echo $data['order_id']?>"
    data-display_amount="<?php echo $data['amount']?>"
    data-display_currency="<?php echo 'INR'?>"
  >
  </script>
  <!-- Any extra fields to be submitted with the form but not sent to Razorpay -->
  <input type="hidden" name="shopping_order_id" value="<?php echo $order_data['receipt']?>">
<?php form_close();?>

<style>
  .razorpay-payment-button {
    background-color: red!important;
  }
</style>