<?php
class Color {
	public $red;
	public $green;
	public $blue;

	public static $verbose = False;
	
	function __construct(array $colors) {
		if (!isset($colors['rgb']) && (!isset($colors['red']) || !isset($colors['green']) || !isset($colors['blue'])))
			return;
		if ($colors['rgb']) {
			$this->red = (int)(($colors['rgb'] >> 16) & 0xFF);
			$this->green = (int)(($colors['rgb'] >> 8) & 0xFF);
			$this->blue  = (int)($colors['rgb'] & 0xFF);
		} else {
			$this->red = (int)$colors['red'];
			$this->green = (int)$colors['green'];
			$this->blue = (int)$colors['blue'];
		}
		if (self::$verbose)
			echo $this . "contructed" . "\n";
	}

	function __destruct() {
		if (self::$verbose)
			echo $this . "destructed" . "\n";
	}

	function __toString() {
		return (sprintf("Color( red: %3d, green: %3d, blue: %3d ) ", $this->red, $this->green, $this->blue));
		
	}
	static function doc() {
        return file_get_contents('Color.doc.txt') . "\n";
    }

	public function add(Color $color) : ?Color {
		$new_color = new Color([
			'red' => $this->red + $color->red,
			'green' => $this->green + $color->green,
			'blue' => $this->blue + $color->blue]);
		return $new_color;
	}

	public function sub(Color $color) : ?Color {
		$new_color = new Color([
			'red' => $this->red - $color->red,
			'green' => $this->green - $color->green,
			'blue' => $this->blue - $color->blue]);
		return $new_color;
	}

	public function mult($f) : ?Color {
		$new_color = new Color([
			'red' => $this->red * $f,
			'green' => $this->green * $f,
			'blue' => $this->blue * $f]);
		return $new_color;
	}
}
?>
