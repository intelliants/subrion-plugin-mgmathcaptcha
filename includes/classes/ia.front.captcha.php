<?php
/******************************************************************************
 *
 * Subrion - open source content management system
 * Copyright (C) 2017 Intelliants, LLC <https://intelliants.com>
 *
 * This file is part of Subrion.
 *
 * Subrion is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Subrion is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Subrion. If not, see <http://www.gnu.org/licenses/>.
 *
 *
 * @link https://subrion.org/
 *
 ******************************************************************************/

class iaCaptcha extends abstractUtil
{
	var $width, $height, $min_font_size, $max_font_size, $difficulty, $theme, $path;

	public function __construct()
	{
		$iaCore = iaCore::instance();

		// font size
		$this->width = $iaCore->get('mgmathcaptcha_width');
		$this->height = $iaCore->get('mgmathcaptcha_height');

		// font size
		$this->min_font_size = $iaCore->get('mgmathcaptcha_min_font_size');
		$this->max_font_size = $iaCore->get('mgmathcaptcha_max_font_size');

		// get difficulty
		$this->difficulty = $iaCore->get('mgmathcaptcha_difficulty');

		$this->path = dirname(__FILE__) . IA_DS . '../mathcaptcha' . IA_DS;

		// theme for captcha images
		$this->theme = $this->path . 'bg' . $iaCore->get('mgmathcaptcha_theme') . '.png';

		// init auxilary classes
		require_once $this-> path . 'operand.php';
		require_once $this-> path . 'operator.php';
	}

	public function getImage()
	{
		$url = IA_URL . 'mgmathcaptcha/';

		$html = "<img id=\"captcha_image_1\" src=\"{$url}\" onclick=\"$('#captcha_image_1').attr('src', '{$url}&amp;h=' + Math.random())\" title=\"" . iaLanguage::get('mgmath_redraw_captcha') .
			"\" alt=\"captcha\" style=\"cursor:pointer; margin-right: 10px;\" align=\"left\" />" . iaLanguage::get('mgmath_text_captcha');
		$html .= "<br><input type=\"text\" class=\"span1\" name=\"security_code\" maxlength=\"3\" size=\"2\" id=\"securityCode\" /><br>" . iaLanguage::get('mgmath_redraw_captcha');

		return $html;
	}

	public function validate()
	{
		$result = false;

		if ($_SESSION['security_code'] == $_POST['security_code'] && !empty($_SESSION['security_code']))
		{
			unset($_SESSION['security_code']);
			$result = true;
		}

		return $result;
	}

	public function getPreview()
	{
		return self::getImage();
	}

	public function MathChaSecurityImages()
	{
		// angle for rotation
		$angle = 20;

		//difficult level of Math expression
		$result = new $this->difficulty();

		$result->result();

		$a = $result->a;
		$b = $result->b;
		$c = $result->c;
		$answer = $result->security_code;

		if ('hard' == $this->difficulty)
		{
			$d = $result->d;
			$e = $result->e;
		}

		//code for create images
		$image = @imagecreate($this->width, $this->height) or die('Cannot initialize new GD image stream');
		$name = $this->theme;
		$image = imagecreatefrompng($name);
		$font_path = $this-> path . 'comic.ttf';

		if ($this->difficulty == 'easy')
		{
			$item_space = 35;
			imagettftext($image,rand($this->min_font_size,$this->max_font_size),rand( -$angle , $angle ),rand( 10, $item_space - 5 ),$this->height,$black,$font_path,$a);
			imagettftext($image,rand($this->min_font_size,$this->max_font_size),rand( -$angle , $angle ),rand( $item_space, 2 * $item_space-5 ),$this->height,$black,$font_path,$b);
			imagettftext($image,rand($this->min_font_size,$this->max_font_size),rand( -$angle , $angle ),rand( 2*$item_space, 3*$item_space-5 ),$this->height,$black,$font_path,$c);

		}

		if ($this->difficulty == 'moderate')
		{
			$item_space = 50;
			imagettftext($image,rand($this->min_font_size,$this->max_font_size),rand( -$angle , $angle ),rand( 10, $item_space-30 ),$this->height,$black,$font_path,$a);
			imagettftext($image,rand($this->min_font_size,$this->max_font_size),rand( -$angle , $angle ),rand( $item_space, 2*$item_space-30 ),$this->height,$black,$font_path,$b);
			imagettftext($image,rand($this->min_font_size,$this->max_font_size),rand( -$angle , $angle ),rand( 2*$item_space, 3*$item_space-20 ),$this->height,$black,$font_path,$c);


		}

		if ($this->difficulty == 'hard')
		{
			$item_space = 25;
			imagettftext($image,rand($this->min_font_size,$this->max_font_size),rand( -$angle , $angle ),rand( 10, $item_space-5 ),$this->height,$black,$font_path,$a);
			imagettftext($image,rand($this->min_font_size,$this->max_font_size),rand( -$angle , $angle ),rand( $item_space, 2*$item_space-5 ),$this->height,$black,$font_path,$b);
			imagettftext($image,rand($this->min_font_size,$this->max_font_size),rand( -$angle , $angle ),rand( 2*$item_space, 3*$item_space-5 ),$this->height,$black,$font_path,$c);
			imagettftext($image,rand($this->min_font_size,$this->max_font_size),rand( -$angle , $angle ),rand( 3*$item_space, 4*$item_space-5 ),$this->height,$black,$font_path,$d);
			imagettftext($image,rand($this->min_font_size,$this->max_font_size),rand( -$angle , $angle ),rand( 4*$item_space, 5*$item_space-5 ),$this->height,$black,$font_path,$e);

		}
		header('Content-Type: image/jpeg');
		imagejpeg($image);
		imagedestroy($image);

		//save the answer of math expression to 'security_code' session
		$_SESSION['security_code'] = $answer;
	}
}


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