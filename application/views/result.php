<input type="hidden" class="not-attemp" value="<?php echo xss_clean($total_question) - xss_clean($total_attemp); ?>">
<input type="hidden" class="correct" value="<?php echo xss_clean($correct); ?>">
<input type="hidden" class="wrong-answer" value="<?php echo xss_clean($total_attemp) - xss_clean($correct); ?>">
<div class="container">
  <div class="row"> 
    <div class="col-12 text-center">
      <h2 class="heading">
        <?php 
          
          $lang_id = get_language_data_by_language($this->session->userdata('language'));
          $translate_quiz_title = get_translated_column_value($lang_id,'quizes',$quiz_data->id,'title');
          $quiz_title = $translate_quiz_title ? $translate_quiz_title : $quiz_data->title;
          
          echo ucfirst($quiz_title); ?> <?php echo lang('quiz_summary'); 
        ?>
          
        </h2>
        <hr>
    </div>

    <div class="clearfix "></div>  
    <div class="col-md-4">
     <?php echo lang('total_atemp_ques'); ?>  : <?php echo  $total_attemp; ?> / <?php echo xss_clean($total_question); ?>
    </div>    
    <div class="col-md-4">
      <strong><?php echo lang('your_score'); ?> </strong> <?php echo round(($correct / $total_question)*100,2); ?>%
    </div>
    <div class="col-md-4">
      <?php 
        $started = $participant_data['started'];
        $completed = $participant_data['completed'];
        
        $started = new DateTime($started);
        $completed = new DateTime($completed);
        $interval = $completed->diff($started);        
      ?>
      <strong> <?php echo lang('time_spend'); ?>  : - </strong> <?php echo sprintf("%02d", $interval->h).':'.sprintf("%02d", $interval->i).':'.sprintf("%02d", $interval->s) ; ?>
    </div>
    <hr />

    <div class="col-md-6">
      <div class="table-responsive">
        <table class="table table-bordered">
          <tbody>
            <tr class="question">
              <td><span class="py-1 px-3 mr-2 bg-red"></span><?php echo lang('total_question'); ?></td>
              <td><?php echo xss_clean($total_question); ?></td>
            </tr>
            
            <tr class="answered">
              <td><span class="py-1 px-3 mr-2 bg-yellow"></span><?php echo lang('total_attem_ques'); ?> </td>
              <td><?php echo  $total_attemp ?></td>
            </tr>

            <tr class="correct">
              <td><span class="py-1 px-3 mr-2 bg-green"></span><?php echo lang('correct_answer'); ?></td>
              <td><?php echo xss_clean($correct); ?></td>
            </tr>

            <tr class="incorrect">
              <td><span class="py-1 px-3 mr-2 bg-orange"></span><?php echo lang('incorrect_answered'); ?></td>
              <td>
                <?php 
                    $wrong_answer = $total_attemp - $correct;
                    echo xss_clean($wrong_answer); 
                ?>
              </td>
            </tr>
            <tr class="notanswer">
              <td><span class="py-1 px-3 mr-2 bg-yellow"></span><?php echo lang('not_attempted'); ?></td>
              <td>
                <?php 
                    $notanswer = $total_question - $total_attemp;
                    echo xss_clean($notanswer); 
                ?>
               </td>
            </tr>
            <tr class="test_language">
              <td><span class="py-1 px-3 mr-2 bg-blue"></span><?php echo lang('quiz_language'); ?></td>
              <td>
                <?php 

                    $test_language = isset($participant_data['test_language']) ? $participant_data['test_language'] : 'English';
                    echo xss_clean($test_language); 
                ?>
               </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="col-md-6">
      <div class="table100 py-0 ver1  m-b-110">
      
        <table>
          <thead>
            <tr class="row100 head "> 
              <th class="cell100 result-column1 py-5 "><?php echo lang('questions'); ?></th>
              <th class="cell100 result-column2"><?php echo lang('goven_answer'); ?></th>
              <th class="cell100 result-column3"><?php echo lang('correct_answer'); ?></th>
              <th class="cell100 result-column4"><?php echo lang('status'); ?></th>
              <th class="cell100 result-column5"><?php echo lang('detail'); ?></th>
            </tr>
          </thead>

          <tbody>
            <?php 
            $l = 0;
            foreach ($user_question_data as  $question_data) 
            {
              $l++;
              ?>
              <tr class="row100 body botder-bottom">
                <td class="cell100 result-column1 py-5"><?php echo sprintf("%02d", $l); ?>. <?php echo htmlspecialchars(($question_data['question'])); ?>
                </td>
                <td class="cell100 result-column2"> 
                  <?php 
                  $given_answer_array = json_decode($question_data['given_answer']);
                  if($given_answer_array)
                  {
                    foreach ($given_answer_array as $given_answer) 
                    {
                      ?>
                        <li><?php echo htmlspecialchars(xss_clean($given_answer)); ?></li>
                      <?php
                    }
                  }
                  else
                  {
                    echo " - ";
                  }
                  ?> 
                </td>
                <td class="cell100 result-column3"> 
                  <?php 
                  $given_correct_choice = json_decode($question_data['correct_choice']);
                  if($given_correct_choice)
                  {
                    foreach ($given_correct_choice as $correct_choice) 
                    {
                      ?>
                        <li><?php echo htmlspecialchars($correct_choice); ?></li>
                      <?php
                    }
                  }
                  else
                  {
                    echo " - ";
                  }
                  ?> 
                </td>

                <td class="cell100 result-column4">
                  <?php
                  if($question_data['is_correct'] == 1 && $given_answer_array )
                  {
                    ?>
                    <a class="badge btn-success text-white badge-xs"><?php echo lang('correct'); ?></a> 
                  <?php
                  }
                  elseif($question_data['is_correct'] == 0 && $given_answer_array)
                  {
                  ?>
                    <a class="badge btn-danger text-white badge-xs"><?php echo lang('wrong'); ?></a>
                  <?php
                  }
                  else
                  {
                  ?>
                    <a class="badge btn-warning  text-white badge-xs"><?php echo lang('not_attempted'); ?></a>
                  <?php
                  }
                  ?>
                </td>
                <td class="cell100 result-column5">
                  <?php
                  if($question_data['is_correct'] == 1 && $given_answer_array)
                  {
                    ?>
                    <a class="btn btn-info text-white btn-xs" data-toggle="modal" data-target="#Modal_<?php echo xss_clean($question_data['id']); ?>"><?php echo lang('view_answer'); ?></a>
                  <?php } 
                    elseif($question_data['is_correct'] == 0 && $given_answer_array)
                    {
                  ?>
                      <a class="btn btn-info text-white btn-xs" data-toggle="modal" data-target="#Modal_<?php echo xss_clean($question_data['id']); ?>"><?php echo lang('view_answer'); ?></a>  
                  <?php
                  }
                  else
                  {
                  ?>   
                      <a class="btn btn-info text-white btn-xs" data-toggle="modal" data-target="#Modal_<?php echo xss_clean($question_data['id']); ?>"><?php echo lang('view_answer'); ?></a>
                    <?php
                  }
                  ?>   
                </td>
              </tr>
              <?php
            } 
            ?>
          </tbody>
        </table>
      
    </div>
  </div>
</div>

<?php foreach ($user_question_data as  $question_data) {  ?>
  <div class="modal fade bd-example-modal-lg" id="Modal_<?php echo xss_clean($question_data['id']); ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalCenterTitle"><?php echo lang('question_detail'); ?></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span class="d-none" aria-hidden="true">×</span>
          </button>
        </div>

        <div class="modal-body">
          <div class="left_content">
            <ul>
              <strong> <?php echo lang('question'); ?>: &nbsp;</strong><?php echo htmlspecialchars($question_data['question']); ?>
              <ul class="result-exam-question">
                <?php 
                  $choices_arr = json_decode($question_data['choices']);
                  $correct_choice = json_decode($question_data['correct_choice']);
                  $given_answer = json_decode($question_data['given_answer']);
                  $question_status = lang('not_attempted_this_questions');
                  foreach ($choices_arr as  $choices_val) 
                  {
                ?>
                  <li>                  
                    <?php
                    if($question_data['is_correct'] == 1)
                    { 
                      $question_status = lang('right_answer');
                      $checked = '';
                      $text_color = '';

                      foreach ($correct_choice as  $valueee) 
                      {
                        if(empty($checked))
                        {                        
                          $checked = $choices_val == $valueee ? 'checked' : '';
                          $text_color = $choices_val == $valueee ? 'text-success' : '';
                        }
                      }
                      ?>
                        <div class="custom-control custom-checkbox right_answer">
                          <input type="checkbox" class="custom-control-input" id="question_<?php echo xss_clean($question_data['id']); ?>" <?php echo xss_clean($checked); ?> >
                          <label class="custom-control-label <?php echo xss_clean($text_color); ?>" for="question_<?php echo (xss_clean($question_data['id'])); ?>"> <?php echo htmlspecialchars($choices_val); ?></label>
                        </div>

                      <?php
                    }
                    elseif($given_answer && $question_data['is_correct'] == 0)
                    { 
                      $question_status = lang('wrong_answer');
                      $checked = '';
                      $checked = '';
                      $text_color = '';
                      $wrong_checked = '';

                      foreach ($given_answer as  $valueee) 
                      {
                        if(empty($wrong_checked))
                        {                        
                          $wrong_checked = $choices_val == $valueee ? 'checked' : '';
                          $text_color = $choices_val == $valueee ? 'text-danger wrong_check' : '';
                        }
                      }

                      foreach ($correct_choice as  $valueee) 
                      {
                        if(empty($checked))
                        {
                          $checked = $choices_val == $valueee ? 'checked' : '';
                        }
                      }
                      ?>
                        <div class="custom-control custom-checkbox wrong_answer">
                          <input type="checkbox" class="custom-control-input" id="question_<?php echo xss_clean($question_data['id']); ?>" <?php echo xss_clean($checked); ?> <?php echo xss_clean($wrong_checked); ?> >
                          <label class="custom-control-label <?php echo xss_clean($text_color); ?>" for="question_<?php echo (xss_clean($question_data['id'])); ?>"> <?php echo htmlspecialchars($choices_val); ?></label>
                        </div>
                      <?php
                    }
                    else
                    { 
                      $question_status = lang('not_attemp_question');
                      $checked = '';
                      $text_color = '';

                      foreach ($correct_choice as  $valueee) 
                      {
                        if(empty($checked))
                        {
                          $checked = $choices_val == $valueee ? 'checked' : '';
                        }
                      }
                      ?>
                        <div class="custom-control custom-checkbox notanswer">
                          <input type="checkbox" class="custom-control-input" id="question_<?php echo xss_clean($question_data['id']); ?>" <?php echo xss_clean($checked); ?> >
                          <label class="custom-control-label <?php echo xss_clean($text_color); ?>" for="question_<?php echo (xss_clean($question_data['id'])); ?>"> <?php echo htmlspecialchars($choices_val); ?></label>
                        </div>
                      <?php
                    }
                    ?>
                  </li>
                    <?php
                } ?>

                <li>
                  <label class="result">
                    <?php echo lang('question_status'); ?>: <span class="option "> <?php echo xss_clean($question_status); ?></span>
                  </label>
                </li>
                <?php if($question_data['solution']) { ?>
                  <li>
                    <label class="result">
                      <?php echo lang('question_solution'); ?>: <span class="option "> <?php echo htmlspecialchars($question_data['solution']); ?></span>
                    </label>
                  </li>
                <?php } ?>
              </ul>
            </ul>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo lang('close'); ?></button>
          </div>

        </div>
      </div>
    </div>
  </div>
  <?php
} ?>

