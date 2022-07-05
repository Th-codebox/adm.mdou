<?php

/**
 * Класс специальных функций
 */
class Util
{
	public static function getRussianMonthName($month)
	{
		if (strlen($month) == 2 && substr($month, 0, 1) == '0')
			$month = substr($month, 1, 1);

		$months = Util::getRussianMonthOptions();
		if (!isset($months[$month]))
			throw new CException("Неверный номер месяца: $month");
		return $months[$month];
	}
	
	public static function getRussianMonthOptions()
	{
		return array(
			1 => "января",
			2 => "февраля",
			3 => "марта",
			4 => "апреля",
			5 => "мая",
			6 => "июня",
			7 => "июля",
			8 => "августа",
			9 => "сентября",
			10=> "октября",
			11=> "ноября",
			12=> "декабря",			
		);
	}
	
	/*
	 * Возвращает список доступных возрастных интервалов
	 */
	public static function getAgeOptions()
	{
		return array(
			0 => 'до года',
			1 => '1 год',
			2 => '2 года',
			3 => '3 года',
			4 => '4 года',
			5 => '5 лет',
			6 => '6 лет',
			7 => '7 лет',
			8 => 'старше 7 лет',
		);	
	}
	
	/*
	 * Преобразование первой буквы строки в заглавную
	 */
	public static function ucfirst($str)
	{
		return mb_strtoupper( mb_substr( $str, 0, 1, 'UTF-8' ), 'UTF-8' ) . mb_substr( $str, 1, mb_strlen( $str ), 'UTF-8' );
	}
	
	/*
	 * Отправка e-mail
	 */
	public static function sendEmail($email, $subject, $text)
	{
		$from = 'noreply@mdou.petrozavodsk-mo.ru';
//		$from = 'noreply@mmedia9.soros.karelia.ru';
		
		$headers = "Content-type: text/html; charset=utf-8 \r\n";
		$headers .= "From: {$from}\r\nReply-To: {$from}";
		$subject = "=?utf-8?B?" . base64_encode($subject) . "?=";
		
		return mail($email, $subject, $text, $headers);
	}
	
}
