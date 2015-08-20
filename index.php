<?php include "script.php";
    $db = new DB();
    $nods = $db->getNodes();
    if(isset($_POST['go'])) {
        $from = $_POST['from'];
        $to = $_POST['to'];
        $g = new Dijkstra($nods, $from, $to);

        if($g->distance) {
            $unit = ($_POST['unit'] == 'distance') ? 'км' : 'хв';
            $result = "Найкоротший шлях: " . $g->vey. ' | ' . $g->distance . $unit;
        } else {
            $result = "Виберіть інший маршрут.";
        }
    }

?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Оптимальний маршрут</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="wrapper">
        <div id="FormWrapper">
            <h3>Оптимальний маршрут</h3>
            <form action="" method="post">
                <table>
                    <tr>
                        <td>
                            <label for="from">Виберіть пункт відправлення</label>
                            <br>
                            <?php Show::select($nods, 'from'); ?>
                        </td>
                        <td>
                            <label for="from">Виберіть пункт призначення</label>
                            <br>
                            <?php echo Show::select($nods, 'to') ?>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <div><label for="distance"><input type="radio" name="unit" value="distance" id="distance" <?php Show::checked('distance') ?> >км</label></div>
                            <div><label for="time"><input type="radio" name="unit" value="time" id="time" <?php Show::checked('time') ?>>хв</label></div>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" value="Порахувати" name="go"></td>
                    </tr>
                </table>
            </form>
            <p class= "result">
                <?php
                if(isset($_POST['go']))
                    echo $result;
                ?>
            </p>
        </div>
    </div>
</body>
</html>