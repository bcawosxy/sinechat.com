<?php 
if(is_ajax()) {

	$value = (!empty($_POST['value'])) ? $_POST['value'] : null ;

	json_encode_return(1, $value, null);
}
$url = 'https://disqus.com/api/oauth/2.0/authorize?&client_id=zPcgBD8JD8ZhloQJInKuV0evzPmjRWl1KCymZ331zOAsOqwQmSCKDQnzuFGHXZki&scope=read,write&response_type=code&redirect_uri=http://mars-chen.com/';

/* mars
API Key:
zPcgBD8JD8ZhloQJInKuV0evzPmjRWl1KCymZ331zOAsOqwQmSCKDQnzuFGHXZki

API Secret:
PobL92LkbCMaem8TbTT4FpLoKag0vzAWlStarcs0IdbPW80j8qZ0PfXeArjTvrtp

Authorize URL:
https://disqus.com/api/oauth/2.0/authorize/

Access Token URL:
https://disqus.com/api/oauth/2.0/access_token/

Your Access Token
Use this token as the value for access_token to authenticate as ccckaass.

Access Token:
78fda7183a84426389c52dc265df4291
*/

/* local
API Key:
VFbHCDdvJciWERELhQUgAlQ9oxfH6CTJuUOBd0eC0ChROeu8Dupohuxc4BKU1e4W

API Secret:
FDmEMH1EC47kFWbhffsOVjSHCxmjEF5RQVN8XkWZbFGpufIr8qZssZKPNLfDRAhr

Authorize URL:
https://disqus.com/api/oauth/2.0/authorize/

Access Token URL:
https://disqus.com/api/oauth/2.0/access_token/

Your Access Token
Use this token as the value for access_token to authenticate as ccckaass.

Access Token:
fab36c02b93344caa368dddd0e8f0f21

*/