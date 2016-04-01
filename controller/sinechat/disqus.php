<p><a href='<?php echo url('disqus'); ?>'>index</a></p>
<?php 

/**
 *  設定參數內容 
 *  若資料需要驗證(Oauth)必須要先跳轉至 $auth_url
 */
$PUBLIC_KEY = "zPcgBD8JD8ZhloQJInKuV0evzPmjRWl1KCymZ331zOAsOqwQmSCKDQnzuFGHXZki";
$SECRET_KEY = "PobL92LkbCMaem8TbTT4FpLoKag0vzAWlStarcs0IdbPW80j8qZ0PfXeArjTvrtp";
$client_id = 'zPcgBD8JD8ZhloQJInKuV0evzPmjRWl1KCymZ331zOAsOqwQmSCKDQnzuFGHXZki';
$endpoint = 'https://disqus.com/api/oauth/2.0/authorize?';
$redirect = url('disqus', 'index');
$scope = 'read,write';
$response_type = 'code';

/**
 *  Oauth用的連結 可以透過<a>來觸發
 */
$auth_url = $endpoint.'&client_id='.$client_id.'&scope='.$scope.'&response_type='.$response_type.'&redirect_uri='.$redirect;

/**
 *  HTML likes : <h3>Trigger authentication -> <a href='".$auth_url."'>OAuth</a></h3>
 */
echo '<h3>Trigger authentication -> <a href="'.$auth_url.'"">OAuth</a></h3>';
echo $auth_url;

/**
 *  如果有透過驗證 會回傳一組code  URL會是 $redirect?code=xxxxxxx
 *  Get the code to request access
 *  若不需要驗證的API 可以跳過 link to Oauth的部分 並讓 $code = null
 */
$code = (!empty($_GET['code'])) ? $_GET['code'] : null;

// Build the URL and request the authentication token
extract($_POST);
$authorize = "authorization_code";
$url = 'https://disqus.com/api/oauth/2.0/access_token/?';
$fields = array(
    'grant_type'=>urlencode($authorize),
    'client_id'=>urlencode($PUBLIC_KEY),
    'client_secret'=>urlencode($SECRET_KEY),
    'redirect_uri'=>urlencode($redirect),
    'code'=>urlencode($code)
);

//url-ify the data for the POST
foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
rtrim($fields_string, "&");
//open connection
$ch = curl_init();
//set the url, number of POST vars, POST data
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_POST,count($fields));
curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
//execute post
$data = curl_exec($ch);
//close connection
curl_close($ch);

/**
 * 取回 Authentication information
 */ 
//turn the string into a object
$auth_results = json_encode($data);
echo "<p><h3>The authentication information returned:</h3>";
print_r( json_decode($auth_results, true) );
echo "</p>";

/**
 * 取回Token
 */ 
$access_token = $auth_results->access_token;
echo "<p><h3>The access token you'll use in API calls:</h3>";
echo $access_token;
echo "</p>";
echo $auth_results->access_token;
   
    function getData($url, $SECRET_KEY, $access_token){
        /** 
         *  Setting OAuth parameters
         *  接收API網址並取得資料
         */
        $oauth_params = (object) array(
            'access_token' => $access_token, 
            'api_secret' => $SECRET_KEY
        );
        $param_string = '';
                  
        //Build the endpiont from the fields selected and put add it to the string.
        //foreach($params as $key=>$value) { $param_string .= $key.'='.$value.'&'; }
        foreach($oauth_params as $key=>$value) { $param_string .= $key.'='.$value.'&'; }
        $param_string = rtrim($param_string, "&");
        // setup curl to make a call to the endpoint
        $url .= $param_string;
        $session = curl_init($url);
        // indicates that we want the response back rather than just returning a "TRUE" string
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($session,CURLOPT_FOLLOWLOCATION,true);
        // execute GET and get the session backs
        $results = curl_exec($session);
        // close connection
        curl_close($session);
        // show the response in the browser
        return  json_decode($results);
    }
    
/**
 *  Setting the correct endpoint
 *  建立要發起查詢的 URL 字串 Likes :  $cases_endpoint = 'https://disqus.com/api/3.0/users/details.json?user=142486944';
 *  參閱 https://disqus.com/api/docs/ 以及 https://disqus.com/api/console/#!/
 */

//Setting the correct endpoint
$forums_endpoint = 'https://disqus.com/api/3.0/posts/details.json?'.'post=2600256552&';

// $forums_endpoint = 'https://disqus.com/api/3.0/users/listForums.json?';

//Calling the function to getData
$forum_details = getData($forums_endpoint, $SECRET_KEY, $access_token);
echo "<p><h3>Getting forum details:</h3>";

$result = json_encode( $forum_details  );
$a_result = json_decode($result, true) ;
$message = $a_result['response']['raw_message'];
echo $message;

if( !emptY($a_result['response']['parent'])) echo $a_result['response']['parent'];

echo "</p>";

