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

            // масив кращих оцінок найкоротший шлях до кожної вершини
            $d = array();
            // Масив попередників для кожної вершини
            $pi = array();
            // Черга з усіх вершин неоптимізованими
            $Q = new SplPriorityQueue();

            foreach ($this->graph as $v => $adj) {
                $d[$v] = INF; // задати початкове відстань до «нескінченності»
                $pi[$v] = null; // немає відомих попередників ще
                foreach ($adj as $w => $cost) {
                    // використовувати вартість край як пріоритет
                    $Q->insert($w, $cost);
                }
            }

            // початкова відстань в джерелі 0
            $d[$source] = 0;

            while (!$Q->isEmpty()) {
                // витягти хв вартість
                $u = $Q->extract();
                if (!empty($this->graph[$u])) {
                    // "розслабитися" кожен суміжний вершину
                    foreach ($this->graph[$u] as $v => $cost) {
                        // Альтернативний маршрут довжиною прилеглої сусіда
                        $alt = $d[$u] + $cost;
                        // якщо альтернативний маршрут коротше
                        if ($alt < $d[$v]) {
                            $d[$v] = $alt; // оновити мінімальну довжину до вершини
                            $pi[$v] = $u;  // додати сусіда попередників для вершини
                        }
                    }
                }
            }

            // Тепер ми можемо знайти найкоротший шлях з використанням зворотного ітерації
            $S = new SplStack(); // найкоротший шлях зі стеком
            $u = $target;
            $dist = 0;
            // пройти від мети до джерела
            while (isset($pi[$u]) && $pi[$u]) {
                $S->push($u);
                $dist += $this->graph[$u][$pi[$u]]; // додати відстань попередникові
                $u = $pi[$u];
            }

            // стек буде порожнім, якщо немає маршрут назад
            if ($S->isEmpty()) {
                $this->distance = false;
            } else {
                // додати вихідний вузол і друкувати шлях у зворотному (ЛІФО) для того
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