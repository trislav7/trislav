<?php
class Dumper {
    public static function _dump($var, $depth = 5) {
        echo '<style>
            .dump-container { 
                background: #1a1a2e; 
                color: #00b7c2; 
                padding: 15px; 
                margin: 10px 0; 
                border-radius: 5px; 
                border-left: 4px solid #00b7c2;
                font-family: "Courier New", monospace;
                font-size: 14px;
                overflow: auto;
            }
            .dump-type { color: #ff6b6b; font-weight: bold; }
            .dump-key { color: #4ecdc4; }
            .dump-string { color: #a8e6cf; }
            .dump-number { color: #ffd93d; }
            .dump-boolean { color: #6c5ce7; }
            .dump-null { color: #fd79a8; }
        </style>';
        
        echo '<div class="dump-container">';
        self::render($var, $depth);
        echo '</div>';
    }
    
    private static function render($var, $depth, $level = 0) {
        if ($depth <= 0) {
            echo '<span class="dump-type">...</span>';
            return;
        }
        
        $type = gettype($var);
        
        switch ($type) {
            case 'boolean':
                echo '<span class="dump-boolean">' . ($var ? 'true' : 'false') . '</span>';
                break;
                
            case 'integer':
            case 'double':
                echo '<span class="dump-number">' . $var . '</span>';
                break;
                
            case 'string':
                echo '<span class="dump-string">"' . htmlspecialchars($var) . '"</span>';
                break;
                
            case 'NULL':
                echo '<span class="dump-null">null</span>';
                break;
                
            case 'array':
                echo '<span class="dump-type">array</span>(' . count($var) . ') [<br>';
                foreach ($var as $key => $value) {
                    echo str_repeat('  ', $level + 1);
                    echo '<span class="dump-key">' . $key . '</span> => ';
                    self::render($value, $depth - 1, $level + 1);
                    echo '<br>';
                }
                echo str_repeat('  ', $level) . ']';
                break;
                
            case 'object':
                echo '<span class="dump-type">object</span>(' . get_class($var) . ') {<br>';
                $reflection = new ReflectionObject($var);
                foreach ($reflection->getProperties() as $property) {
                    $property->setAccessible(true);
                    echo str_repeat('  ', $level + 1);
                    echo '<span class="dump-key">' . $property->getName() . '</span> => ';
                    self::render($property->getValue($var), $depth - 1, $level + 1);
                    echo '<br>';
                }
                echo str_repeat('  ', $level) . '}';
                break;
                
            default:
                echo '<span class="dump-type">' . $type . '</span>';
        }
    }
}

// Глобальные функции-хелперы
//if (!function_exists('dump')) {
    function dump(...$vars) {
        foreach ($vars as $var) {
            Dumper::_dump($var);
        }
    }
//}

//if (!function_exists('d')) {
    function d(...$vars) {
        foreach ($vars as $var) {
            Dumper::_dump($var);
        }
        exit;
    }
//}
