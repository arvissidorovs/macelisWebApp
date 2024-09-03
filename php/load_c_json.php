<?php
session_start(); // Start or resume session

// Function to sanitize and trim input parameters
function trimparam($string) {
    $string = preg_replace('/\s(\S*)$/', '.$1', trim($string)); // Trim end for sanitization
    return $string;
}

// Function to map translations
function getTranslationMapping($tr) {
    $translation_map = [
        "lv65" => "RT65",
        "lsb" => "LSB",
        "kjv" => "KJV"
    ];
    return $translation_map[$tr] ?? $tr;
}

// Check if required parameters are set
if (isset($_GET['tr']) && isset($_GET['b']) && isset($_GET['c'])) {
    $tr = trimparam($_GET['tr']);
    $b = trimparam($_GET['b']);
    $c = trimparam($_GET['c']);

    // Limit parameters to specified lengths
    $tr = substr($tr, 0, 4); // Max 4 char
    $b = substr($b, 0, 2);   // Max 2 char
    $c = substr($c, 0, 3);   // Max 3 char

    $translation = getTranslationMapping($tr);
    $pageTitle = "$b $c | $translation | Māceklis";

    // Database connection parameters
    $servername = "localhost:3306";
    $username = "centradraudze";
    $password = "LcDmirT8!";
    $dbname = "maceklis_DB";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $v_arr = array();
    array_push($v_arr, array('v' => 0, 't' => '')); // Placeholder for chapter title

    // Check if user is authenticated
    $user_id = $_SESSION['user_id'] ?? null;

    // Prepare SQL query to fetch verses and colors
    if ($user_id) {
        // User is authenticated, fetch colored verses for this user
        $sql = "
        SELECT t.v, t.t, vc.color
        FROM `t_".$tr."` t
        LEFT JOIN `verse_colors` vc ON t.id = vc.verse_id AND vc.user_id = ".$user_id."
        WHERE t.b = ".$b." AND t.c = ".$c."
        ORDER BY t.id;
        ";
    } else {
        // User is not authenticated, fetch verses without colors
        $sql = "
        SELECT v, t
        FROM `t_".$tr."`
        WHERE b = ".$b." AND c = ".$c."
        ORDER BY id;
        ";
    }

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $vlen = $row["v"];
            $verse_entry = array('v' => $row["v"], 't' => $row["t"]);

            if ($user_id && !is_null($row["color"])) {
                $verse_entry['color'] = $row["color"];
            }

            array_push($v_arr, $verse_entry);
        }

        $id5 = isset($row["id"]) ? substr($row["id"], 0, 5) : ''; // Adjust based on your table structure
        $arr = array(
            'tr' => $tr,
            'b' => $b,
            'c' => $c,
            'id5' => $id5,
            'vlen' => $vlen,
            'varr' => $v_arr
        );

        echo json_encode($arr);
    } else {
        echo json_encode(array('b' => -1)); // No results found
    }

    $conn->close();
} else {
    echo 'nav norādīti parametri'; // Parameters not provided
}
?>
