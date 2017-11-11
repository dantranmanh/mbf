<?php

/**
 * Utility.php
 *
 * Core_Utility class
 *
 * @project mvc
 * @author duong bien
 * @email bien.duongvan@yahoo.com
 * @date 13/7/2015
 * @time 21:43
 * @copyright 2015 Copyright duong bien
 * @license duong bien
 * @version 1.0.0
 */
class Core_Utility
{

    public static function phoneNumber($phoneNumber, $check)
    {
        if ($phoneNumber == null) {
            $p = "84912539733";
        } else {
            $p = $phoneNumber;
        }

        if ((int)$phoneNumber) {
			if($check == 'M_ADS_CP1'){
				$fix = substr($phoneNumber,-1);
				return @substr_replace($p, $fix+1, -1, 1);
			}else{
				return $phoneNumber;
			}
        } else {
            return $phoneNumber;
        }
    }

    // Debug function
    public static function debug($arr = null)
    {
        echo "<pre>";
        print_r($arr);
        echo "</pre>";
        exit;
    }

    // Redirect url
    public static function redirect($filename)
    {
        if (!headers_sent())
            header('Location: ' . $filename);
        else {
            echo '<script type="text/javascript">';
            echo 'window.location.href="' . $filename . '";';
            echo '</script>';
            echo '<noscript>';
            echo '<meta http-equiv="refresh" content="0;url=' . $filename . '" />';
            echo '</noscript>';
        }
    }

    // Get client Ip
    public static function getIp()
    {
        $ip = false;
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ips = explode(", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
            if ($ip) {
                array_unshift($ips, $ip);
                $ip = false;
            }
            for ($i = 0; $i < count($ips); $i++) {
                if (!preg_match("/^(10|172\.16|192\.168)\./i", $ips[$i])) {
                    if (version_compare(phpversion(), "5.0.0", ">=")) {
                        if (ip2long($ips[$i]) != false) {
                            $ip = $ips[$i];
                            break;
                        }
                    } else {
                        if (ip2long($ips[$i]) != -1) {
                            $ip = $ips[$i];
                            break;
                        }
                    }
                }
            }
        }
        return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
    }

    public static function normalizeUri($uri)
    {
        if ($uri == null) {
            return null;
        }
        $uri = ltrim($uri, '/');
        return rtrim($uri, '/');
    }

    public static function removeSign($string, $seperator = '-', $allowANSIOnly = false)
    {
        $pattern = array(
            "a" => "á|à|?|?|ã|Á|À|?|?|Ã|a|?|?|?|?|?|A|?|?|?|?|?|â|?|?|?|?|?|Â|?|?|?|?|?",
            "o" => "ó|ò|?|?|õ|Ó|Ò|?|?|Õ|ô|?|?|?|?|?|Ô|?|?|?|?|?|o|?|?|?|?|?|O|?|?|?|?|?",
            "e" => "é|è|?|?|?|É|È|?|?|?|ê|?|?|?|?|?|Ê|?|?|?|?|?",
            "u" => "ú|ù|?|?|u|Ú|Ù|?|?|U|u|?|?|?|?|?|U|?|?|?|?|?",
            "i" => "í|ì|?|?|i|Í|Ì|?|?|I",
            "y" => "ý|?|?|?|?|Ý|?|?|?|?",
            "d" => "d|Ð",
        );
        while (list($key, $value) = each($pattern)) {

            $string = preg_replace('/' . $value . '/i', $key, $string);
        }
        if ($allowANSIOnly) {
            $string = strtolower($string);
            $string = preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '-', ''), $string);
            $string = preg_replace("/(\w*)(\W+)/i", "$1" . $seperator, $string);
        }
        return $string;
    }

    public static function convertUrl($str)
    {
        if (!$str) return false;
        $str = trim($str);
        $str = str_replace("-", "", $str);
        $unicode = array(
            'a' => 'á|à|ả|ã|ạ|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ',
            'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ằ|Ẳ|Ẵ|Ặ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'd' => 'đ',
            'D' => 'Đ',
            'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'i' => 'í|ì|ỉ|ĩ|ị',
            'I' => 'Í|Ì|Ỉ|Ĩ|Ị',
            'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            'y' => 'ý|ỳ|ỷ|ỹ|ỵ',
            'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ'
        );
        foreach ($unicode as $khongdau => $codau) {
            $arr = explode("|", $codau);
            $str = str_replace($arr, $khongdau, $str);
            $str = str_replace(" ", "-", $str);
            $str = preg_replace('/([^\pL\ ]+)/u', '-', strip_tags($str));
            $str = trim($str, "-");
        }
        return strtolower($str);
    }

    public static function unicode_str_filter($str)
    {
        $unicode = array(
            'a' => 'á|à|?|ã|?|a|?|?|?|?|?|â|?|?|?|?|?',
            'd' => 'd',
            'e' => 'é|è|?|?|?|ê|?|?|?|?|?',
            'i' => 'í|ì|?|i|?',
            'o' => 'ó|ò|?|õ|?|ô|?|?|?|?|?|o|?|?|?|?|?',
            'u' => 'ú|ù|?|u|?|u|?|?|?|?|?',
            'y' => 'ý|?|?|?|?',
            'A' => 'Á|À|?|Ã|?|A|?|?|?|?|?|Â|?|?|?|?|?',
            'D' => 'Ð',
            'E' => 'É|È|?|?|?|Ê|?|?|?|?|?',
            'I' => 'Í|Ì|?|I|?',
            'O' => 'Ó|Ò|?|Õ|?|Ô|?|?|?|?|?|O|?|?|?|?|?',
            'U' => 'Ú|Ù|?|U|?|U|?|?|?|?|?',
            'Y' => 'Ý|?|?|?|?',
        );
        foreach ($unicode as $nonUnicode => $uni) {
            $str = preg_replace("/($uni)/i", $nonUnicode, $str);
        }
        return strtolower($str);
    }

    public static function subString($string, $limit = 100, $after = '...')
    {
        if (null == $string) {
            return '';
        }
        if (strlen($string) <= $limit) {
            return $string;
        }

        // Check if module mbstring is already installed or not
        if (function_exists('mb_substr')) {
            return mb_substr($string, 0, $limit, 'UTF-8') . $after;
        } else {
            return substr($string, 0, $limit) . $after;
        }
    }

    public static function commentFacebook($link)
    {
        return '
            <div id="fb-root"></div>
    		<script>(function(d, s, id) {
    		  var js, fjs = d.getElementsByTagName(s)[0];
    		  if (d.getElementById(id)) return;
    		  js = d.createElement(s); js.id = id;
    		  js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&appId=1584681928427763&version=v2.0";
    		  fjs.parentNode.insertBefore(js, fjs);
    		}(document, "script", "facebook-jssdk"));</script>	
    		<div class="fb-comments" data-href="' . $link . '" data-width="100%" data-numposts="5" data-colorscheme="light"></div>
        ';

    }

    public function dequi($arrSource, $parents = 0, $level = 1, &$newArray, $neededCols = array('category_id', 'name', 'parents', 'slug', 'is_active', 'num_views', 'ordering'))
    {
        if (count($arrSource) > 0) {
            foreach ($arrSource as $key => $value) {
                if ($value->parents == $parents) {
                    foreach ($neededCols as $key1) {
                        $needArray[$key1] = $value->{$key1};
                    }
                    $needArray['level'] = $level;

                    $newArray[] = $needArray;
                    $newParent = $value->category_id;
                    unset($arrSource[$key]);
                    $this->dequi($arrSource, $newParent, $level + 1, $newArray, $neededCols);
                }
            }
        }
    }

    public static function CategorySelect($name, $val, $options, $attribs = null)
    {

        $strAttribs = '';
        if ($attribs != null) {
            foreach ($attribs as $key => $info) {
                $strAttribs .= ' ' . $key . '="' . $info . '" ';
            }
        }

        $str = '';
        if (count($options) > 0) {
            foreach ($options as $key => $value) {
                if ($value['level'] == 0) {
                    $value['name'] = $value['name'];
                } else if ($value['level'] == 1) {
                    $value['name'] = ' + ' . $value['name'];
                } else {
                    $string = '&nbsp;&nbsp;';
                    $newString = '';
                    for ($i = 1; $i < $value['level']; $i++) {
                        $newString .= $string;
                    }
                    $value['name'] = $newString . '|- ' . $value['name'];
                }
                if ($val == $value['category_id']) {
                    $select = ' selected ';
                    $str .= '<option value="' . $value['category_id'] . '|' . $value['slug'] . '|' . $value['type'] . '" ' . $select . ' >' . $value['name'] . '</option>';
                } else {
                    $str .= '<option value="' . $value['category_id'] . '|' . $value['slug'] . '|' . $value['type'] . '" >' . $value['name'] . '</option>';
                }
            }
        }

        $xhtml = '<select multiple class="show-tick form-control" data-done-button="true" name="' . $name . '" id="' . $name . '" ' . $strAttribs . '>'
            . $str . '</select>';
        return $xhtml;
    }

    public static function CategorySelectMulti($name, $val, $options, $attribs = null)
    {

        $strAttribs = '';
        if ($attribs != null) {
            foreach ($attribs as $key => $info) {
                $strAttribs .= ' ' . $key . '="' . $info . '" ';
            }
        }

        $str = '';
        if (count($options) > 0) {
            foreach ($options as $key => $value) {
                if ($value['level'] == 0) {
                    $value['name'] = $value['name'];
                } else if ($value['level'] == 1) {
                    $value['name'] = ' + ' . $value['name'];
                } else {
                    $string = '&nbsp;&nbsp;';
                    $newString = '';
                    for ($i = 1; $i < $value['level']; $i++) {
                        $newString .= $string;
                    }
                    $value['name'] = $newString . '|- ' . $value['name'];
                }
                if (@in_array($value['category_id'], $val)) {
                    $select = ' selected ';
                    $str .= '<option data-tokens="' . $value['name'] . '" value="' . $value['category_id'] . '|' . $value['slug'] . '" ' . $select . ' >' . $value['name'] . '</option>';
                } else {
                    $str .= '<option data-tokens="' . $value['name'] . '" value="' . $value['category_id'] . '|' . $value['slug'] . '" >' . $value['name'] . '</option>';
                }
            }
        }

        $xhtml = '<select class="selectpicker form-control" multiple data-live-search="true" data-done-button="true" name="cat_ids[]" id="' . $name . '" ' . $strAttribs . '>'
            . $str . '</select>';
        return $xhtml;

    }

    public static function filter($str = null)
    {
        //return $str;
        return str_replace(array("'", '"', '\\', '`', "“", "”"), array(null, null, null, null, null, null), self::upperFirstChar(strip_tags($str)));
    }

    private static function upperFirstChar($t)
    {
        $fChar = mb_substr($t, 0, 1, 'UTF-8');
        $fCharReplace = mb_convert_case($fChar, MB_CASE_UPPER, 'UTF-8');
        $c = 1;
        $t = str_replace($fChar, $fCharReplace, $t, $c);
        return $t;
    }

    public static function linkCategory($slug = null, $type = null, $region = null)
    {

        ///
    }

    public static function linkDetail($categoryId, $slug = null, $type = null, $session = 1)
    {

        ///
    }

    private static function Slug($slug)
    {
        //$slug = preg_replace("/[0-9]+/","",$slug);
        return $result = ($slug != null) ? $slug : TEMP_SLUG;
    }

    public static function _preg_replace($input)
    {
        return preg_replace("/[0-9]+/", "", $input);
    }


    public static function timeAgo($time_ago)
    {
        $cur_time = time();
        $time_elapsed = $cur_time - $time_ago;
        $seconds = $time_elapsed;
        $minutes = round($time_elapsed / 60);
        $hours = round($time_elapsed / 3600);
        $days = round($time_elapsed / 86400);
        $weeks = round($time_elapsed / 604800);
        $months = round($time_elapsed / 2600640);
        $years = round($time_elapsed / 31207680);
        // Seconds
        if ($seconds <= 60) {
            echo "Khoảng $seconds giây trước";
        } //Minutes
        else if ($minutes <= 60) {
            if ($minutes == 1) {
                echo "Khoảng một phút trước";
            } else {
                echo "Khoảng $minutes phút trước";
            }
        } //Hours
        else if ($hours <= 24) {
            if ($hours == 1) {
                echo "Khoảng một giờ trước";
            } else {
                echo "Khoảng $hours giờ trước";
            }
        } //Days
        else if ($days <= 7) {
            if ($days == 1) {
                echo "Khoảng một ngày trước";
            } else {
                echo "Khoảng $days ngày trước";
            }
        } //Weeks
        else if ($weeks <= 4.3) {
            if ($weeks == 1) {
                echo "Khoảng một tuần trước";
            } else {
                echo "$weeks weeks ago";
            }
        } //Months
        else if ($months <= 12) {
            if ($months == 1) {
                echo "Khoảng một tháng trước";
            } else {
                echo "Khoảng $months tháng trước";
            }
        } //Years
        else {
            if ($years == 1) {
                echo "Khoảng một năm trước";
            } else {
                echo "Khoảng $years năm trước";
            }
        }
    }

    public static function getAttribute($attrib, $tag)
    {
        //get attribute from html tag
        $re = '/' . $attrib . '=["\']?([^"\' ]*)["\' ]/is';
        preg_match($re, $tag, $match);
        if ($match) {
            return urldecode($match[1]);
        } else {
            return false;
        }
    }

    //last day of month
    public static function lastday($month = '', $year = '')
    {
        if (empty($month)) {
            $month = date('m');
        }
        if (empty($year)) {
            $year = date('Y');
        }
        $result = strtotime("{$year}-{$month}-01");
        $result = strtotime('-1 second', strtotime('+1 month', $result));
        return date('Y-m-d', $result);
    }

    //first day of month
    public static function firstDay($month = '', $year = '')
    {
        if (empty($month)) {
            $month = date('m');
        }
        if (empty($year)) {
            $year = date('Y');
        }
        $result = strtotime("{$year}-{$month}-01");
        return date('Y-m-d', $result);
    }

}