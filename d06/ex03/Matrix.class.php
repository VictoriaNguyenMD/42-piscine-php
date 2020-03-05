<?php
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
    public $matrix = [
        [0.00, 0.00, 0.00, 0.00],
        [0.00, 0.00, 0.00, 0.00],
        [0.00, 0.00, 0.00, 0.00],
        [0.00, 0.00, 0.00, 0.00],
    ];

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
        else if ($data['preset'] === self::RY)
            $this->create_oyrotation($data);
    }

    function __destruct() {
		if (self::$verbose && $data['preset'] === self::IDENTITY)
            echo $this . " instance destructed" . "\n";
        else if (self::$verbose && in_array($data['preset'], [self::IDENTITY, self::SCALE, self::RX, self::RY, self::RZ, self::TRANSLATION, self::PROJECTION]))
            echo "Matrix " . $data['preset'] . " preset instance destructed" . "\n";
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

    function create_identity(array $data)
    {
        $this->matrix = ([
            [1.00, 0.00, 0.00, 0.00],
            [0.00, 1.00, 0.00, 0.00],
            [0.00, 0.00, 1.00, 0.00],
            [0.00, 0.00, 0.00, 1.00],
        ]);
    }

    function create_translation(array $data)
    {
        $this->matrix = ([
            [1.00, 0.00, 0.00, $data['vtc']->get_x()],
            [0.00, 1.00, 0.00, $data['vtc']->get_y()],
            [0.00, 0.00, 1.00, $data['vtc']->get_z()],
            [0.00, 0.00, 0.00, 1.00],
        ]);
    }

    function create_scale(array $data)
    {
        $this->matrix = ([
            [$data['scale'], 0.00, 0.00, 0.00],
            [0.00, $data['scale'], 0.00, 0.00],
            [0.00, 0.00, $data['scale'], 0.00],
            [0.00, 0.00, 0.00, 1.00],
        ]);
    }

    function create_oxrotation(array $data)
    {
        $this->matrix = [
            [1.00, 0.00, 0.00, 0.00],
            [0.00, cos($data['angle']), -sin($data['angle']), 0.00],
            [0.00, sin($data['angle']), cos($data['angle']), 0.00],
            [0.00, 0.00, 0.00, 1.00],
        ];
    }

    function create_oyrotation(array $data)
    {
        $this->matrix = [
            [cos($data['angle']), 0.00, sin($data['angle']), 0.00],
            [0.00, 1.00, 0.00, 0.00],
            [-sin($data['angle']), 0.00, cos($data['angle']), 0.00],
            [0.00, 0.00, 0.00, 1.00],
        ];
    }

    function create_ozrotation(array $data)
    {
        $this->matrix = [
            [cos($data['angle']), -sin($data['angle']), 0.00, 0.00],
            [sin($data['angle']), cos($data['angle']), 0.00, 0.00],
            [0.00, 0.00, 1.00, 0.00],
            [0.00, 0.00, 0.00, 1.00],
        ];
    }

    function create_projection(array $data)
    {
        $this->matrix = $this->create_identity($data);
        $matrix[1][1] = 1 / tan(0.5 * deg2rad($data['fov']));
        $matrix[0][0] = $matrix[1][1] / $data['ratio'];
        $matrix[2][2] = -1 * (-$data['near'] - $data['far']) / ($data['near'] - $data['far']);
        $matrix[2][3] = (2 * $data['near'] * $data['far']) / ($data['near'] - $data['far']);
        $matrix[3][2] = -1;
        $matrix[3][3] = 0;
    }

    // private function _generateTranslationPreset(array $data)
    // {
    //     $this->_generateIdentityPreset($data);
    //     $matrix = $this->get();
    //     $matrix[0][3] = $data['vtc']->get_x();
    //     $matrix[1][3] = $data['vtc']->get_y();
    //     $matrix[2][3] = $data['vtc']->get_z();
    //     $this->set($matrix);
    // }

    // private function _generateProjectionPreset(array $data)
    // {
    //     $this->_generateIdentityPreset($data);
    //     $matrix = $this->get();
    //     $matrix[1][1] = 1 / tan(0.5 * deg2rad($data['fov']));
    //     $matrix[0][0] = $matrix[1][1] / $data['ratio'];
    //     $matrix[2][2] = -1 * (-$data['near'] - $data['far']) / ($data['near'] - $data['far']);
    //     $matrix[2][3] = (2 * $data['near'] * $data['far']) / ($data['near'] - $data['far']);
    //     $matrix[3][2] = -1;
    //     $matrix[3][3] = 0;
    //     $this->set($matrix);
    // }

    // public function set($matrix){
    //     $this->matrix = $matrix;
    // }

    // function get(){
    //     return $this->matrix;
    // }
}
?>