<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>oop作业</title>
</head>
<body>
	<?php 
	//创建商品类
	class Goods{
		private $name;
		private $price;
		private $remaining_Num;
		protected function __construct($name,$price,$remaining_Num){
			$this->name = $name;
			$this->price = $price;
			$this->remaining_Num = $remaining_Num;
		}
		protected function showInfon(){
			echo "name:".$this->name." price:".$this->price." remaining_Num:".$this->remaining_Num."<br>";
		}
	}
	class Telphone extends Goods{
		private $pinpai;
		private $chandi;
		function __construct($name,$price,$remaining_Num,$pinpai,$chandi){
			parent::__construct($name,$price,$remaining_Num);
			$this->pinpai = $pinpai;
			$this->chandi = $chandi;
		}
		function showInfon(){
			parent:: showInfon();
			echo "pinpai:".$this->pinpai." chandi:".$this->chandi."<br>";
		}
	}
	class Book extends Goods{
		private $author;
		private $press;
		function __construct($name,$price,$remaining_Num,$author,$press){
			parent::__construct($name,$price,$remaining_Num);
			$this->author = $author;
			$this->press = $press;
		}
		function showInfon(){
			parent:: showInfon();
			echo "author:".$this->author." press:".$this->press."<br>";
		}
	}
	$tel = new Telphone('三星-88',888,100,'三星','深圳');
	$book1 = new Book('三体',30,1000,'刘慈欣','清华出版社');
	$tel->showInfon();
	$book1->showInfon();
	 ?>
</body>
</html>