<?php

class Operand
{
	var $number;
	var $first;
	var $second;

	function __construct($first,$second)
	{
		$this->number = "0";
		$this->first = $first;
		$this->second = $second;
	}

	function generate_number()
	{
		$first=$this->first;
		$second=$this->second;
		$a=rand ($first,$second);

		$this->number= $a;
	}
}