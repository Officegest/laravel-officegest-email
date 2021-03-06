<?php

namespace OfficegestEmail\Classes;

use Illuminate\Validation\ValidationException;

class OfficegestEmail
{
    public function __construct()
    {
        $this->url = config('officegest-email.url');
        $this->user = config('officegest-email.user');
        $this->api_key = config('officegest-email.api_key');
    }

    public function isActive()
    {
        if (!config('officegest-email.is_active') == true) {
            return response()->json('Gateway is not active', 405);
        }
        return true;
    }

    public function send(string $to, string $subject, string $content, array $from = null)
    {
        $this->isActive();
        $auth_data = [
            'username' => $this->user,
            'password' => $this->api_key
        ];
        $post_data = array(
            'from' => $from,
            'to' => $to,
            'subject' => $subject,
            'content' => $content,
        );
        $url = $this->url . '/api/utils/send_email';

        self::CallAPI('POST', $url, $post_data, $auth_data);

        return response()->json(['success' => true, 'message' => 'Your email was sended'], 200);
    }

    public static function CallAPI($method, $url, $data = false, $auth = [])
    {
        $curl = curl_init();
        switch ($method) {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, self::build_post_fields($data));
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_PUT, 1);
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }

        // Optional Authentication:
        if (isset($auth)) {
            $authentication = $auth['username'] . ':' . $auth['password'];
            curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($curl, CURLOPT_USERPWD, $authentication);
        }

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($curl);
        $data = json_decode($result);
        curl_close($curl);

        if ($data->code == 2008) {
            throw new \Exception(__(
                $data->code_desc
            ));
        } else if ($data->code == 2007) {
            throw new \Exception(__(
                $data->invalid_arg
            ));
        }

        if ($data->code == 1001) {
            throw new \Exception(__(
                $data->code_desc
            ));
        } else if ($data->code == 1000) {
            return $data;
        } else {
            throw new \Exception(__(
                'Something went wrong'
            ));
        }
    }

    public static function build_post_fields($data, $existingKeys = '', &$returnArray = [])
    {
        if (($data instanceof CURLFile) or !(is_array($data) or is_object($data))) {
            $returnArray[$existingKeys] = $data;
            return $returnArray;
        } else {
            foreach ($data as $key => $item) {
                self::build_post_fields($item, $existingKeys ? $existingKeys . "[$key]" : $key, $returnArray);
            }
            return $returnArray;
        }
    }
}
