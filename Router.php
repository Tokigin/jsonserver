<?php
class Router
{
    public static $Root = "/jsonserver"; // project name (remove if deploy to server eg."/")
    public static $Return_404 = true;
    public static $Data = "all";
    public static function Handle()
    {
        $root = self::$Root;
        $currentUri = $_SERVER["REQUEST_URI"];
        $return_404 = self::$Return_404;
        switch ($currentUri) {
            case "$root/":
                $return_404 = false;
                break;
            case "$root/userId":
                self::$Data = "userId";
                $return_404 = false;
                break;
            case "$root/id":
                self::$Data = "id";
                $return_404 = false;
                break;
            case "$root/title":
                self::$Data = "title";
                $return_404 = false;
                break;
            case "$root/body":
                self::$Data = "body";
                $return_404 = false;
                break;
        }
        if ($return_404) {
            echo "bruh";
        } else {
            $data = self::$Data;
            header('Content-Type: application/json; charset=utf-8');
            Json::ReturnJson($data);
            echo json_encode(Json::$myJSON);
        }
    }
}

class Json
{
    public static $myJSON;
    public static function ReturnJson($type)
    {
        $url = 'json/data.json';
        $jsonArray = "";
        $jsonData = file_get_contents($url);
        if ($type == "all") {
            $obj = json_decode($jsonData, true);
            $jsonArray = $obj;
        } else {
            $jsonArray = array();
            $obj = json_decode($jsonData, true);
            if ($obj !== null) {
                foreach ($obj as $post) {
                    $jsonArray[] = $post[$type];
                }
            } else {
                echo 'Error fetching data.';
            }
        }
        self::$myJSON = $jsonArray;
    }
}
