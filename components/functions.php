<?php
require_once '../config/db.php';
global $conn;

function ConsoleLog($_data) //allows to make JS-like console logs in PHP
{
    echo '<script>';
    echo 'console.log(' . json_encode($_data) . ');';
    echo '</script>';
}

//Shape related information
$shapeTypes = ["circle", "triangle", "square", "pentagon", "hexagon"];
$shapeBorders = ["#000000", "#FFFFFF", '#FFD700'];
$fetchAbilities = $conn->query('SELECT ability_id FROM abilities');
if ($fetchAbilities) {
    $all_rows = $fetchAbilities->fetch_all(MYSQLI_ASSOC);
    $shapeAbilities = array_column($all_rows, 'ability_id');
    $fetchAbilities->free();
}

function CreateShape() //creates new level 1 shape and adds it to the database
{
    global $conn, $shapeTypes, $shapeBorders, $shapeAbilities;

    $shapeType = $shapeTypes[array_rand($shapeTypes)];
    $outerColour = $shapeBorders[array_rand($shapeBorders)];
    $innerColour = "#" . substr('00000' . dechex(mt_rand(0, 0xffffff)), -6);
    $firstAbility = $shapeAbilities[array_rand($shapeAbilities)];
    $shapeLevel = 1;
    $trading = 0;

    try {
        $sql = 'INSERT INTO shapes (shape, border_colour, fill_colour, shape_level, trading, shape_ability) VALUES (?, ?, ?, ?, ?, ?)';

        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            throw new Exception('DB error: ' . $conn->error);
        }

        $stmt->bind_param('sssiii', $shapeType, $outerColour, $innerColour, $shapeLevel, $trading, $firstAbility);

        if (!$stmt->execute()) {
            throw new Exception('Shape creation failed: ' . $stmt->error);
        }

        $shapeId = $conn->insert_id;

        $stmt->close();

        return $shapeId;
    } catch (Exception $exception) {
        return false;
    }
}

function FetchShape($_shapeID) //used to go get a shape's information as an object
{
    global $conn;

    $sql = "SELECT * FROM shapes WHERE shape_id = $_shapeID";

    $result = $conn->query($sql);

    if ($fetchShape = $result->fetch_object()) {
        ConsoleLog($fetchShape);
        return $fetchShape;
    } else {
        ConsoleLog("Shape not found...");
    }
}


function updateShapeLevel($_shapeID, $_level) {}
