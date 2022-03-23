<?php
	$header_background = (isset($post_detail_data->post_image) && !empty($post_detail_data->post_image) ? base_url('assets/images/blog_image/post_image/'.$post_detail_data->post_image) : base_url('assets/images/page/15957069405.jpg'));
	$category_slug = $post_detail_data->category_slug;
?>
<div style="background: url(<?php echo $header_background?>);height: 200px;width: 100%;" class="width-100 content_page">
  <div class="container content_page">
  </div>
</div>

<div class="container content_page">
	<div class="col-12 text-center"> <h2 class="heading"><?php echo ucfirst(xss_clean($post_detail_data->post_title)); ?></h2><hr/> 
	</div>
	<div class="col-12">
		<div class="share text-right"> 
			<a href="javascript:void(0)" class="icon inline-block ml-3 like-post pr-5 ">
				<?php $like_or_not = (isset($post_detail_data->is_like) && !empty($post_detail_data->is_like) ? 'text-success' : 'text-muted');?>
		  		<span><i class="fav_icon fas fa-heart <?php echo xss_clean($like_or_not);?> " data-post_id="<?php echo xss_clean($post_detail_data->id);?>"></i></span>	
		  	</a>	
          <span class="pr-3">Share</span>
          <span class="pr-3"><a href="//www.facebook.com/sharer.php?u=<?php echo base_url('blog-detail/').$post_detail_data->post_slug; ?>"  target="_blank"><i class="fab fa-facebook-f fb-icon"></i></a></span>
          <span class="pr-3"><a href="//twitter.com/share?text=<?php echo str_replace(' ', '+', $post_detail_data->post_title); ?>&url=<?php echo base_url('blog-detail/').$post_detail_data->post_slug; ?>" target="_blank"><i class="fab fa-twitter tw-icon"></i></a></span>
          <span class="pr-3"><a href="tg://msg?text=<?php echo str_replace(' ', '+', $post_detail_data->post_title); ?> on <?php echo base_url('blog-detail/').$post_detail_data->post_slug; ?>" target="_blank"><i class="fab fa-telegram-plane tele-icon"></i></a></span>
          <span class="pr-3"><a href="//web.whatsapp.com/send?text= <?php  echo str_replace(' ', '+', $post_detail_data->post_title); ?> on <?php  echo base_url('blog-detail/').$post_detail_data->post_slug; ?>" target="_blank"><i class="fab fa-whatsapp wc-icon"></i></a></span>
        </div>
	</div>
  	<div class="row  mt-5"> 
      <div class="col-md-9 col-xl-9 col-sm-12" >
      	<?php echo xss_clean($post_detail_data->post_description); ?>
      </div>

      	<div class="col-md-3 col-xl-3 col-sm-12">
	    	<div class="list-group">
	    		<?php $active = $category_slug == 'all' OR $category_slug =='ALL' ? ' active' : '' ?>
	    		<a href="<?php echo base_url('blog/list/all');?>" class="list-group-item list-group-item-action list-group-item-secondary <?php echo $active; ?>">
			       	<h4 class="m-0"><?php echo lang("admin_blog_category_list");?></h4>
			    </a> 

		    	<?php 
		    	if($blog_category)
	    		{
	    			foreach($blog_category as $blog_category_key => $blog_category_value)
	    			{ 
	    				$active = $category_slug == $blog_category_value->slug ? ' active' : '' ?>

	    				<a href="<?php echo base_url('blog/list/'.$blog_category_value->slug);?>" class="list-group-item list-group-item-action <?php echo $active; ?>">
			       			<i class="fas fa-angle-right"></i> <?php echo $blog_category_value->title;?>
			    		</a> <?php 
	    			}
	    		} ?>	
	    	</div>
	    </div>
  	</div>
</div>