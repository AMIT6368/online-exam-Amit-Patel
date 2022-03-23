<?php
$quiz_running = 'no_quiz_start';
$session_quiz_id = NULL;
$gradients = array();
$gradients[] = 'mask gradient-vue';
$gradients[] = 'mask gradient-angular';
$gradients[] = 'mask gradient-react';
$gradients[] = 'mask gradient-material';
$gradients[] = 'mask gradient-html';
$gradients[] = 'mask gradient-laravel';
$gradients[] = 'mask gradient-react-native';
$gradients[] = 'mask gradient-nuxtjs';

if($session_quiz_data && $session_quiz_question_data) 
{ 
    $quiz_running = 'quiz_running';
    $session_quiz_id = $session_quiz_data['id'];
    echo "<input type='hidden' value='".$session_quiz_id."' class='session_quiz_id'>";        
}

if($quiz_list_data)  
{
    foreach ($quiz_list_data as  $quiz_array) 
    {
        $quiz_id = $quiz_array->id;
        $quiz_url = $session_quiz_id == $quiz_id ?  base_url("test/$session_quiz_id/1") : base_url("instruction/$quiz_id");
        $quiz_btn_name = $session_quiz_id == $quiz_id  ?  lang('resume_test') : lang("start_quiz");
        
         $quiz_running_btn = "";

        $lang_id = get_language_data_by_language($this->session->userdata('language'));
        $translate_quiz_title = get_translated_column_value($lang_id,'quizes',$quiz_id,'title');
        $quiz_title = $translate_quiz_title ? $translate_quiz_title : $quiz_array->title;
        $quiz_title = strlen($quiz_title) > 40 ? substr($quiz_title,0,40)."..." : $quiz_title;
        $quiz_user_name = $quiz_array->first_name.' '.$quiz_array->last_name;
        $quiz_user_name = strlen($quiz_user_name) > 20 ? substr($quiz_user_name,0,20)."..." : $quiz_user_name;
        
        ?>
        <div class="col-xs-6 col-sm-6 col-md-4 col-lg-3"> 
            <div class="card card-bundle" data-turbolinks="false"> 
                <div class="thumbnail"> 
                    <span class="maskk gradient-defaultt <?php echo xss_clean($gradients[mt_rand(0,7)]); ?>"> </span> 
                    <a href="<?php echo xss_clean($quiz_url); ?>" data-url="<?php echo xss_clean($quiz_url); ?>" id="quiz_<?php echo xss_clean($quiz_array->id);?>" class="thumb-cover  <?php echo xss_clean($quiz_running_btn); ?> statrt_quiz_btn" data-quiz_id="<?php echo xss_clean($quiz_array->id);?>" data-toggle="tooltip"  title="<?php  echo lang('start_quiz');?>"> </a>
                    <div class="details card-dark-shadow"> 
                            <div class="framework-logo"> 
                                <p class="quiz_title"> <?php echo xss_clean($quiz_title); ?> </p> 
                                <div class="row quiz_middle_icon">
                                    <div class="col-6 text-center">
                                        <i class="far fa-question-circle"> </i> <br>
                                        <span class="value"><?php echo xss_clean($quiz_array->number_questions); ?> </span> <br>
                                        <?php echo lang('questions') ?>
                                    </div>
                                    <div class="col-6 text-center">
                                        <i class="fas fa-stopwatch"></i>   <br>
                                        <span class="value"><?php echo xss_clean($quiz_array->duration_min); ?></span><br>
                                        <?php echo lang('minutes') ?>
                                    </div>
                                </div>
                            </div> 
                        </div> 

                        <div class="actions"> 
                            <a href="<?php echo xss_clean(base_url('quiz-detail/'.$quiz_id)); ?>" class="title_quiz title-heading"><?php echo xss_clean($quiz_title); ?></a>
                            <a href="<?php echo xss_clean($quiz_url); ?>" data-url="<?php echo xss_clean($quiz_url); ?>" id="quiz_<?php echo xss_clean($quiz_array->id);?>" class="btn btn-neutral btn-fill <?php echo xss_clean($quiz_running_btn); ?> statrt_quiz_btn" data-quiz_id="<?php echo xss_clean($quiz_array->id);?>" data-toggle="tooltip"  title="<?php  echo $start_or_pay;?>">
                            <i class="far fa-play-circle"></i>                
                            </a> 
                            </div> 
                        </div> 
                    </div>
                    <div class="mobile-view">
                        <a href="<?php echo xss_clean($quiz_url); ?>" data-url="<?php echo xss_clean($quiz_url); ?>" id="quiz_<?php echo xss_clean($quiz_array->id);?>" class=" <?php echo xss_clean($quiz_running_btn); ?> statrt_quiz_btn float-left btn btn-primary btn-sm" data-quiz_id="<?php echo xss_clean($quiz_array->id);?>"><i class="far fa-play-circle"></i><?php  echo lang('start_quiz');?> </a>   
                        <a href="<?php echo xss_clean(base_url('quiz-detail/'.$quiz_id)); ?>" class="btn btn-success w-100 mt-4"><?php echo xss_clean($quiz_title); ?></a>
                    </div> 
        </div>
            <?php 
    } 
}
else 
{
    ?>
    <div class="col-12 text-center text-danger"> <?php echo lang('no_quiz_found'); ?></div>
    <?php 
} ?>      