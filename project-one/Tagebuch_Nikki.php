<?php
/**
 *
 * Created by PhpStorm.
 * User: dray6
 * Date: 16.10.2018
 * Time: 07:36
 */
if (file_exists('Eintraege.json')) {

    $json = file_get_contents('Eintraege.json');
    $eintraege = json_decode($json, JSON_OBJECT_AS_ARRAY);

} else {

    $eintraege = [[]];
}
$menue = [
    [
        'Login',
        'Benutzereinstellungen',],
    [
        'Eintrag erfassen',
        'Einträge auflisten',
        'Eintrag anzeigen',
        'Einträge bearbeiten'
        ,'Einträge löschen',
        'IP tracken',
        'Zurück',
        'x'=> 'Beenden'],
    [
        "Neuer Benutzer",
        "Benutzer auflisten",
        "Anzahl Benutzer anzeigen" ,
        "Benutzer löschen",
        "Zurück",
        'x'=> 'Beenden'
        ]
];

while (true) {

    foreach ($menue[0] as $value => $item){

        print "[$value]"."$item"."\n";

    }

    trennen();
    echo 'Ihre Wahl:';

    do {
        $temp = readline();
    }while (!preg_match('#^(0|1)$#',$temp));

    trennen();

    if ($temp == 0){


        echo 'Benutzername :';
        do {
            $temp = readline();
            $c = 0;
            $larray = readUsersFromJsonFileAsArray();
            foreach ($larray as $value => $item){
                if (array_search($temp,$item)){
                    $benutzer = $c;
                }
                $c++;
            }


        } while (preg_match('/^$/',$benutzer));

        echo "\n";




        do {

            foreach ($menue[1] as $value => $item) {
                print "[$value] $item \n";
            }

            do {
                $wahl = readline();
            }while (!preg_match('#^[0123456x]$#',$wahl));


            switch ($wahl) {

                case 'x':

                    exit();

                case 0:
                    //Eintrag erfassen

                    trennen();

                    echo 'Sie haben Eintrag erfassen gewählt' . "\n" . 'Jetzt ist' . "\n";

                    $gettime = time();
                    $datum = date("d.m.Y", $gettime);
                    echo $datum . "\n";

                    $gettime = time();
                    $uhrzeit = date("H:i", $gettime);
                    echo $uhrzeit."\n";

                    do {
                        print "Welches Datum ist heute[dd.mm.yyyy]?\n";
                        $date = readline();
                        if (empty($date)) {
                            $date = $datum;
                        }
                    } while (!preg_match('/^[0-9]{2}\.[0-9]{2}\.[0-9]{4}$/', $date));


                    do {
                        print "Welche Uhrtzeit ist gerade?\n";
                        $time = readline();
                        if (preg_match('/^$/', $time)) {
                            $time = $uhrzeit;
                        }
                    } while (!preg_match('/^[012][0-9]\:[0123456][0-9]$/', $time));

                    $eintrag[] = $date;
                    $eintrag[] = $time;


                    print "Aussentemperatur:?\n";
                    $heutigeaussentemepratur = readline();
                    $eintrag[]= $heutigeaussentemepratur;

                    print "Wie ist ihr heutiger Stuhlgang?\n";
                    $heutigerstuhlgang = readline();
                    $eintrag[] = $heutigerstuhlgang;

                    echo 'Eintrag:' . "\n" . "\n";
                    $doku = readline();
                    $eintrag[] = $doku;

                    if (janein('Einträge speichern')) {
                        $eintraege[$benutzer][] = $eintrag;
                        //benutzer wird später definiert
                        $json = json_encode($eintraege);
                        file_put_contents('Eintraege.json', $json);

                    }

                    //Alle Antworten müssen noch gespeichert werden

                    break;

                case 1:
                    //Einträge auflisten
                    trennen();
                    foreach ($eintraege[$benutzer] as $value => $item) {

                        print "\n" . "[$value] " . "\n" . $item[0] . "\n" . $item[1] . "\n";
                    }

                    break;

                case 2:
                    //Eintrag anzeigen

                    trennen();
                    echo 'Eintrag Nr:';
                    $temp = readline();
                    foreach ($eintraege[$benutzer][$temp] as $value => $item) {
                        echo $item . "\n";
                    }

                    echo "\n";

                    break;

                case 3:
                    //Einträge bearbeiten
                    trennen();

                    $temp = readUsersFromJsonFileAsArray('Eintrag NR.');

                    $datum = $eintraege[$benutzer][$temp][0];
                    echo $datum . "\n";

                    $uhrzeit = $eintraege[$benutzer][$temp][1];
                    echo $uhrzeit."\n";

                    do {
                        print "Welches Datum wollen sie[dd.mm.yyyy]?\n";
                        $date = readline();
                        if (empty($date)) {
                            $date = $datum;
                        }
                    } while (!preg_match('/^[0-9]{2}\.[0-9]{2}\.[0-9]{4}$/', $date));


                    do {
                        print "Welche Uhrtzeit wollen sie?\n";
                        $time = readline();
                        if (preg_match('/^$/', $time)) {
                            $time = $uhrzeit;
                        }
                    } while (!preg_match('/^[012][0-9]\:[0123456][0-9]$/', $time));

                    $eintrag[] = $date;
                    $eintrag[] = $time;


                    print "Aussentemperatur:?\n";
                    $heutigeaussentemepratur = readline();
                    $eintrag[$heutigeaussentemepratur];

                    print "Wie war ihr damalieger Stuhlgang?\n";
                    $heutigerstuhlgang = readline();
                    $eintrag[$heutigerstuhlgang];

                    echo 'Eintrag:' . "\n" . "\n";
                    $doku = readline();
                    $eintrag[] = $doku;

                    if (janein('Einträge speichern')) {
                        $eintraege[$benutzer][$temp] = $eintrag;
                        $json = json_encode($eintraege);
                        file_put_contents('Eintraege.json', $json);

                    }

                case 4:
                    //Einträge löschen

                    trennen();

                    $temp = readline('Welchen Eintrag wollen sie löschen?');
                    trennen();
                    echo 'Eintrag Nr:';
                    $temp = readline();
                    foreach ($eintraege[$benutzer][$temp] as $value => $item) {
                        echo $item . "\n";
                    }
                    trennen();
                    if(janein('Sind sie sicher')){
                        unset($eintraege[$temp]);
                        file_put_contents('Einraege.json',json_encode($eintraege));
                        echo 'Eintrag wurde gelöscht'."\n";

                    }else {
                        echo 'Einträge wurden nicht gelöscht.'."\n";
                    }

                    break;



                case 5:
                    //IP tracken
                    trennen();
                    ip_info($_SERVER["REMOTE_ADDR"]);

                    echo 'Dies wird jetzt etwas brauche...'."\n";

                    echo ip_info("Visitor", "Country")."\n"; // India

                    echo ip_info("Visitor", "Country Code")."\n";// IN

                    echo ip_info("Visitor", "State")."\n"; // Andhra Pradesh

                    echo ip_info("Visitor", "City")."\n"; // Proddatur

                    echo "\n";

                    trennen();

                    break;

                case 6:
                //Zurück
                trennen();
                break;



                default:
                    break;
                }
            }while ($wahl != 6);

    }else {

        foreach ($menue[2] as $value => $item){
            print "[$value] $item \n";
        }

        echo 'Ihre Wahl:';

        do {
            $temp = readline();
        }while (!preg_match('#^[01234x]$#',$temp));

        trennen();

        switch($temp){

            case 'x':
                exit();

            case 0 :
                // Neuer Benutzer
                if(createNewUser()){
                    $temp = -1;

                    foreach (readUsersFromJsonFileAsArray() as $value => $item){
                        $temp++;
                    }
                    $eintraege[$temp][] = ['Test Eintrag'];
                    $json = json_encode($eintraege);
                    file_put_contents('Eintraege.json',$json);
            }


                break;
            case 1 :
                // Alle Benutzer
                showAllUsers();
                echo "\n";
                break;
            case 2 :
                // Anzahl Benutzer
                showTotalUsersCount();
                break;
            case 3 :
                // Benutzer löschen
                deleteTheUserForName();
                break;
            case 4 :
                // Zurück
                printBeautifulText("GOOD BYE");
                break;

            default:
                break;
        }


    }
    
}


function janein($text): bool

{
    do {

        echo $text . ' [ja/nein]?';
        $input = strtolower(substr(readline(), 0, 1));
    } while (!preg_match('#^(j|n)$#', $input));

    return 'j' == $input;
}

function trennen()

{
    print str_repeat("~", 50) . "\n" . "\n";
}

function printBeautifulText($cotent){
    echo "\n*************************  " . $cotent . "  ***********************"."\n";
}

function fileIsExist() : bool{

    if (file_exists('users.json')) {
        return true;
    } else {
        echo "There is no file..";
        return false;
    }
}

function createNewUser(){
    $usersArray = readUsersFromJsonFileAsArray();
    $name = readline("Bitte Benutzername eingeben: ");
    if(!empty($name)){
        $arrne['name'] = $name;
        array_push($usersArray, $arrne );
        file_put_contents('users.json', json_encode($usersArray));
        printBeautifulText("Benutzer erfolgreich erstellt");
        return true;
    }else{
        printBeautifulText("Bitte Name nicht leer lassen");
    }

}

function readUsersFromJsonFileAsArray() : array{
    $usersJson = file_get_contents('users.json');
    $usersArray = json_decode($usersJson, true);

    return $usersArray;
}

function showTotalUsersCount(){
    $usersArray = readUsersFromJsonFileAsArray();
    printBeautifulText("Benutzer total = " . count($usersArray));
}

function showAllUsers(){
    $usersArray = readUsersFromJsonFileAsArray();
    foreach($usersArray as $no => $name){
        echo "\n " .  $no . "  =>  " .  $name["name"];
    }
}

function deleteTheUserForName(){

    $name = readline("Name des zu löschenden Benutzers:  ");

    if(!empty($name)){

        $usersArray = readUsersFromJsonFileAsArray();
        //here we search for the element of the array using the value #NOT KEY ---

        if(($key = array_search($name, array_column($usersArray, 'name'))) != false) {
            // Remove found element from the array
            $temp = array_search($key,$usersArray);

            unset($usersArray[$key]);
            file_put_contents('users.json', json_encode($usersArray));
            echo 'Benutzer erfolgreich gelöscht'."\n";

            $json = file_get_contents('Eintraege.json');
            $eintraege = json_decode($json, JSON_OBJECT_AS_ARRAY);

            unset($eintraege[$key]);
            file_put_contents('Eintraege.json',json_encode($eintraege));
            echo 'Zugehörige Einträge bitte noch löschen'."\n";

        

    }elseif (preg_match('/^$/',$name)) {
        printBeautifulText("Feld bitte füllen");
    }
} else{
    printBeautifulText("Es wurden keine Benutzer mit diesen Namen gefunden");
}
}

print_r(ip_info("Visitor", "Location"));
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

