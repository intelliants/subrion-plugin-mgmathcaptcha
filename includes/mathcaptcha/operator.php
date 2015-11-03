<?php

class Operator
{
	var $rangeOperator;
	var $Operator;

	function __construct($rangeOperator)
	{
		$this->rangeOperator = $rangeOperator;
	}

	function generate_operator()
	{
		$operator = $this->rangeOperator;
		$op=substr($operator, mt_rand(0, strlen($operator)-1), 1);

		$this->Operator=$op;
	}
}