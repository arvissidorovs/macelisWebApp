<?php

function trimparam($string) {
    $string = preg_replace('/\s(\S*)$/', '.$1', trim($string)); // trim end for sanitization
    return $string;
}

function getTranslationMapping($tr) {
    $translation_map = [
        "lv65" => "RT65",
        "lsb" => "LSB",
        "kjv" => "KJV"
    ];
    return $translation_map[$tr] ?? $tr;
}

if (isset($_GET['b']) && isset($_GET['c'])) {
    $tr = trimparam($_GET['tr']);
    $b = trimparam($_GET['b']);
    $c = trimparam($_GET['c']);
    
    $tr = substr($tr, 0, 4); // max 4 char
    $b = substr($b, 0, 2); // max 2 char
    $c = substr($c, 0, 3); // max 3 char
    
    $translation = getTranslationMapping($tr);
    
    $servername = "localhost:3306";
    $username = "centradraudze";
    $password = "LcDmirT8!";
    $dbname = "maceklis_DB";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Check connection
    if ($conn->connect_error) {
        http_response_code(500);
        echo json_encode(['error' => 'Database connection failed']);
        exit();
    }

    $v_arr = array();
    //0 pans vieta virsrakstam
    array_push($v_arr, array('v' => 0, 't' => ''));
    
    $sql = "SELECT id, title, html, b, c, v, v_to FROM bible_comments WHERE b = ? AND c = ? ORDER BY b, c, v, v_to";
    
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to prepare SQL statement']);
        exit();
    }
    
    $stmt->bind_param('ss', $b, $c);
    $stmt->execute();
    
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            array_push($v_arr, array('v' => $row["v"], 'v_to' => $row["v_to"], 'title' => $row["title"], 'html' => $row["html"]));
        }
        $stmt->close();
        $conn->close();
        
        $arr = array('b' => $b, 'c' => $c, 'varr' => $v_arr);
        echo json_encode($arr);
    } else {
        $stmt->close();
        $conn->close();
        
        $arr = array('b' => $b, 'c' => $c, 'varr' => []);
        echo json_encode($arr);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Parameters not specified']);
}
?>
