<?php
namespace App\Classes;

use Auth;
use File;
use Carbon\Carbon;
use DB;

class Custom {

    public static function getRates($currency = 'USD')
    {
        if($_ENV['APP_ENV'] == 'local') return 1000;

        $json = @json_decode(self::curlGET('http://btcpanda.info/bitcoin/rates'));

        if(is_object($json))
        {
            return $json->{$currency}->lastPrice;
        }
        else abort(500,'Rates endpoint error');
    }

    public static function getPinBTCAmount($pin_amt = 1, $currency = 'USD')
    {
        $rate = self::getRates($currency);

        $pin_btc_amt = round(10 / $rate, 4) * $pin_amt;

        return $pin_btc_amt;
    }

	public static function popup($message,$redirect)
	{
		echo '<script>alert("'.$message.'");window.location=("'.$redirect.'")</script>';
	}

    public static function currentDateTime($show='')
    {
        if($show=='date')
            return Carbon::today()->format('Y-m-d');
        elseif($show=='time')
            return Carbon::today()->format('H:i:s');
        else
            return Carbon::today()->format('Y-m-d H:i:s');
    }

    public static function currentDate()
    {
        return self::currentDateTime('date');
    }

    public static function currentTime()
    {
        return self::currentDateTime('time');
    }

    public static function niceDayDateTime($value)
    {
        if(strtotime($value) == 0) return '-';

        return Carbon::parse($value)->format('D d-M-Y g:i a');
    }

    public static function niceDateTime($value)
    {
        if(strtotime($value) == 0) return '-';

        return date('d-M-Y g:i a', strtotime($value));
    }

    public static function niceDate($value)
    {
        if(strtotime($value) === false)
        {
            return '-';
        }

        return Carbon::parse($value)->format('d-M-Y');
    }

    public static function niceTime($value)
    {
        return date('g:i a', strtotime($value));
    }

    public static function inHuman($value)
    {
        return Carbon::parse($value)->diffForHumans();
    }

    // ===========================================================================================================================

    public static function linkifyText($value, $protocols = array('http', 'mail'), $attributes = array('target' => '_blank'))
    {
        // Link attributes
        $attr = '';
        foreach ($attributes as $key => $val) {
            $attr = ' ' . $key . '="' . htmlentities($val) . '"';
        }

        $links = array();

        // Extract existing links and tags
        $value = preg_replace_callback('~(<a .*?>.*?</a>|<.*?>)~i', function ($match) use (&$links) { return '<' . array_push($links, $match[1]) . '>'; }, $value);

        // Extract text links for each protocol
        foreach ((array)$protocols as $protocol) {
            switch ($protocol) {
                case 'http':
                case 'https':

                    $value = preg_replace_callback('~(?:(https?)://([^\s<]+)|(www\.[^\s<]+?\.[^\s<]+))(?<![\.,:])~i',
                                function ($match) use ($protocol, &$links, $attr) {
                                    if ($match[1]) $protocol = $match[1];

                                    $link = $match[2] ?: $match[3];

                                    //return '<' . array_push($links, "<a $attr href=\"$protocol://$link\">$link</a>") . '>';
                                    return '<' . array_push($links, "<a $attr href=\"$protocol://$link\">[LINK]</a>") . '>';
                                },
                            $value);

                break;

                case 'mail':

                    $value = preg_replace_callback('~([^\s<]+?@[^\s<]+?\.[^\s<]+)(?<![\.,:])~',
                                function ($match) use (&$links, $attr) {
                                    //return '<' . array_push($links, "<a $attr href=\"mailto:{$match[1]}\">{$match[1]}</a>") . '>';
                                    return '<' . array_push($links, "<a $attr href=\"mailto:{$match[1]}\">[LINK]</a>") . '>';
                                },
                            $value);

                break;

                // case 'twitter': $value = preg_replace_callback('~(?<!\w)[@#](\w++)~', function ($match) use (&$links, $attr) { return '<' . array_push($links, "<a $attr href=\"https://twitter.com/" . ($match[0][0] == '@' ? '' : 'search/%23') . $match[1]  . "\">{$match[0]}</a>") . '>'; }, $value); break;

                default:

                    $value = preg_replace_callback('~' . preg_quote($protocol, '~') . '://([^\s<]+?)(?<![\.,:])~i',
                                function ($match) use ($protocol, &$links, $attr) {
                                    //return '<' . array_push($links, "<a $attr href=\"$protocol://{$match[1]}\">{$match[1]}</a>") . '>';
                                    return '<' . array_push($links, "<a $attr href=\"$protocol://{$match[1]}\">[LINK]</a>") . '>';
                                },
                            $value);

                break;
            }
        }

        // Insert all link
        return preg_replace_callback('/<(\d+)>/', function ($match) use (&$links) { return $links[$match[1] - 1]; }, $value);
    }

    public static function stringToColorCode($str)
    {
        $code = dechex(crc32($str));
        $code = substr($code, 0, 6);
        return $code;
    }

    public static function curlGET($url)
    {
        $ch = curl_init();

        $timeout = 5;

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }

    public static function curlPOST($url, $fields)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  // RETURN THE CONTENTS OF THE CALL
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_HEADER, false);  // DO NOT RETURN HTTP HEADERS
        $response = curl_exec($ch);

        return $response;
    }

    public static function build_table($array)
    {
        // start table
        $html = '<table border=1>';
        // header row
        $html .= '<tr>';
        foreach($array[0] as $key=>$value){
                $html .= '<th>' . $key . '</th>';
            }
        $html .= '</tr>';
        // data rows
        foreach( $array as $key=>$value){
            $html .= '<tr>';
            foreach($value as $key2=>$value2){
                $html .= '<td>' . $value2 . '</td>';
            }
            $html .= '</tr>';
        }
        // finish table and return it
        $html .= '</table>';
        return $html;
    }

    public static function auditTrail($user_id, $action, $created_by, $input){

      //GET IP ADDRESS
      $ipaddress = '';
      if (getenv('HTTP_CLIENT_IP'))
          $ipaddress = getenv('HTTP_CLIENT_IP');
      else if(getenv('HTTP_X_FORWARDED_FOR'))
          $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
      else if(getenv('HTTP_X_FORWARDED'))
          $ipaddress = getenv('HTTP_X_FORWARDED');
      else if(getenv('HTTP_FORWARDED_FOR'))
          $ipaddress = getenv('HTTP_FORWARDED_FOR');
      else if(getenv('HTTP_FORWARDED'))
          $ipaddress = getenv('HTTP_FORWARDED');
      else if(getenv('REMOTE_ADDR'))
          $ipaddress = getenv('REMOTE_ADDR');
      else
          $ipaddress = 'UNKNOWN';

      //GET USER AGENT-----------
      //$userAgent = $_SERVER["HTTP_USER_AGENT"];
      $u_agent = $_SERVER['HTTP_USER_AGENT'];
      $bname = 'Unknown';
      $platform = 'Unknown';
      $version= "";

      //First get the platform?
      if (preg_match('/linux/i', $u_agent)) {
        $platform = 'linux';
      }
      elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'mac';
      }
      elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'windows';
      }

      // Next get the name of the useragent yes seperately and for good reason
      if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
      {
        $bname = 'Internet Explorer';
        $ub = "MSIE";
      }
      elseif(preg_match('/Firefox/i',$u_agent))
      {
        $bname = 'Mozilla Firefox';
        $ub = "Firefox";
      }
      elseif(preg_match('/Chrome/i',$u_agent))
      {
        $bname = 'Google Chrome';
        $ub = "Chrome";
      }
      elseif(preg_match('/Safari/i',$u_agent))
      {
        $bname = 'Apple Safari';
        $ub = "Safari";
      }
      elseif(preg_match('/Opera/i',$u_agent))
      {
        $bname = 'Opera';
        $ub = "Opera";
      }
      elseif(preg_match('/Netscape/i',$u_agent))
      {
        $bname = 'Netscape';
        $ub = "Netscape";
      }

      // finally get the correct version number
      $known = array('Version', $ub, 'other');
      $pattern = '#(?<browser>' . join('|', $known) .
      ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
      if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
      }

      // see how many we have
      $i = count($matches['browser']);
      if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
            $version= $matches['version'][0];
        }
        else {
            $version= $matches['version'][1];
        }
      }
      else {
        $version= $matches['version'][0];
      }

      // check if we have a number
      if ($version==null || $version=="") {$version="?";}

      $ua = array(
        'userAgent' => $u_agent,
        'name'      => $bname,
        'version'   => $version,
        'platform'  => $platform,
        'pattern'    => $pattern
      );
      $yourbrowser= $ua['name'] . " version " . $ua['version'] . " on " .$ua['platform'];
      //-------------------------
      #$db_audit = \DB::connection('mysql_audit');
      $db2 = getenv('DB_EXT_DATABASE');
      DB::table($db2.'.audit_trail')->insert(
         [
            'uid'          => $user_id,
            'action_id'    => $action,
            'created_at'   => DB::raw('now()'),
            'ip_address'   => $ipaddress,
            'device'       => $yourbrowser,
            'created_by'   => $created_by,
            'input'        => $input
         ]
      );

   }
}
