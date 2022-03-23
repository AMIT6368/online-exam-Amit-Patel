
<div class="container home_page">
  <div class="row">
    <?php 
    foreach ($category_data as $category_array) 
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
      <?php 
    } ?>  

        </div>
      </div>


     