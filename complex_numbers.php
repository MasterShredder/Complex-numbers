<?php

class complex_numbers
{
	public $number_1;
	public $operation;
	public $number_2;

	public function __construct($number_1 = 0, $operation = '', $number_2 = 0)
	{
		$this->number_1 = $number_1;
		$this->operation = $operation;
		$this->number_2 = $number_2;
	}

	public function parse_numbers()
	{
		if (!in_array($this->operation, array('+', '-', '*', '/')))
		{
			echo 'Incorrect operation.';
			exit();
		}

		$this->number_1 = str_replace(array(' ', ','), array('', '.'), $this->number_1);
		$this->number_2 = str_replace(array(' ', ','), array('', '.'), $this->number_2);

		$regexp = "/^(-?\d*(?:\.\d+)?)?([+-]?(\d*(?:\.\d+)?)i)?$/Ui";

		// Используется preg_match_all вместо preg_match, чтобы в массивах вседа было одинаковое число элементов.
		preg_match_all($regexp, $this->number_1, $match_1);
		preg_match_all($regexp, $this->number_2, $match_2);

		if (empty($match_1[0]) || empty($match_2[0]) || $match_1[0][0] == '' || $match_2[0][0] == '')
		{
			echo 'Invalid number(s).';
			exit();
		}

		$this->real_1 = (float) $match_1[1][0];
		$this->imaginary_1 = (float) (($match_1[3][0] == '') ? str_replace('i', '1', $match_1[2][0]) : $match_1[2][0]);
		$this->real_2 = (float) $match_2[1][0];
		$this->imaginary_2 = (float) (($match_2[3][0] == '') ? str_replace('i', '1', $match_2[2][0]) : $match_2[2][0]);
	}

	public function addition()
	{
		$this->real = $this->real_1 + $this->real_2;
		$this->imaginary = $this->imaginary_1 + $this->imaginary_2;
	}

	public function subtraction()
	{
		$this->real = $this->real_1 - $this->real_2;
		$this->imaginary = $this->imaginary_1 - $this->imaginary_2;
	}

	public function multiplication()
	{
		$this->real = $this->real_1 * $this->real_2 - $this->imaginary_1 * $this->imaginary_2;
		$this->imaginary = $this->imaginary_1 * $this->real_2 + $this->imaginary_2 * $this->real_1;
	}

	public function division()
	{
		$denominator = $this->real_2 * $this->real_2 + $this->imaginary_2 * $this->imaginary_2;

		if (!$denominator)
		{
			echo 'Division by zero is not allowed.';
			exit();
		}
		else
		{
			$this->real = ($this->real_1 * $this->real_2 + $this->imaginary_1 * $this->imaginary_2) / $denominator;
			$this->imaginary = ($this->imaginary_1 * $this->real_2 - $this->imaginary_2 * $this->real_1) / $denominator;
		}
	}

	public function show_result()
	{
		$this->parse_numbers();

		switch ($this->operation)
		{
			case '+':
				$this->addition();
			break;

			case '-':
				$this->subtraction();
			break;

			case '*':
				$this->multiplication();
			break;

			case '/':
				$this->division();
			break;
		}

		$imaginary = sprintf('%' . (($this->real) ? '+' : '') . 'gi', $this->imaginary);

		if (abs($this->imaginary) == 1)
		{
			$imaginary = str_replace('1', '', $imaginary);
		}

		$number = (($this->real) ? sprintf('%g', $this->real) : '') . (($this->imaginary) ? $imaginary : '');

		return ($number) ? $number : 0;
	}
}
