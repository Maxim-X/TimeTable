<?php 
$_monthsList = array(
"1"=>"Январь","2"=>"Февраль","3"=>"Март",
"4"=>"Апрель","5"=>"Май", "6"=>"Июнь",
"7"=>"Июль","8"=>"Август","9"=>"Сентябрь",
"10"=>"Октябрь","11"=>"Ноябрь","12"=>"Декабрь");
?>

<section id="menu_top">
  <div class="manu_top">
    <div class="content_sec_menu">
      <div class="data_time_web">
        <span class="img"><img src="/resources/images/icon/clock.svg" alt="clock"></span>
        <span class="time" id="time"><span id="hours"><?=date("H");?></span>:<span id="min"><?=date("i");?></span></span>
        <span class="date" id="date"><?=date("d");?> <?=$_monthsList[date("n")];?></span>
      </div>
    </div>
    <div class="content_sec_menu">
      <div class="full_name_inst"><?=Institution::$FULL_NAME;?></div>
      <!-- <div class="main_search">
          <div class="img">
            <div class="all_icon_search">
              <img src="/resources/images/icon/loupe.svg" alt="loupe">
              <img src="/resources/images/icon/cancel.svg" alt="cancel" name="clean_big_search">
            </div>
          </div>
        <div class="input_search"><input type="text" name="main_search" placeholder="Глобальный поиск..."></div>
      </div> -->
    </div>
    <div class="content_sec_menu">
      <div class="user_name">
        <div class="user">
          <div class="name"><?=Account::$SURNAME;?> <?=Account::$NAME;?> <?=Account::$MIDDLENAME;?></div>
          <div class="role"><?=Account::$AFFILIATION;?></div>
        </div>
        <div class="avatar">
          <div class="letter"><?=mb_substr(Account::$NAME, 0, 1);?></div>
        </div>
      </div>
    </div>
  </div>
</section>