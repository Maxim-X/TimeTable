<section id="left_menu">
   <div class="left_menu">
     <div class="logo">
       <img src="/resources/images/LogoBig.svg" alt="TimeTable Logo">
     </div>
     <nav>
       <div class="elem_menu">
       <?php if (Account::$ACCOUNT_TYPE == 3): ?>
          <div class="name_sec_menu">Меню администратора</div>
         <li><a href="/"><div class="sec_menu"><img src="/resources/images/icon/copy.svg"><span>Панель администратора</span></div></a></li>
         <div class="line_sec_menu"></div>
         <li><a href="/teachers"><div class="sec_menu"><img src="/resources/images/icon/user.svg"><span>Таблица преподавателей</span></div></a></li>
         <li><a href="/lessons"><div class="sec_menu"><img src="/resources/images/icon/earth.svg"><span>Все учебные предметы</span></div></a></li>
         <div class="line_sec_menu"></div>
         <li><a href="/groups-all"><div class="sec_menu"><img src="/resources/images/icon/group.svg"><span>Таблица групп</span></div></a></li>
         <!-- <li><a href="/files-all"><div class="sec_menu"><img src="/resources/images/icon/paste.svg"><span>Ваши файлы</span></div></a></li> -->
         <li><a href="/schedule"><div class="sec_menu"><img src="/resources/images/icon/copy.svg"><span>Расписание для групп</span></div></a></li>
         <div class="line_sec_menu"></div>
         <li><a href="/timeline"><div class="sec_menu"><img src="/resources/images/icon/wall-clock.svg"><span>Временные графики</span></div></a></li>
         <li><a href="/replacing/<?=date('Y');?>-<?=date('m');?>"><div class="sec_menu"><img src="/resources/images/icon/exchange.svg"><span>Календарь замен занятий</span></div></a></li>
        <?php endif; ?>
        <?php if (Account::$ACCOUNT_TYPE == 1 || Account::$ACCOUNT_TYPE == 2): ?>
          <div class="name_sec_menu">Меню пользователя</div>
         <li><a href="/"><div class="sec_menu"><img src="/resources/images/icon/copy.svg"><span>Расписание</span></div></a></li>
        <?php endif; ?>
       <li><a href="/login/?exit="><div class="sec_menu exit_sec_menu"><img src="/resources/images/icon/close.svg"><span>Выйти из аккаунта</span></div></a></li>
     </div>
     </nav>
   </div>
</section>