<?php

namespace App\Helpers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Jenssegers\Agent\Agent;

class Minion {
    public static function get_user_agent() {
        $agent = new Agent();

        if ($agent->isMobile()) {
            return 'Mobile';
        } else {
            return 'Desktop';
        }
    }

    public static function get_user_agent_id($device) {
        if ($device == 'Mobile') {
            return Gru::DEVICE_MOBILE;
        } else {
            return Gru::DEVICE_DESKTOP;
        }
    }

    public static function upload_image(UploadedFile $image, $location) {
        $new_name = Str::random(25) . '.' . $image->getClientOriginalExtension();

        $image = Storage::putFileAs($location, $image, $new_name);

        return '/storage/' . $image;
    }

    public static function upload_banner_file(UploadedFile $file, $location, $banner_name) {
        $new_name = Str::random(25) . '.' . $file->getClientOriginalName();
        if (App::environment(['local'])) {
            $image = Storage::putFileAs($location . "/" . $banner_name, $file, $new_name);
        } else {
            $image = Storage::putFileAs($location . "/" . $banner_name, $file, $new_name);
        }

        return $image;
    }

    public static function upload_file(UploadedFile $file, $location, $with_timestamp = false) {
        $new_name = $file->getClientOriginalName();

        if ($with_timestamp) {
            $new_name_array = explode(".", $new_name);

            $new_name_array = array_merge(array_slice($new_name_array, 0, count($new_name_array) - 1),
                                          ["__" . time()],
                                          array_slice($new_name_array, count($new_name_array) - 1, count($new_name_array) - 1));

            $new_name = implode(".", $new_name_array);
        }

        $image = Storage::putFileAs($location, $file, $new_name);

        return '/storage/' . $image;
    }


    public static function return_error($code, $debugger = null, $message = null) {
        $error_data["error"]             = array();
        $error_data["error"]["message"]  = $message;
        $error_data["error"]["debugger"] = $debugger;

        return response($error_data, $code);
    }

    public static function create_slug($variable, $class) {

        $slug  = Str::slug($variable);

        $exist = $class::where('slug', 'LIKE', "%$slug%")->get();

        if (count($exist) > 0) {
            $slug .= '-' . (count($exist) + 1);
        }
        return $slug;
    }

    public static function get_url_query_params($url, $with_question_mark = true) {
        if (strpos($url, '?') !== false) {
            if ($with_question_mark) {
                return "?" . explode("?", $url)[1];
            } else {
                return explode("?", $url)[1];
            }
        } else {
            return "";
        }
    }

    public static function expand_url_query($url, $key, $value) {
        // if the url already has ? then just add the key and value
        if (strpos($url, '?') !== false) {
            // we already have entries so we need to replace the current key with new value or add it if it doesnt exist
            $url              = explode("?", $url);
            $parameters       = explode("&", $url[1]);
            $final_parameters = [];

            $already_exists = false;

            foreach ($parameters as $param) {
                $key_value = explode("=", $param);

                if ($key_value[0] == $key) {
                    $already_exists = true;

                    if (isset($value)) {
                        array_push($final_parameters, "$key=$value");
                    }
                } else {
                    array_push($final_parameters, $param);
                }
            }

            if (!$already_exists && isset($value)) {
                array_push($final_parameters, "$key=$value");
            }

            if (count($final_parameters) > 0) {
                return $url[0] . "?" . implode("&", $final_parameters);
            } else {
                return $url[0];
            }
        } else {
            if (isset($value)) {
                return "$url?$key=$value";
            } else {
                return $url;
            }
        }
    }

    public static function truncate_text($value, $length, $remove_newline = false) {
        if ($remove_newline) {
            $value = str_replace("\n", "", $value);
            $value = str_replace("<br>", "", $value);
        }

        if (strlen($value) <= $length) {
            return $value;
        } else {
            return substr($value, 0, $length) . "...";
        }
    }

    public static function extract_image_name($original_path) {
        $path_array = explode("/", $original_path);

        return $path_array[count($path_array) - 1];
    }

    public static function extract_image_path($original_path) {
        $path_array = explode("/", $original_path);

        $image_path = $path_array[2];

        for ($i = 3; $i < count($path_array); $i++) {
            $image_path .= "/" . $path_array[$i];
        }

        return $image_path;
    }

    public static function extract_page_from_pagination_url($url) {
        if (strpos($url, '?') !== false) {
            $url        = explode("?", $url);
            $parameters = explode("&", $url[1]);

            foreach ($parameters as $param) {
                $key_value = explode("=", $param);

                if (trim($key_value[0]) == "page") {
                    return trim(intval($key_value[1]));
                }
            }
        }

        return null;
    }

    public static function next_offset($total, $current_count, $current_offset) {
        if ($current_count >= $total || $current_count + $current_offset >= $total) {
            return -1;
        } else {
            return $current_count + $current_offset;
        }
    }

    public static function extract_array_values($array, $key) {
        $values = array_map(function ($var) use ($key) {
            return $var[$key];
        }, $array);

        return $values;
    }

    public static function generate_access_token() {
        return hash('sha512', mt_rand());
    }

    public static function word_to_slug($title, $separator = '-') {
        return Str::slug($title, $separator);
    }

    public static function human_date_format($date, $difference = 3, $format = 'F d, Y') {
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $date);

        $now = Carbon::now();

        if ($date->diffInDays($now) > $difference) {
            return $date->format($format);
        } else {
            return $date->diffForHumans();
        }
    }

    public static function reformat_date($date, $format = 'F d, Y') {
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $date);

        return $date->format($format);
    }

    public static function boolean_to_integer($value) {
        return isset($value) ? $value ? 1 : 0 : 0;
    }

    public static function object_to_array($objects, $value) {
        $array = array();

        foreach ($objects as $object) {
            array_push($array, $object->$value);
        }

        return $array;
    }

    public static function get_excerpt($post) {
        if (isset($post->excerpt)) {
            return $post->excerpt;
        } else {
            return substr(strip_tags($post->content), 0, 210);
        }
    }

    public static function format_transaction_ids($ID) {
        $ID_string = $ID . "";

        while (strlen($ID_string) < 5) {
            $ID_string = '0' . $ID_string;
        }

        return $ID_string;
    }

    public static function file_extension($contentType) {
        $map = array(
            'image/gif'  => '.gif',
            'image/jpeg' => '.jpg',
            'image/png'  => '.png',
        );
        if (isset($map[$contentType])) {
            return $map[$contentType];
        } else {
            return false;
        }
    }

    public static function methodNotAllowedError() {
        return Minion::return_error(405, "The method you are calling is not defined", "Method Not Allowed");
    }

    public static function methodFailedError() {
        return Minion::return_error(420, "Something went wrong and the request could not be completed", "Method Failed");
    }

    public static function get_domain($input) {
        // in case scheme relative URI is passed, e.g., //www.google.com/
        $input = trim($input, '/');

        // If scheme not included, prepend it
        if (!preg_match('#^http(s)?://#', $input)) {
            $input = 'http://' . $input;
        }

        $urlParts = parse_url($input);

        // remove www
        $domain = preg_replace('/^www\./', '', $urlParts['host']);

        return $domain;
    }

    public static function formatNumberThree($number) {
        $int_string = strval($number);

        if (strlen($int_string) < 3) {
            $fill = 3 - strlen($int_string);

            for ($i = 1; $i <= $fill; $i++) {
                $int_string = "0" . $int_string;
            }
        }

        return $int_string;
    }

    public static function param_exist(Request $request, $param) {
        if ($request->has($param) && $request->get($param) != null && $request->get($param) != "") {
            return $request->get($param);
        } else {
            return false;
        }
    }

    public static function getApi($url) {
        $client = new Client();

        $headers['Content-Type'] = 'application/json';
        $headers['Connection']   = 'close';

        $publications = json_decode($client->request('GET', $url, [
            'headers' => $headers
        ])->getBody(),              true);

        return $publications;
    }

    public static function getStorageLink() {
        $data['link'] = Gru::GOOGLE_STORAGE_URL . '/' . env("GOOGLE_CLOUD_STORAGE_BUCKET");

        if (App::environment(['local', 'staging'])) {
            $data['is_staging'] = 1;
        } else {

            $data['is_staging'] = 0;
        }

        return $data;
    }

    public static function create_file_date_string(Carbon $date) {
        $date_string = $date->toDateTimeString();

        $date_string = preg_replace("/[ ]/", '-', $date_string);

        return $date_string;
    }
}
