<?php 
header("Content-Type: text/html; charset=utf-8"); 
session_start();
if ($_SESSION['test'] == $_SERVER['REMOTE_ADDR'])  
{
//Объявляем переменные:
$Name = $Email = $Tel = $Date = $Time = '';
$_SESSION['message'] = ''; 
//Разделитель между записями 
$NewLine = '--------------';
$success = true;
//Name, Email, Tel, Date, Time - названия совпадают с названиями полей <input type="date" name="Date"...
if (!empty($_GET["Name"]) && check_length($_GET["Name"], 1, 16)) 
	$Name = clean($_GET["Name"]);
else {$success = false ; $_SESSION['message'] = 'Неверно указано Имя!'; }

if (filter_var($_GET["Email"], FILTER_VALIDATE_EMAIL) && !empty($_GET["Email"])) 
    $Email = clean($_GET["Email"]); 
else {$success = false ; $_SESSION['message'] = 'Неверно указан Email!'; }

if (check_length($_GET["Tel"], 0, 12)) 
	$Tel = clean($_GET["Tel"]); 
else {$success = false ; $_SESSION['message'] = 'Неверно указан Телефон!'; }

if (check_length($_GET["Date"], 0, 11)) 
	$Date = clean($_GET["Date"]); 
else {$success = false ; $_SESSION['message'] = 'Неверно указана Дата!'; }

if (check_length($_GET["Time"], 0, 6)) 
	$Time = clean($_GET["Time"]); 
else {$success = false ; $_SESSION['message'] = 'Неверно указано Время!'; }

if($success == true)
{
$_SESSION['message'] = 'Ваша запись успешно занесена в базу, мы вам обязательно перезвоним!'; 
//Открываем файл для записи 
$fp  = fopen('commentfile.txt', 'a+'); 
//Записываем построчно каждое значение из полей формы
fwrite($fp, $NewLine."\n");
fwrite($fp, $Name."\n"); 
fwrite($fp, $Email."\n"); 
fwrite($fp, $Tel."\n"); 
fwrite($fp, $Date."\n"); 
fwrite($fp, $Time."\n");
//Закрываем файл
fclose($fp); 
}
}
else {$_SESSION['message'] = 'Доступ закрыт.';}
//Не относится к основному функционалу, необходимо для возвращения на обратно на страницу после выполнения программы. 
$back = $_SERVER['HTTP_REFERER']; 
echo "
<html>
  <head>
   <meta http-equiv='Refresh' content='0; URL=".$_SERVER['HTTP_REFERER']."'>
  </head>
</html>";
?>

<?php
function clean($value = "") {
    $value = trim($value);
    $value = stripslashes($value);
    $value = strip_tags($value);
    $value = htmlspecialchars($value);    
    return $value;
}
?>

<?php
function check_length($value = "", $min, $max) {
    $result = (mb_strlen($value) < $min || mb_strlen($value) > $max);
    return !$result;
}
?>