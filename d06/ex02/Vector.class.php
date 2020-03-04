<?php
require_once('Vertex.class.php');

class Vector {
    private $_x = 0;
    private $_y = 0;
    private $_z = 0;
    private $_w = 0;

    public static $verbose = False;

    function __construct($data) {
        if (!isset($data['dest']))
            return;
        if (!isset($data['orig']))
            $data['orig'] = new Vector(['x' => 0, 'y' => 0, 'z' => 0, 'w' => 1]);

        $this->_x = $data['dest']->get_x() - $data['orig']->get_x();
        $this->_y = $data['dest']->get_y() - $data['orig']->get_y();
        $this->_z = $data['dest']->get_z() - $data['orig']->get_z();
        
        if (self::$verbose)
			echo $this . " contructed" . "\n";
    }

    function __destruct() {
		if (self::$verbose)
			echo $this . " destructed" . "\n";
	}

    function __toString() {
        $output = sprintf("Vector( x:%.2f, y:%.2f, z:%.2f, w:%.2f )", $this->_x, $this->_y, $this->_z, $this->_w);
        return $output;
    }
    
	static function doc() {
        return file_get_contents('Vector.doc.txt') . "\n";
    }

    function get_x() {
        return $this->_x;
    }

    function get_y() {
        return $this->_y;
    }

    function get_z() {
        return $this->_z;
    }

    function get_w() {
        return $this->_w;
    }

    function magnitude() : float {
        $sqare_sum = ($this->_x * $this->_x) + ($this->_y * $this->_y) + ($this->_z * $this->_z);
        return sqrt($sqare_sum);
    }

    function normalize() : Vector {
        $mag = $this->magnitude();
        if ($mag == 1)
            return clone $this;
        $new_vector = new Vector(array('dest' => new Vertex(array('x' => $this->_x / $mag, 'y' => $this->_y / $mag, 'z' => $this->_z / $mag))));
        return $new_vector;
    }

    function add(Vector $rhs) : Vector {
        $x = $this->_x + $rhs->get_x();
        $y = $this->_y + $rhs->get_y();
        $z = $this->_z + $rhs->get_z();
        return new Vector(array('dest' => new Vertex(array('x' => $x, 'y' => $y, 'z' => $z))));
    }

    function sub(Vector $rhs) : Vector {
        $x = $this->_x - $rhs->get_x();
        $y = $this->_y - $rhs->get_y();
        $z = $this->_z - $rhs->get_z();
        return new Vector(array('dest' => new Vertex(array('x' => $x, 'y' => $y, 'z' => $z))));
    }

    function opposite() : Vector {
        $x = $this->_x * -1;
        $y = $this->_y * -1;
        $z = $this->_z * -1;
        return new Vector(array('dest' => new Vertex(array('x' => $x, 'y' => $y, 'z' => $z))));
    }
    
    function scalarProduct($k) : Vector {
        $x = $this->_x * $k;
        $y = $this->_y * $k;
        $z = $this->_z * $k;
        return new Vector(array('dest' => new Vertex(array('x' => $x, 'y' => $y, 'z' => $z))));
    }

    function dotProduct(Vector $rhs) : float {
        $mult_add = $this->_x * $rhs->get_x() + $this->_y * $rhs->get_y() + $this->_z * $rhs->get_z();
        return $mult_add;
    }

    function cos(Vector $rhs) : float {
        return $this->dotProduct($rhs) / ($this->magnitude() * $rhs->magnitude());
    }
    
    function crossProduct(Vector $rhs) {
        $x = ($this->_x * $rhs->get_x()) - ($this->_x * $rhs->get_x());
        $y = ($this->_y * $rhs->get_y()) - ($this->_y * $rhs->get_y());
        $z = ($this->_z * $rhs->get_z()) - ($this->_z * $rhs->get_z());
        return new Vector(array('dest' => new Vertex(array('x' => $x, 'y' => $y, 'z' => $z))));
    }
}
?>