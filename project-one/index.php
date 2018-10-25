 <?php
/**
 * Created by PhpStorm.
 * User: dray6
 * Date: 16.10.2018
 * Time: 07:36
 */


//  Write the application name
echo "
\n################################################################
\n######################### SYSTEM LOGIN #########################
\n################################################################";

// Show the available manu
$menus =array(
    "neu Benutzer erstellen",
    "Read all user", 
    "Show total users" ,
    "Delete the user", 
    "Exit"
);

echo "\nSelect the menu";
foreach($menus as $menuNo => $menu){
    echo "\n " .  $menuNo . "  =>  " .  $menu;
}

// print space 
echo("\n\n");

// get the user 
$menuSelected = readline("Enter the menu No\n");

switch($menuSelected){
    case 0 : 
        // New user
        createNewUser();
        break;
    case 1 :
        // show all User
        showAllUsers();
        break;
    case 2 : 
        // Exit
        showTotalUsersCount();
        break;
    case 3 : 
        // Exit
        deleteTheUserForName();
        break;        
    case 4 : 
        // Exit
        printBeautifulText("GOOD BYE");
        break; }

/* 
    FUNCTIONS 
*/
function printBeautifulText($cotent){
    echo "\n*************************  " . $cotent . "  ***********************";
}


function fileIsExist() : bool{
    if (file_exists('users.json')) {
         return true;
    } else {
        $userdata = [];
        echo "There is no file..";
        return false;
    }
}

function createNewUser(){
    $usersArray = readUsersFromJsonFileAsArray();
    $name = readline("Please enter your name to create new user!");
    if(!empty($name)){
        $arrne['name'] = $name;
        array_push($usersArray, $arrne );
        file_put_contents('users.json', json_encode($usersArray));
        printBeautifulText("SUCCESFULLY CREATED");
    }else{
        printBeautifulText("Sorry, Name can not be empty");
    }
    
}

function readUsersFromJsonFileAsArray() : array{
    $usersJson = file_get_contents('users.json');
    $usersArray = json_decode($usersJson, true);
    
    return $usersArray;
}

function showTotalUsersCount(){
    $usersArray = readUsersFromJsonFileAsArray();
    printBeautifulText("TOTAL USERS = " . count($usersArray));
}

function showAllUsers(){
    $usersArray = readUsersFromJsonFileAsArray();
    foreach($usersArray as $no => $name){
        echo "\n " .  $no . "  =>  " .  $name['name'];
    }
}

function deleteTheUserForName(){
    $name = readline("Please enter your name to delete! -   ");
    if(!empty($name)){
        $usersArray = readUsersFromJsonFileAsArray();

        //here we search for the element of the array using the value #NOT KEY ---
        if(($key = array_search($name, array_column($usersArray, 'name'))) !== false) {
            // Remove found element from the array
            unset($usersArray[$key]);


            file_put_contents('users.json', json_encode($usersArray));
        }else{
            printBeautifulText("Sorry, No any user with this name");
        }
    }else{
        printBeautifulText("Sorry, Name can not be empty");
    }
}

function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE) {
    $output = NULL;
    if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
        $ip = "46.14.53.1";
        if ($deep_detect) {
            if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
    }
    $purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
    $support    = array("country", "countrycode", "state", "region", "city", "location", "address");
    $continents = array(
        "AF" => "Africa",
        "AN" => "Antarctica",
        "AS" => "Asia",
        "EU" => "Europe",
        "OC" => "Australia (Oceania)",
        "NA" => "North America",
        "SA" => "South America"
    );
    if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
        $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
        if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
            switch ($purpose) {
                case "address":
                    $address = array($ipdat->geoplugin_countryName);
                    if (@strlen($ipdat->geoplugin_regionName) >= 1)
                        $address[] = $ipdat->geoplugin_regionName;
                    if (@strlen($ipdat->geoplugin_city) >= 1)
                        $address[] = $ipdat->geoplugin_city;
                    $output = implode(", ", array_reverse($address));
                    break;
                case "city":
                    $output = @$ipdat->geoplugin_city;
                    break;
                case "state":
                    $output = @$ipdat->geoplugin_regionName;
                    break;
                case "region":
                    $output = @$ipdat->geoplugin_regionName;
                    break;
                case "country":
                    $output = @$ipdat->geoplugin_countryName;
                    break;
                case "countrycode":
                    $output = @$ipdat->geoplugin_countryCode;
                    break;
            }
        }
    }
    return $output;
}










?>






