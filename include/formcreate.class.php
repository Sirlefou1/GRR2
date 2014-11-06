<?php
class Form {

	private $_data;

	public function __construct($data = [])
	{
		$this->_data = $data;
	}

	private function input($type, $name, $label)
	{
		$input = "";
		if ($type == "textarea")
			$input = '<textarea class="form-control" rows="3" id="input'.$name.'">'.$this->_data[$name].'</textarea>'.PHP_EOL;
		else
			$input = '<input type="'.$type.'" class="form-control" id="input'.$name.'" placeholder="'.$label.'" value="'.$this->_data[$name].'">'.PHP_EOL;
		return '<div class="form-group">'.PHP_EOL.'<label for="input'.$name.'">'.$label.'</label>'.PHP_EOL.$input.'</div>'.PHP_EOL;

	}

	public function text($name, $label)
	{
		return $this->input('text', $name, $label);
	}

	public function email($name, $label)
	{
		return $this->input('email', $name, $label);
	}

	public function textarea($name, $label)
	{
		return $this->input('textarea', $name, $label);
	}

	public function submit($label)
	{
		return '<button type="submit" class="btn btn-primary">'.$label.'</button>'.PHP_EOL;
	}

	public function select($type, $name, $label, $options)
	{
		$option = "";
		foreach ($options as $k => $v)
		{
			$select = '';
			if ($k == $this->_data[$name])
				$select = ' selected';
			$option .= '<option value="'.$k.'" '.$select.'>'.$v.'</option>'.PHP_EOL;
		}
		$input = '<select class="form-control" '.$type.'>'.PHP_EOL.$option.'</select>'.PHP_EOL;
		return '<div class="form-group">'.PHP_EOL.'<label for="input'.$name.'">'.$label.'</label>'.PHP_EOL.$input.'</div>'.PHP_EOL;
	}
}
?>
