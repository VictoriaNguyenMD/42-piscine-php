<?php
require_once('Vertex.class.php');
class Matrix {
    const IDENTITY = 'IDENTITY';
    const SCALE = 'SCALE';
    const RX = 'Ox ROTATION';
    const RY = 'Oy ROTATION';
    const RZ = 'Oz ROTATION';
    const TRANSLATION = 'TRANSLATION';
    const PROJECTION = 'PROJECTION';

    private $_preset;
    private $_scale;
    private $_angle;
    private $_vtc;
    private $_fov;
    private $_ratio;
    private $_near;
    private $_far;

    public $data;
    public static $verbose = False;
    public $matrix;

    function __construct($data) {
        if (!isset($data['preset']) || 
            !in_array($data['preset'], [self::IDENTITY, self::SCALE, self::RX, self::RY, 
                                        self::RZ, self::TRANSLATION, self::PROJECTION]))
            return;
        if ($data['preset'] === self::SCALE && !isset($data['scale']))
            return false;
        if (in_array($data['preset'], [self::RY, self::RX, self::RZ]) && !isset($data['angle']))
            return false;
        if ($data['preset'] === self::TRANSLATION && !isset($data['vtc']))
            return false;
        if ($data['preset'] === self::PROJECTION && (!isset($data['fov']) || !isset($data['ratio']) || !isset($data['near']) || !isset($data['far'])))
            return false;

        if (self::$verbose && $data['preset'] === self::IDENTITY)
            echo "Matrix " . $data['preset'] . " instance contructed" . "\n";
        else if (self::$verbose && in_array($data['preset'], [self::IDENTITY, self::SCALE, self::RX, self::RY, self::RZ, self::TRANSLATION, self::PROJECTION]))
            echo "Matrix " . $data['preset'] . " preset instance contructed" . "\n";

        $this->data = $data;
        if ($data['preset'] === self::IDENTITY)
            $this->create_identity($data);
        else if ($data['preset'] === self::SCALE)
            $this->create_scale($data);
        else if ($data['preset'] === self::PROJECTION)
            $this->create_projection($data);
        else if ($data['preset'] === self::TRANSLATION)
            $this->create_translation($data);
        else if ($data['preset'] === self::RX)
            $this->create_oxrotation($data);
        else if ($data['preset'] === self::RY)
            $this->create_oyrotation($data);
        else if ($data['preset'] === self::RZ)
            $this->create_ozrotation($data);
    }

    function __destruct() {
		if (self::$verbose)
            echo "Matrix instance destructed\n";
	}

    function __toString() {
        $output = "M | vtcX | vtcY | vtcZ | vtxO\n";
        $output .= "-----------------------------\n";
        $output .= "x | %0.2f | %0.2f | %0.2f | %0.2f\n";
        $output .= "y | %0.2f | %0.2f | %0.2f | %0.2f\n";
        $output .= "z | %0.2f | %0.2f | %0.2f | %0.2f\n";
        $output .= "w | %0.2f | %0.2f | %0.2f | %0.2f";
            return (sprintf($output, $this->matrix[0][0], $this->matrix[0][1], $this->matrix[0][2], $this->matrix[0][3], 
                                    $this->matrix[1][0], $this->matrix[1][1], $this->matrix[1][2], $this->matrix[1][3], 
                                    $this->matrix[2][0], $this->matrix[2][1], $this->matrix[2][2], $this->matrix[2][3],  
                                    $this->matrix[3][0], $this->matrix[3][1], $this->matrix[3][2], $this->matrix[3][3]));
    }
    
	static function doc() {
        return file_get_contents('Matrix.doc.txt') . "\n";
    }

    function create_identity(array $data) {
        $this->matrix = ([
            [1.00, 0.00, 0.00, 0.00],
            [0.00, 1.00, 0.00, 0.00],
            [0.00, 0.00, 1.00, 0.00],
            [0.00, 0.00, 0.00, 1.00],
        ]);
    }

    function create_translation(array $data) {
        $this->matrix = ([
            [1.00, 0.00, 0.00, $data['vtc']->get_x()],
            [0.00, 1.00, 0.00, $data['vtc']->get_y()],
            [0.00, 0.00, 1.00, $data['vtc']->get_z()],
            [0.00, 0.00, 0.00, 1.00],
        ]);
    }

    function create_scale(array $data) {
        $this->matrix = ([
            [$data['scale'], 0.00, 0.00, 0.00],
            [0.00, $data['scale'], 0.00, 0.00],
            [0.00, 0.00, $data['scale'], 0.00],
            [0.00, 0.00, 0.00, 1.00],
        ]);
    }

    function create_oxrotation(array $data) {
        $this->matrix = [
            [1.00, 0.00, 0.00, 0.00],
            [0.00, cos($data['angle']), -sin($data['angle']), 0.00],
            [0.00, sin($data['angle']), cos($data['angle']), 0.00],
            [0.00, 0.00, 0.00, 1.00],
        ];
    }

    function create_oyrotation(array $data) {
        $this->matrix = [
            [cos($data['angle']), 0.00, sin($data['angle']), 0.00],
            [0.00, 1.00, 0.00, 0.00],
            [-sin($data['angle']), 0.00, cos($data['angle']), 0.00],
            [0.00, 0.00, 0.00, 1.00],
        ];
    }

    function create_ozrotation(array $data) {  
        $this->matrix = [
            [cos($data['angle']), -sin($data['angle']), 0.00, 0.00],
            [sin($data['angle']), cos($data['angle']), 0.00, 0.00],
            [0.00, 0.00, 1.00, 0.00],
            [0.00, 0.00, 0.00, 1.00],
        ];
    }

    function create_projection(array $data) {
        $test = ([
            [0.00, 0.00, 0.00, 0.00],
            [0.00, 0.00, 0.00, 0.00],
            [0.00, 0.00, 0.00, 0.00],
            [0.00, 0.00, -1.00, 0.00],
        ]);
        $test[0][0] = (1 / tan(0.5 * deg2rad($data['fov']))) / $data['ratio'];
        $test[1][1] = 1 / tan(0.5 * deg2rad($data['fov']));
        $test[2][2] = -1 * ($data['far'] + $data['near']) / ($data['far'] - $data['near']);
        $test[2][3] = (-2 * $data['far'] * $data['near']) / ($data['far'] - $data['near']);
        $this->matrix = $test;
    }

    function mult(Matrix $rhs) {
        $test = array();

        $test[0][0] = ($this->matrix[0][0] * $rhs->matrix[0][0]) + ($this->matrix[0][1] * $rhs->matrix[1][0]) + ($this->matrix[0][2] * $rhs->matrix[2][0]) + ($this->matrix[0][3] * $rhs->matrix[3][0]);
        $test[0][1] = ($this->matrix[0][0] * $rhs->matrix[0][1]) + ($this->matrix[0][1] * $rhs->matrix[1][1]) + ($this->matrix[0][2] * $rhs->matrix[2][1]) + ($this->matrix[0][3] * $rhs->matrix[3][1]);
        $test[0][2] = ($this->matrix[0][0] * $rhs->matrix[0][2]) + ($this->matrix[0][1] * $rhs->matrix[1][2]) + ($this->matrix[0][2] * $rhs->matrix[2][2]) + ($this->matrix[0][3] * $rhs->matrix[3][2]);
        $test[0][3] = ($this->matrix[0][0] * $rhs->matrix[0][3]) + ($this->matrix[0][1] * $rhs->matrix[1][3]) + ($this->matrix[0][2] * $rhs->matrix[2][3]) + ($this->matrix[0][3] * $rhs->matrix[3][3]);
  
        $test[1][0] = ($this->matrix[1][0] * $rhs->matrix[0][0]) + ($this->matrix[1][1] * $rhs->matrix[1][0]) + ($this->matrix[1][2] * $rhs->matrix[2][0]) + ($this->matrix[1][3] * $rhs->matrix[3][0]); 
        $test[1][1] = ($this->matrix[1][0] * $rhs->matrix[0][1]) + ($this->matrix[1][1] * $rhs->matrix[1][1]) + ($this->matrix[1][2] * $rhs->matrix[2][1]) + ($this->matrix[1][3] * $rhs->matrix[3][1]);
        $test[1][2] = ($this->matrix[1][0] * $rhs->matrix[0][2]) + ($this->matrix[1][1] * $rhs->matrix[1][2]) + ($this->matrix[1][2] * $rhs->matrix[2][2]) + ($this->matrix[1][3] * $rhs->matrix[3][2]);
        $test[1][3] = ($this->matrix[1][0] * $rhs->matrix[0][3]) + ($this->matrix[1][1] * $rhs->matrix[1][3]) + ($this->matrix[1][2] * $rhs->matrix[2][3]) + ($this->matrix[1][3] * $rhs->matrix[3][3]);

        $test[2][0] = ($this->matrix[2][0] * $rhs->matrix[0][0]) + ($this->matrix[2][1] * $rhs->matrix[1][0]) + ($this->matrix[2][2] * $rhs->matrix[2][0]) + ($this->matrix[2][3] * $rhs->matrix[3][0]);
        $test[2][1] = ($this->matrix[2][0] * $rhs->matrix[0][1]) + ($this->matrix[2][1] * $rhs->matrix[1][1]) + ($this->matrix[2][2] * $rhs->matrix[2][1]) + ($this->matrix[2][3] * $rhs->matrix[3][1]);
        $test[2][2] = ($this->matrix[2][0] * $rhs->matrix[0][2]) + ($this->matrix[2][1] * $rhs->matrix[1][2]) + ($this->matrix[2][2] * $rhs->matrix[2][2]) + ($this->matrix[2][3] * $rhs->matrix[3][2]);
        $test[2][3] = ($this->matrix[2][0] * $rhs->matrix[0][3]) + ($this->matrix[2][1] * $rhs->matrix[1][3]) + ($this->matrix[2][2] * $rhs->matrix[2][3]) + ($this->matrix[2][3] * $rhs->matrix[3][3]);
        
        $test[3][0] = ($this->matrix[3][0] * $rhs->matrix[0][0]) + ($this->matrix[3][1] * $rhs->matrix[1][0]) + ($this->matrix[3][2] * $rhs->matrix[2][0]) + ($this->matrix[3][3] * $rhs->matrix[3][0]);
        $test[3][1] = ($this->matrix[3][0] * $rhs->matrix[0][1]) + ($this->matrix[3][1] * $rhs->matrix[1][1]) + ($this->matrix[3][2] * $rhs->matrix[2][1]) + ($this->matrix[3][3] * $rhs->matrix[3][1]);
        $test[3][2] = ($this->matrix[3][0] * $rhs->matrix[0][2]) + ($this->matrix[3][1] * $rhs->matrix[1][2]) + ($this->matrix[3][2] * $rhs->matrix[2][2]) + ($this->matrix[3][3] * $rhs->matrix[3][2]);
        $test[3][3] = ($this->matrix[3][0] * $rhs->matrix[0][3]) + ($this->matrix[3][1] * $rhs->matrix[1][3]) + ($this->matrix[3][2] * $rhs->matrix[2][3]) + ($this->matrix[3][3] * $rhs->matrix[3][3]);
        $new_matrix = new Matrix(array('present' => 'IDENTITY'));
        $new_matrix->matrix = $test;
        return $new_matrix;
    }

    function transformVertex(Vertex $vtx) {
        $x = (($vtx->get_x() * $this->matrix[0][0]) + ($vtx->get_y() * $this->matrix[0][1])  + ($vtx->get_z() * $this->matrix[0][2])  + ($vtx->get_w() * $this->matrix[0][3]) );
        $y = (($vtx->get_x() * $this->$matrix[1][0]) + ($vtx->get_y() * $this->$matrix[1][1]) + ($vtx->get_z() * $this->$matrix[1][2]) + ($vtx->get_w() * $this->$matrix[1][3]) );
        $z = (($vtx->get_x() * $this->$matrix[2][0]) + ($vtx->get_y() * $this->$matrix[2][1]) + ($vtx->get_z() * $this->$matrix[2][2]) + ($vtx->get_w() * $this->$matrix[2][3]) );
        $w = (($vtx->get_x() * $this->$matrix[3][0]) + ($vtx->get_y() * $this->$matrix[3][1]) + ($vtx->get_z() * $this->$matrix[3][2]) + ($vtx->get_w() * $this->$matrix[3][3]) );
        $color = $vtx->get_color();
        $new_vertex = new Vertex(array('x' => $x, 'y' => $y, 'z' => $z, 'w' => $w, 'color' => $color));
        return $new_vertex;
    }
}
?>