
<!DOCTYPE html> 
<html lang="en">
  <head>
    <meta charset="utf-8">
    <link rel="icon" type="image/x-icon" sizes="32x32" href="<?php echo base_url('/assets/images/logo/'); ?><?php echo get_admin_setting('site_favicon'); ?>" />
    <title><?php echo $title .' '. get_admin_setting('site_name');?></title>
    <link rel="stylesheet" href="<?php echo base_url('assets/themes/admin/css/invoice_style.css');?>" media="all" />

    <style>
      .header-brand-imgee{
        background-image: url('<?php echo base_url('/assets/images/logo/').get_admin_setting('site_logo'); ?>'); 
      }
    </style>
  </head>


  <body>
    <input type="button" class="print-btn" onclick="printinvoice('printableInvoice')" value="print" />
    <div class="clearfix"></div>
    <div id="printableInvoice">

      <header class="clearfix">
        <div id="logo">
          <a class="header-brand" href="<?php echo base_url()?>">
            <img class="header-brand-img" src="<?php echo base_url('/assets/images/logo/').get_admin_setting('site_logo'); ?>"  >
          </a>
        </div>
        <?php if(get_admin_setting('invoice_header_text')) { ?>
          <div id="company">
            <?php echo get_admin_setting('invoice_header_text');?>
          </div>
        <?php } ?>  
      </header>
      <main>
        <div id="details" class="clearfix">
          <div id="client">
            <div class="to">INVOICE TO:</div>
            <h2 class="name"><?php echo $payment_data->first_name.' '.$payment_data->last_name;?></h2>
            <div class="email"><a href="mailto:<?php echo $payment_data->email;?>"><?php echo $payment_data->email;?></a></div>
          </div>
          <div id="invoice">
            <?php if(isset($payment_data->invoice_no)){ ?>
              <h1>INVOICE <?php echo $payment_data->invoice_no;?></h1>
            <?php } ?>  
            <div class="date">Date of Invoice: <?php echo date('d/m/Y H:i:s',strtotime($payment_data->created));?></div>
            <div class="date">
              <?php $payment_status = ($payment_data->payment_status == 'pending' ? 'pending' : ($payment_data->payment_status == 'fail' ? 'fail' : ($payment_data->payment_status == 'succeeded' ? 'success' : ""))); ?>
              <span class="<?php echo $payment_status;?>"><?php echo $payment_data->payment_status;?></span>
            </div>
          </div>
        </div>
        <table border="0">
          <thead>
            <tr>
              <th class="desc">DESCRIPTION</th>
              <th class="total">TOTAL</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <?php $description = strlen($payment_data->description) > 150 ? substr($payment_data->description,0,147)."..." : $payment_data->description; ?>
              <td class="desc"><h3><?php echo $payment_data->item_name;?></h3><?php echo $description;?></td>
              <td class="total"><?php echo $payment_data->item_price_currency.' '.$payment_data->item_price;?></td>
            </tr>
          </tbody>
        </table>

        <table>
          <tfoot>
              <tr>
                <?php $tax_percentage = (get_admin_setting('tax_percentage')) ? get_admin_setting('tax_percentage') : ""; ?>
                <?php $tax = $payment_data->item_price*$tax_percentage/100;?>
                
                <td colspan="2"></td>
                <td colspan="2">SUBTOTAL</td>
                <?php  $sub_total = $payment_data->item_price - $tax; ?>
                <td><?php echo $sub_total;?></td>
              </tr>
              <tr>
                <td colspan="2"></td>
                <?php $tax_name = (get_admin_setting('tax_name')) ? get_admin_setting('tax_name') : ""; ?>
                
                <td colspan="2"><?php echo $tax_name;?> <?php echo $tax_percentage;?>%</td>
                

                <td><?php echo $payment_data->item_price_currency .' '.$tax; ?></td>
              </tr>
              <tr>
                <td colspan="2"></td>
                <td colspan="2">GRAND TOTAL</td>
                <td><?php echo $payment_data->item_price_currency.' '.$payment_data->item_price;?></td>
              </tr>
          </tfoot>
        </table>
        <div id="thanks">Thank you!</div>
      </main>
      <?php if(get_admin_setting('invoice_footer_text')) { ?>
        <footer>
         <?php echo get_admin_setting('invoice_footer_text');?>
        </footer>
      <?php } ?>  


     </div>

  </body>
</html>

<script>
  function printinvoice(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;

}
</script>