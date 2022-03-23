<div class="container">
  
  <div class="row">
    <div class="col-12 mb-5">
      <div class="row mt-5">
        <div class="card mb-0">
          <div class="card-header timer py-5">
              <div class="col-md-8 col-xl-8 col-sm-12 text-left my-5">
                <h2 class="heading m-0">
                    <?php 
                    $lang_id = get_language_data_by_language($this->session->userdata('language'));
                    $translate_quiz_title = get_translated_column_value($lang_id,'quizes',$quiz_data['id'],'title');
                    $quiz_title = $translate_quiz_title ? $translate_quiz_title : $quiz_data['title'];
                    echo ucwords($quiz_title);
                    ?>
                </h2>
              </div>
              <div class="col-md-4 col-xl-4 col-sm-12 text-left my-5">  
                <h2 class="card-titlee timer heading m-0">
                  <span class="float-left mr-3"> <?php echo lang('count_down'); ?>: </span>
                  <span class="text-danger timerrr" data-seconds-left=<?php echo xss_clean($left_time); ?> > &nbsp; </span>
                  <section class='actions'></section>
                </h2>
              </div>
          </div>
        </div>
      </div>
    </div>



  <div class="page-header">
    <?php 
      $csrf = array(
        'name' => $this->security->get_csrf_token_name(),
        'hash' => $this->security->get_csrf_hash()
      );
    ?>
  </div>

  <div class="clearfix"></div>
  <!-- <div class="col-12">  <hr> </div> -->


  <form action="" method="POST" id="myform" class="container" >
    <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
    <div class="row">

      <div class="col-lg-8">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">
              <p class="font-weight-bold"><?php echo lang('question_no'); ?> <?php echo xss_clean($question_id); ?>.</p>
              <br />
              <p>
                <?php 
                  $translate_question_title = get_translated_column_value($lang_id,'questions',$question_data['id'],'title');
                  $translate_question_title = $translate_question_title ? $translate_question_title : $question_data['title'];

                  // echo $translate_question_title; 
                  echo htmlspecialchars($translate_question_title); 
                  ?>      
              </p>  
            </h3>
          </div>

          <div class="card-body">

            <?php 
            $question_img = isset($question_data['image']) ? $question_data['image'] : NULL;
            if($question_img)
            {
              ?>
              <div class="questions_img">
                <img src="<?php echo base_url('assets/images/questions/').$question_img; ?>" class="image">
              </div>
              <?php
            }
            ?>

            <div class="selectgroup selectgroup-pills w-100">
              <?php 

                $translate_question_choies = get_translated_column_value($lang_id,'questions',$question_data['id'],'choices');

                $translate_question_choies = $translate_question_choies ? $translate_question_choies : $question_data['choices'];

                $translate_question_choies_data = json_decode($translate_question_choies); 
                $question_choies = $translate_question_choies_data; 
                // $question_choies = json_decode($question_data['choices']); 
                $question_choies_count = COUNT($question_choies);
                $checked = '';
                $chk = 'DUE';
                $p = 0;
                
                foreach ($question_choies as $key =>  $question_choice) 
                { 

                  $p++;              
                  $q_answer = isset($question_data['answer'])  ?  $question_data['answer'] : array();
                  foreach ($q_answer as  $value) 
                  {
                    if($question_choice == $value)
                    {
                      $checked = 'checked';
                      $chk = 'DONE';
                    }
                  }
                  $is_multiple = $question_data['is_multiple'] == 1 ? 'checkbox' : 'radio';
                  $is_multiple_border = $question_data['is_multiple'] == 1 ? 'multiple-choise' : '';
              ?>

                  <label class="selectgroup-item btn-block">
                    <input <?php echo xss_clean($checked) ;?> type="<?php echo xss_clean($is_multiple); ?>" name="answer[]" value="<?php echo htmlspecialchars(xss_clean($question_choice)); ?>" class="selectgroup-input answer_input" >

                    <div class="selectgroup-button <?php echo $is_multiple_border;?>">
                      <?php echo htmlspecialchars(xss_clean($translate_question_choies_data[$key])); ?>
                    </div>
                  </label>
              <?php 
                  $checked = '';               
                }
              ?>
              <?php if($question_data['is_multiple'] == 1) { ?>
                <div class="w-100 text-right text-warning"><?php echo lang('multiple_choice_question');?></div>
              <?php } ?>  
            </div>
          </div>

          <div class="card-footer">
            <div class="card-options">
              <div class="next-previous-main">
                <button type="Submit" name="preview_quiz" value="Previous" class="btn btn-sm btn-azure mr-2"><i class="fe fe-chevron-left"></i><?php echo lang('previous_btn'); ?></button>
                <button type="Submit" name="next_quiz" value="Next" class="btn btn-sm btn-azure mr-2"><?php echo lang('next_btn'); ?> <i class="fe fe-chevron-right"></i></button>
              </div>  
              <button type="Submit" name="mark_or_next_quiz" value="Mark for Review and Next" class="btn btn-sm btn-orange mr-2 ml-auto answer_given"><i class="fe fe-check-circle"></i><?php echo lang('mark_for_review_and_next'); ?> </button>
              <div class="save-next-main">
                <button type="Submit" name="save_or_next_quiz" value="Save & Next" class="btn btn-sm btn-teal mr-2 answer_given"><i class="fe fe-save"></i> <?php echo lang('save_and_next'); ?></button>
                <button type="Submit" name="submit_test" value="Submit Test" class="btn btn-sm btn-azure mr-2 submit_test "><i class="fe fe-corner-down-right"></i><?php echo lang('submit_test'); ?> </button>
              </div>  
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-4 order-lg-1 mb-4">
        <div class="card">
          <div class="card-header timerrrrrr d-none">
            <h3 class="card-title "><span class="float-left mr-3"> <?php echo lang('count_down'); ?>: </span>
               <span class="text-danger timerrr" data-seconds-left=<?php echo xss_clean($left_time); ?> > &nbsp; </span>
              <section class='actions'></section>
            </h3>
          </div>

          <div class="card-body">
            <p class="mb-3"><?php echo lang('question_palette'); ?> : </p>
            <?php 
              $i = 0;
              foreach($quiz_question_data as $quiz_question_array) 
              { 
                $i++;
                $attemp = isset($quiz_question_array['status']) ? $quiz_question_array['status'] : 'btn-gray';
                $attemp = $attemp == 'visited' ? 'btn-danger' : ($attemp == 'mark' ? 'btn-orange ' : ($attemp=='answer' ? 'btn-green ' : 'btn-gray'));
              ?>
                <a href="<?php echo base_url('test/').$quiz_data['id'].'/'.$i; ?>" class="btn <?php echo xss_clean($attemp); ?> ml-1 mb-2 question_no" > <?php echo xss_clean($i) ?></a>
            <?php 
              } 
            ?>
          </div>

          <div class="card-footer">
            <div class="card-options">
              <span class="tag tag-green mr-2 mb-2"><?php echo xss_clean($runn_answered); ?></span> <?php echo lang('answered_tag'); ?>
              <span class="tag tag-red mr-3 mb-2 ml-auto"><?php echo xss_clean($runn_visited); ?> </span><?php echo lang('not_answered_tag'); ?> 
            </div>
          </div>

          <div class="card-footer">
            <div class="card-options">
              <span class="tag tag-purple mr-2 mb-2"><?php echo xss_clean($runn_attemp); ?></span> <?php echo lang('total_attempt'); //; ?> 
              <span class="tag tag-gray mr-6 mb-2 ml-auto"><?php echo xss_clean($runn_not_visited); ?> </span> <?php echo lang('not_visited_tag'); ?>
            </div>
          </div>

          <div class="card-footer">
            <div class="card-options">
              <span class="tag tag-orange mr-2 mb-2"><?php echo xss_clean($runn_mark); ?></span> <?php echo lang('answered_marked_for_review_tag'); ?> 
            </div>
          </div>
        </div>
      </div>

    </div>
  </form>

</div>
