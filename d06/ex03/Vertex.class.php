<?php
require_once('Color.class.php');

class Vertex {
    private $_x;
    private $_y;
    private $_z;
    private $_w = 1.0;
    private $_color;

    public static $verbose = False;

    function __construct($data) {
        if (!isset($data['x']) || !isset($data['y']) || !isset($data['z']))
            return;
        if (!isset($data['color']))
            $this->_color = new Color(['red' => 255, 'green' => 255, 'blue' => 255]);
        else 
            $this->_color = $data['color'];
       
        $this->_x = $data['x'];
        $this->_y = $data['y'];
        $this->_z = $data['z'];

        if (isset($data['w']))
            $this->_w = $data['w'];

        if (self::$verbose)
			echo $this . "contructed" . "\n";
    }

    function __destruct() {
		if (self::$verbose)
			echo $this . "destructed" . "\n";
	}

    function __toString() {
        $output = (sprintf("Vertex( x: %.2f, y: %.2f, z:%.2f, w:%.2f", $this->_x, $this->_y, $this->_z, $this->_w));
        if (isset($this->_color) && self::$verbose)
            $output .= ", " . $this->_color;
        $output .= " ) ";
        return $output;
    }
    
	static function doc() {
        return file_get_contents('Vertex.doc.txt') . "\n";
    }

    function get_x()
    {
        return $this->_x;
    }

    function set_x($x)
    {
        $this->_x = $x;
    }

    function get_y()
    {
        return $this->_y;
    }

    function set_y($y)
    {
        $this->_y = $y;
    }

    function get_z()
    {
        return $this->_z;
    }

    function set_z($z)
    {
        $this->_z = $z;
    }

    function get_w()
    {
        return $this->_w;
    }

    function set_w($w)
    {
        $this->_w = $w;
    }

    function get_color()
    {
        return $this->_color;
    }

    function set_color(Color $color)
    {
        $this->_color = $color;
    }
}
?>