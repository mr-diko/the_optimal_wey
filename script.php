<?php
class DB {
    public $db;
    protected $unit;

    public function __construct(){
        try{
            $this->db = new PDO('mysql:host=127.0.0.1;dbname=optimal_rout', 'root', 'root');
        }catch (PDOException $ex){
            echo "Виникла проблема при зєднанні з базою даних: ".$ex->getMessage();
        }
    }

    public function getNodes() {
        $this->unit = (isset($_POST['unit'])) ? $_POST['unit'] : 'distance';
        $sql = 'select `first node`, `second node`, distance, time from the_wey';
        $pdostmt = $this->db->query($sql);
        $ret = [];
        while($r = $pdostmt->fetch(PDO::FETCH_ASSOC)){
            $ret[$r['first node']][$r['second node']] = $r[$this->unit];
        }

        return $ret;
    }
}

class Show{
    public static function select($nods, $name) {
        echo "<select name=\"{$name}\" id=\"{$name}\">";
        foreach ($nods as $key => $val) {
            if(isset($_POST[$name]) && $key == $_POST[$name]){
                echo "<option value=\"" . $key . "\" selected>" . $key . "</option>";
            }else{
                echo "<option value=\"" . $key . "\">" . $key . "</option>";
            }
        }

        echo "</select>";
    }

    public static function checked($name) {
        if(!isset($_POST['unit']) && $name == 'distance') {
            echo 'checked';
        }elseif(isset($_POST['unit']) && $_POST['unit'] == $name) {
            echo 'checked';
        }
    }
}

class Dijkstra {
    protected $graph;

    public $distance = null;
    public $vey = null;

    public function __construct($nods, $source, $target) {
            $this->graph = $nods;

            // array of best estimates of shortest path to each vertex
            $d = array();
            // array of predecessors for each vertex
            $pi = array();
            // queue of all unoptimized vertices
            $Q = new SplPriorityQueue();

            foreach ($this->graph as $v => $adj) {
                $d[$v] = INF; // set initial distance to "infinity"
                $pi[$v] = null; // no known predecessors yet
                foreach ($adj as $w => $cost) {
                    // use the edge cost as the priority
                    $Q->insert($w, $cost);
                }
            }

            // initial distance at source is 0
            $d[$source] = 0;

            while (!$Q->isEmpty()) {
                // extract min cost
                $u = $Q->extract();
                if (!empty($this->graph[$u])) {
                    // "relax" each adjacent vertex
                    foreach ($this->graph[$u] as $v => $cost) {
                        // alternate route length to adjacent neighbor
                        $alt = $d[$u] + $cost;
                        // if alternate route is shorter
                        if ($alt < $d[$v]) {
                            $d[$v] = $alt; // update minimum length to vertex
                            $pi[$v] = $u;  // add neighbor to predecessors
                            //  for vertex
                        }
                    }
                }
            }

            // we can now find the shortest path using reverse
            // iteration
            $S = new SplStack(); // shortest path with a stack
            $u = $target;
            $dist = 0;
            // traverse from target to source
            while (isset($pi[$u]) && $pi[$u]) {
                $S->push($u);
                $dist += $this->graph[$u][$pi[$u]]; // add distance to predecessor
                $u = $pi[$u];
            }

            // stack will be empty if there is no route back
            if ($S->isEmpty()) {
                $this->distance = false;
            } else {
                // add the source node and print the path in reverse
                // (LIFO) order
                $S->push($source);
                $sep = '';
                $output = '';
                foreach ($S as $v) {
                    $output .= "{$sep} {$v}";
                    $sep = '->';
                }
                $this->distance = $dist;
                $this->vey = $output;
            }
        }
}