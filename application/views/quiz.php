<div class="container">
  <div class="row">
    <div class="col-12 text-center"> <h2 class="heading"><?php echo ucwords($category_data->category_title); ?></h2><hr></div>

    <?php 
      foreach ($sub_category_data as $category_array) 
      {
        ?>
      <div class="col-md-4 col-xl-4 col-sm-6" > 
        <div class="grid">

          <figure class="effect-ming">
            <figcaption>
              <h2><?php echo xss_clean($category_array->category_title);  ?></h2>
              <a href="<?php echo  base_url('category/').$category_array->category_slug ?>"><?php echo lang('view_more') ?></a>
            </figcaption>     
          </figure>
        </div>
      </div>

      <?php } ?>

      <?php if(count($sub_category_data)) { ?>
        <div class="col-12"><hr></div>
      <?php } ?>

  </div>
  <div class="row">
    <div class="col-10"></div>
    <?php
      $data['quiz_list_data'] = $quiz_data;
      $this->load->view('quiz_data_list',$data);  
    ?>
  </div>
  <?php echo xss_clean($pagination) ?>
</div>
