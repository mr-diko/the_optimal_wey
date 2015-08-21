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

            $d = array();
            $pi = array();
            $Q = new SplPriorityQueue();

            foreach ($this->graph as $v => $adj) {
                $d[$v] = INF;
                $pi[$v] = null;
                foreach ($adj as $w => $cost) {
                    $Q->insert($w, $cost);
                }
            }

            $d[$source] = 0;

            while (!$Q->isEmpty()) {
                $u = $Q->extract();
                if (!empty($this->graph[$u])) {
                    foreach ($this->graph[$u] as $v => $cost) {
                        $alt = $d[$u] + $cost;
                        if ($alt < $d[$v]) {
                            $d[$v] = $alt;
                            $pi[$v] = $u;
                        }
                    }
                }
            }

            $S = new SplStack();
            $u = $target;
            $dist = 0;
            while (isset($pi[$u]) && $pi[$u]) {
                $S->push($u);
                $dist += $this->graph[$u][$pi[$u]];
                $u = $pi[$u];
            }

            if ($S->isEmpty()) {
                $this->distance = false;
            } else {
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