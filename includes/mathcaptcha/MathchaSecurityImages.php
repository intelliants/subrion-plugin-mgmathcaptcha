<?php

//there is three level of difficulty: easy, moderate, hard
//class easy have 2 operaand and 1 operator, the range of operand is 1-10
class easy
{
	var $expression="";			//@param $expression : MathCha math question
	var $security_code="";		//@param $security_code : answer of MathCha
	var $a="";					//@param $a : first number
	var $b="";					//@param $b : operator
	var $c="";					//@param $c : second number
	function __construct()
	{
		$this->expression = $expression;
		$this->security_code = $security_code;
		$this->a = $a;
		$this->b = $b;
		$this->c = $c;
	}
	//this function generate number, generate operator, and calculate the answer
	function result()
	{
		//generate first number
		$number1 = new Operand(1,10);
		$number1->generate_number();

		//generate second number
		$number2 = new Operand(1,10);
		$number2->generate_number();

		//generate operator
		$operator = new Operator('+-');
		$operator->generate_operator();

		//calculate result
		$a= $number1->number;
		$b= $operator->Operator;
		$c= $number2->number;
		if ($b=='+')
		{
			$d= $a + $c;
		}
		if ($b=='-')
		{
			$d= $a - $c;
		}

		$this->expression =$a.$b.$c;
		$this->security_code=$d;
		$this->a = $a;
		$this->b = $b;
		$this->c = $c;
	}

}

//class moderate have 2 operand and 1 operator, the range of operand is 10-50
class moderate
{
	var $expression="";
	var $security_code="";
	var $a="";
	var $b="";
	var $c="";
	function __construct()
	{
		$this->expression = $expression;
		$this->security_code = $security_code;
		$this->a = $a;
		$this->b = $b;
		$this->c = $c;
	}
	//this function generate number, generate operator, and calculate the answer
	function result()
	{
		//generate first number
		$number1 = new Operand(10,50);
		$number1->generate_number();

		//generate second number
		$number2 = new Operand(10,50);
		$number2->generate_number();

		//generate operator
		$operator = new Operator('+-*');
		$operator->generate_operator();

		//calculate result
		$a= $number1->number;
		$b= $operator->Operator;
		$c= $number2->number;
		if ($b=='+')
		{
			$d= $a + $c;
		}
		if ($b=='-')
		{
			$d= $a - $c;
		}
		if ($b=='*')
		{
			$d= $a * $c;
		}

		$this->expression =$a.$b.$c;
		$this->security_code=$d;
		$this->a = $a;
		$this->b = $b;
		$this->c = $c;
	}
}
	
//class hard have 3 operand and 2 operator, the range of operand is 1-10
class hard
{
	var $expression="";
	var $security_code="";
	var $a="";
	var $b="";
	var $c="";
	var $d="";
	var $e="";

	function __construct()
	{
		$this->expression = $expression;
		$this->security_code = $security_code;
		$this->a = $a;
		$this->b = $b;
		$this->c = $c;
		$this->d = $d;
		$this->e = $e;
	}
	//this function generate number, generate operator, and calculate the answer
	function result()
	{
		//generate first number
		$number1 = new Operand(1,10);
		$number1->generate_number();

		//generate second number
		$number2 = new Operand(1,10);
		$number2->generate_number();

		//generate third number
		$number3 = new Operand(1,10);
		$number3->generate_number();

		//generate first operator
		$operator1 = new Operator('+-*');
		$operator1->generate_operator();

		//generate second operator
		$operator2= new Operator('+-*');
		$operator2->generate_operator();

		//calculate result
		$a= $number1->number;
		$b= $operator1->Operator;
		$c= $number2->number;
		$d= $operator2->Operator;
		$e= $number3->number;
		if ($b=='+')
		{
			$temp= $a + $c;
		}
		if ($b=='-')
		{
			$temp= $a - $c;
		}
		if ($b=='*')
		{
			$temp= $a * $c;
		}

		if ($d=='+')
		{
			$result= $temp + $e;
		}
		if ($d=='-')
		{
			$result= $temp - $e;
		}
		if ($d=='*')
		{
			$result= $temp * $e;
		}

		$this->expression =$a.$b.$c.$d.$e;
		$this->security_code=$result;
		$this->a = $a;
		$this->b = $b;
		$this->c = $c;
		$this->d = $d;
		$this->e = $e;
	}
}

//this class use to create images of Math expression
class MathChaSecurityImages
{
	//function to create images
	function MathChaSecurityImages($difficulty,$theme)
	{
		//size of images
		$width= 150;
		$height= 40;
		//font size
		$min_font_size = 12;
		$max_font_size = 14;
		//angel for rotation
		$angle = 20;
		
		//difficult level of Math expression
		if($difficulty=='1')
		{
			$result = new easy();
			$result->result();
			$a=$result->a;
			$b=$result->b;
			$c=$result->c;
			$answer=$result->security_code;
		}
		if($difficulty=='2')
		{
			$result = new moderate();
			$result->result();
			$a=$result->a;
			$b=$result->b;
			$c=$result->c;
			$answer=$result->security_code;
		}
		if($difficulty=='3')
		{
			$result = new hard();
			$result->result();
			$a=$result->a;
			$b=$result->b;
			$c=$result->c;
			$d=$result->d;
			$e=$result->e;
			$answer=$result->security_code;
		}
		
		//theme for captcha images
		if($theme=='t0') {
            $bg = 'bg0.png';
			$color='';
            }
		else if($theme=='t1'){
            $bg = 'bg1.png';
			}
		else if($theme=='t2') {
            $bg = 'bg2.png';
			$color='';
            }
        else if($theme=='t3') {
            $bg = 'bg3.png';
            }
        else if($theme=='t4') {
            $bg = 'bg4.png';
            }
		else if($theme=='t5') {
            $bg= 'bg5.png';
            }
        else if($theme=='t6') {
            $bg= 'bg6.png';
            }
        else if($theme=='t7') {
            $bg= 'bg7.png';
            }
        else if($theme=='t8') {
            $bg= 'bg8.png';
            }
        else if($theme=='t9') {
            $bg = 'bg9.png';
            }
        else if($theme=='t10') {
            $bg = 'bg10.png';
            }
			
      	//code for create images	
		$image = @imagecreate($width, $height) or die('Cannot initialize new GD image stream');
        $name = $bg;
        $image = imagecreatefrompng($name);
		$font_path = 'comic.ttf';
		if($difficulty=='1')
		{	
			$item_space = 35;
			imagettftext($image,rand($min_font_size,$max_font_size),rand( -$angle , $angle ),rand( 10,item_space-5 ),$height,$black,$font_path,$a);
			imagettftext($image,rand($min_font_size,$max_font_size),rand( -$angle , $angle ),rand( $item_space, 2*$item_space-5 ),$height,$black,$font_path,$b);
			imagettftext($image,rand($min_font_size,$max_font_size),rand( -$angle , $angle ),rand( 2*$item_space, 3*$item_space-5 ),$height,$black,$font_path,$c);		
		
		}
		if($difficulty=='2')
		{	
			$item_space = 50;
			imagettftext($image,rand($min_font_size,$max_font_size),rand( -$angle , $angle ),rand( 10, $item_space-30 ),$height,$black,$font_path,$a);
			imagettftext($image,rand($min_font_size,$max_font_size),rand( -$angle , $angle ),rand( $item_space, 2*$item_space-30 ),$height,$black,$font_path,$b);
			imagettftext($image,rand($min_font_size,$max_font_size),rand( -$angle , $angle ),rand( 2*$item_space, 3*$item_space-20 ),$height,$black,$font_path,$c);
		
		
		}
		if($difficulty=='3')
		{	
			$item_space = 25;
			imagettftext($image,rand($min_font_size,$max_font_size),rand( -$angle , $angle ),rand( 10, $item_space-5 ),$height,$black,$font_path,$a);
			imagettftext($image,rand($min_font_size,$max_font_size),rand( -$angle , $angle ),rand( $item_space, 2*$item_space-5 ),$height,$black,$font_path,$b);
			imagettftext($image,rand($min_font_size,$max_font_size),rand( -$angle , $angle ),rand( 2*$item_space, 3*$item_space-5 ),$height,$black,$font_path,$c);
			imagettftext($image,rand($min_font_size,$max_font_size),rand( -$angle , $angle ),rand( 3*$item_space, 4*$item_space-5 ),$height,$black,$font_path,$d);
			imagettftext($image,rand($min_font_size,$max_font_size),rand( -$angle , $angle ),rand( 4*$item_space, 5*$item_space-5 ),$height,$black,$font_path,$e);
		
		}
			header('Content-Type: image/jpeg');
			imagejpeg($image);
			imagedestroy($image);
		//save the answer of math expression to 'security_code' session
		$_SESSION['security_code'] = $answer;
	}
}

$difficulty = isset($_GET['difficulty']) ? $_GET['difficulty'] : '1';
$theme = isset($_GET['theme']) ? $_GET['theme'] : 't1';

//create new class
$captcha = new MathChaSecurityImages($difficulty,$theme);