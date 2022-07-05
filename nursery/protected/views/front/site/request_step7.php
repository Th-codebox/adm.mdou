<?php $this->pageTitle=Yii::app()->name; ?>

<h1>Заполнение заявления</h1>
<div class="bar">&nbsp;</div>

<h3>Ваше заявление добавлено в информационную систему «Дошкольник».</h3><br/>

Регистрационный номер заявления: <b><?php echo $model->reg_number; ?></b><br/>

Ваш пароль: <b><?php echo $user->password_unencrypted; ?></b><br/>

Скопируйте  и сохраните свой логин и пароль для последующего просмотра информации о Вашем заявлении в разделе «Моя очередь».<br/>

<div class=”bar”>&nbsp;</div><br/>

<a target="_blank" href="reportRequest?id=<?php echo $model->id; ?>" >Просмотреть версию заявления для печати</a><br/><br/>

<h3><b>В течение 10 (десяти) рабочих дней Вы должны обратиться в комиссию по комплектованию для предъявления оригиналов документов. </b><br/>
Адрес: Петрозаводск, пр. Ленина, д. 2, каб.426. <br/>
Режим работы: с 09.00 до 17.00, перерыв - с 13.00 до 14.00. <br/>
 </h3>