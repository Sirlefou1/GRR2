<?php
class Form {

	private $_data;

	public function __construct($data = [])
	{
		$this->_data = $data;
	}

	private function input($type, $name, $label)
	{
		$value = "";
		if (isset($this->_data[$name]))
			$value = $this->_data[$name];
		$input = "";
		if ($type == "textarea")
			$input = '<textarea class="form-control" rows="3" id="'.$name.'">'.$value.'</textarea>'.PHP_EOL;
		else
			$input = '<input type="'.$type.'" class="form-control" id="'.$name.'" placeholder="'.$label.'" value="'.$value.'">'.PHP_EOL;
		return '<div class="form-group">'.PHP_EOL.'<label for="'.$name.'">'.$label.'</label>'.PHP_EOL.$input.'</div>'.PHP_EOL;

	}

	public function text($name, $label)
	{
		return $this->input('text', $name, $label);
	}

	public function mail($name, $label)
	{
		return $this->input('mail', $name, $label);
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
			if (isset($this->_data[$name]))
			{
				if ($k == $this->_data[$name])
					$select = ' selected';
			}
			$option .= '<option value="'.$k.'" '.$select.'>'.$v.'</option>'.PHP_EOL;
		}
		$input = '<select id="'.$name.'" class="form-control" '.$type.'>'.PHP_EOL.$option.'</select>'.PHP_EOL;
		return '<div class="form-group">'.PHP_EOL.'<label for="'.$name.'">'.$label.'</label>'.PHP_EOL.$input.'</div>'.PHP_EOL;
	}
}
?>
