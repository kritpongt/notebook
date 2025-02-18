<? 
class Timer {
    private $startTimes = array();
    private $calls = array();
    private static $depth = 0;
    private $indent = "";

    public function startTimer($functionName, ...$args){
        $this->indent = str_repeat("\t", self::$depth);
        $callId = self::$depth;
        
        $this->startTimes[$callId] = microtime(true);
        $this->calls[$callId] = array(
            'function' => $functionName,
            'args' => $args
        );
        
        echo '<pre>';
        echo $this->indent."START: {$functionName}(".implode(', ', $args).")\n";
        echo '</pre>';
        self::$depth++;
    }

    public function stopTimer(){
        self::$depth--;
        $this->indent = str_repeat("\t", self::$depth);
        $callId = self::$depth;
        
        if(isset($this->startTimes[$callId])){
            $microTime = microtime(true) - $this->startTimes[$callId];
            $executionTime = number_format($microTime * 1000, 4);
            $call = $this->calls[$callId];
            
            echo '<pre>';
            echo $this->indent."END  : {$call['function']}(".
                implode(', ', $call['args']).") - ".$executionTime." ms\n";
            echo '</pre>';
                 
            unset($this->startTimes[$callId]);
            unset($this->calls[$callId]);
            
            return $executionTime;
        }
        return 0;
    }
}

// // Example
// function recursiveFunction($n) {
// 	global $timer;
//     $timer->startTimer('recursiveFunction', $n);
    
//     if ($n <= 1) {
//         $timer->stopTimer();
//         return 1;
//     }
    
//     $result = recursiveFunction($n - 1) + recursiveFunction($n - 2);
//     $timer->stopTimer();
//     return $result;
// }
// $timer = new Timer();
// $result = recursiveFunction(4);
// echo '<pre>\n';
// echo "Result: {$result}\n";
// echo '</pre>';
?>