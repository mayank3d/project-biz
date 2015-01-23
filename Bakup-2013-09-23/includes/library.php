<?php

/*
 * * Developed by ShivaG
 * * ShivaG
 */

function convertXMLtoArray($xml, $recursive = false) {
    if (!$recursive) {
        $array = simplexml_load_string($xml);
    } else {
        $array = $xml;
    }

    $newArray = array();
    $array = (array) $array;
    foreach ($array as $key => $value) {
        $value = (array) $value;
        if (isset($value [0])) {
            $newArray [$key] = trim($value [0]);
        } else {
            $newArray [$key] = convertXMLtoArray($value, true);
        }
    }
    return $newArray;
}

function auth() {

    if (!isset($_SESSION['User']['username'])) {
        $_SESSION['notification'] = array('type' => 'bad', 'msg' => $lang['ADMIN_AUTHENTICATION_REQUIRED']);
        echo "<script>document.location.href='index.php'</script>";
        exit;
    }


    if (isset($_SESSION['Time'])) {

        $period = 60 * 60;
        if (time() - $_SESSION['Time'] >= $period) {
            unset($_SESSION['User']);
            $_SESSION['notification'] = array('type' => 'bad', 'msg' => $lang['ADMIN_SESSION_EXPIRED']);
            header('Location: index.php');
            exit;
        }
    }

    return TRUE;
}

function logout() {
    unset($_SESSION['User']);
    redirect('index.php');
}

/**
 * Standard Connects to database
 */
function db_connect() {

    $db = new DB(array(
        'hostname' => HOSTNAME,
        'username' => DB_USERNAME,
        'password' => DB_PASSWORD,
        'db_name' => DB_NAME
    ));


    if ($db === FALSE) {
        print_debug($db->errors);
        exit;
    }

    return $db;
}

function check_user($username, $password) {

    $db = db_connect();

    $user = $db->get_row("SELECT users.* FROM users WHERE users.username='" . $db->escape($username) . "'");


    if (empty($user)) {
        return FALSE;
    }


    if (md5($password . SALT) != $user['password']) {
        return FALSE;
    }



    $_SESSION['User'] = $user;

    $_SESSION['Time'] = mktime();


    $user_info['modified'] = date('Y-m-d H:i:s');

    $db->update('users', $user_info, $_SESSION['User']['id']);

    return TRUE;
}

function json_stores_list($sql) {

    global $lang;

    $db = db_connect();
    $stores = $db->get_rows($sql);
    $json = array();

    if (!empty($stores)) {

        $json['success'] = 1;

        $json['stores'] = array();

        foreach ($stores as $k => $v) {

            // store img
            $upload_dir = ROOT . 'admin/imgs/stores/' . $v['id'] . '/';

            $files = get_files($upload_dir);

            if (is_array($files)) {
                $files = array_values($files);
            }

            $img = '';
            if ($files !== FALSE && isset($files[0])) {
                $img = ROOT_URL . 'admin/imgs/stores/' . $v['id'] . '/' . $files[0];
            }

            $cat_img = '';
            $cat_name = '';

            if ($v['cat_id'] > 0) {
                // cat img

                $cat_upload_dir = ROOT . 'admin/imgs/categories/' . $v['cat_id'] . '/';

                $cat_files = get_files($cat_upload_dir);

                if (is_array($cat_files)) {
                    $cat_files = array_values($cat_files);
                }

                if ($cat_files !== FALSE && isset($cat_files[0])) {
                    $cat_img = ROOT_URL . 'admin/imgs/categories/' . $v['cat_id'] . '/' . $cat_files[0];
                }

                $cats = $db->get_rows("SELECT categories.* FROM categories WHERE categories.id='" . $v['cat_id'] . "'");

                if (!empty($cats)):
                    foreach ($cats as $a => $b):
                        $cat_name = $b['cat_name'];
                    endforeach;
                endif;
            }


            $json['stores'][] = array(
                'id' => $v['id'],
                'name' => $v['name'],
                'address' => $v['address'],
                'price' => $v['price'],
                'bedrooms' => $v['bedrooms'],
                'caption' => $v['caption'],
                'telephone' => $v['telephone'],
                'email' => $v['email'],
                'website' => $v['website'],
                'description' => $v['description'],
                'lat' => $v['latitude'],
                'lng' => $v['longitude'],
                'titlewebsite' => $lang['ADMIN_WEBSITE'],
                'titleemail' => $lang['ADMINISTRATOR_EMAIL'],
                'titletel' => $lang['ADMIN_TELEPHONE'],
                'titlecontactstore' => $lang['CONTACT_THIS_STORE'],
                'titlekm' => $lang['KM'],
                'titlemiles' => $lang['MILES'],
                'cat_name' => $cat_name,
                'cat_img' => $cat_img,
                'img' => $img
            );
        }
    } else {

        $json = array('success' => 0, 'msg' => $lang['STORE_NOT_FOUND']);
    }
    return json_encode($json);
}

function print_debug($arr) {
    echo '<pre>';
    if (is_string($arr)) {
        echo $arr;
    } else {
        print_r($arr);
    }
    echo '</pre>';
}

function notification() {
    $str = '';
    if (isset($_SESSION['notification'])) {
        if (!isset($_SESSION['notification']['type']) || !isset($_SESSION['notification']['msg'])) {
            return '';
        }
        $class = '';
        switch ($_SESSION['notification']['type']) {
            case 'good':
                $class = ' class="alert fade in"';
                break;
            case 'bad':
                $class = ' class="alert alert-block alert-error fade in"';
                break;
        }
        $str = "<p{$class}>" . $_SESSION['notification']['msg'] . "</p>";
        unset($_SESSION['notification']);
    }
    return $str;
}

function redirect($url) {

    echo "<meta http-equiv='refresh' content='0;url=" . $url . "'>";
    exit;
}

function get_files($dir) {
    if (!is_dir($dir)) {
        return FALSE;
    }

    $files = @scandir($dir);
    foreach ($files as $k => $v) {
        if (strpos($v, '.') == 0) {
            unset($files[$k]);
        }
    }

    return $files;
}

function create_dir($dir) {
    $res = TRUE;
    if (!is_dir($dir)) {
        $res = mkdir($dir);
        @chmod($dir, 0777);
    }
    return $res;
}
function user_info(){
	$sql = "select ui.FIRST_NAME,ui.LAST_NAME, ui.EMAIL, ui.MOBILE, ui.ADDRESS, ui.CITY, ui.STATE, ui.COUNTRY, ui.DATE_OF_BIRTH, ui.ANNIVERSARY_DATE, ui.TYPE, ui.PUBLIC_PROFILE, ui.PUBLIC_TWEETS,uli.USERNAME, uli.CREATED_DATE_TIME,uli.CREATED_BY,uli.UPDATED_DATE_TIME,uli.UPDATED_BY	IS_ACTIVE,uli.LAST_LOGGED_IN_TIME from USER_LOGIN_INFO as uli,USER_INFO as ui where ui.USER_ID=uli.USER_ID and ui.USER_ID='".$_SESSION['userId']."' ";
	 $db = db_connect();
    $stores = $db->get_rows($sql);
	print_r($stores);
}


