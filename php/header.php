<?php
function trimparam($string) {
    $string = preg_replace('/\s(\S*)$/', '.$1', trim($string));
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

$pageTitle = "Default Title"; // Default title if parameters are not set

// Parse custom URL parameters
$urlPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$pathSegments = explode('/', trim($urlPath, '/'));

if (count($pathSegments) >= 4) {
    $tr = trimparam($pathSegments[1]);
    $b = trimparam($pathSegments[2]);
    $c = trimparam($pathSegments[3]);

    $tr = substr($tr, 0, 4); // max 4 char
    $b = substr($b, 0, 2);   // max 2 char
    $c = substr($c, 0, 3);   // max 3 char

    $translation = getTranslationMapping($tr);
    $pageTitle = "$b $c | $translation | Māceklis";
    echo "<!-- Debug: tr=$tr, b=$b, c=$c, pageTitle=$pageTitle -->";

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

    $sql = "SELECT * FROM t_$tr WHERE b = $b AND c = $c ORDER BY id;";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Process data
        $v_arr = array();
        while($row = $result->fetch_assoc()) {
            $vlen = $row["v"];
            $id = $row["id"];
            array_push($v_arr, array('v' => $row["v"], 't' => $row["t"]));
        }
        $id5 = substr($id, 0, 5);    
        $pageTitle = "$b $c | $translation | Māceklis";
    } else {
        // No results found
        echo "<!-- No results found for the query -->";
    }

    $conn->close();
}
?>

<title><?php echo htmlspecialchars($pageTitle); ?></title>
<meta name="keywords" content="Bībele, Jēzus, Kristus, Māceklis, Mācīties, studēt, study bible" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Nāc, redzi un piedzīvo to savā dzīvē. Dievs dara savu pārveidojošo darbu.">
<meta property="og:title" content="<?php echo htmlspecialchars($pageTitle); ?>">
<meta property="og:url" content="Url">
<meta property="og:site_name" content="<?php echo htmlspecialchars($pageTitle); ?>">