<?php
/*
Developer - Atul Singh
Github - https://github.com/iamatulsingh
Telegram - https://t.me/developeratul

@license     Code and contributions have 'MIT License'
             More details: LICENSE

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software with proper credit to original author.

*/
class InstaData{

	public function getData($username){
		$options  = array('http' => array('user_agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36'
						)
					);

		$context  = stream_context_create($options);
		error_reporting(~E_WARNING);
		if(($instaLink = file_get_contents('https://www.instagram.com/' . $username, false, $context)) == false){
			echo "Error: Link not found, user-id is invalid";
			exit;
		}

		return $instaLink;
	}

	public function fetchUserDetails($username){

		$instaLink = $this->getData($username);
		$instaIDPattern = '/window._sharedData = (.*)/';
		if (!preg_match($instaIDPattern, $instaLink, $matches)) {
			exit;
		}
		$trim_data = substr($matches[1], 0, -10);
		$json_output = json_decode($trim_data,true);
		$json_output = $json_output['entry_data']['ProfilePage']['0']['graphql']['user'];
		return $json_output;
	}

	public function fetchAccountDetails($username){

		$details = "";
		$instaLink = $this->getData($username);
		$detailsPattern = '/meta content=(.\d+)(.*)/';
		if (preg_match($detailsPattern, $instaLink, $res)) {
			if (strpos($res[0], 'Followers') !== false) {
				$details = $res[1]. "" .$res[2];
			}
		}
		$input_line = substr($details, 1, -23);
		$userDetails = preg_split("/, /", $input_line);

		return $userDetails;
	}

	public function getTimeLine($username){
		$instaLink = $this->getData($username);
		$instaIDPattern = '/window._sharedData = (.*)/';
		if (!preg_match($instaIDPattern, $instaLink, $matches)) {
			exit;
		}
		$trim_data = substr($matches[1], 0, -10);
		$json_output = json_decode($trim_data,true);
		$json_output = $json_output['entry_data']['ProfilePage']['0']['graphql']['user']['edge_owner_to_timeline_media']['edges'];
		$count = count($json_output);
		$timeLine = Array();
		for($i=0;$i<$count;$i++){
			error_reporting(~E_NOTICE);
			$post_txt = $json_output[$i]['node']['edge_media_to_caption']['edges'] ? $json_output[$i]['node']['edge_media_to_caption']['edges']['0']['node']['text'] : "";
			$post_img = $json_output[$i]['node']['display_url'];
			$post_likes = $json_output[$i]['node']['edge_liked_by']['count'];
			$post_comments = $json_output[$i]['node']['edge_media_to_comment']['count'];
			$post_time = $json_output[$i]['node']['taken_at_timestamp'];
			$date = new DateTime("@$post_time");
			$timeLine[$i]['post_img'] = $post_img;
			$timeLine[$i]['post_txt'] = $post_txt;
			$timeLine[$i]['post_time'] = $date->format('Y-m-d H:i:s');
			$timeLine[$i]['post_likes'] = $post_likes;
			$timeLine[$i]['post_comments'] = $post_comments;
		}
		return Array('data'=>$timeLine,'count'=>$count);
	}

	public function getUserDetails($username){

		$json_output = $this->fetchUserDetails($username);
		$userData = array();
		$userData['img'] = $json_output['profile_pic_url_hd'];
		$userData['full_name'] = $json_output['full_name'];
		$userData['username'] = $json_output['username'];
		$userData['is_verified'] = "false";
		if($json_output['is_verified'])
			$userData['is_verified'] = "true";
		else
			$userData['is_verified'] = "false";
		$userData['id'] = $json_output['id'];
		$userData['instaUrl'] = "https://instagram.com/".$json_output['username'];
		// $json_userData = json_encode($userData);

		// return $json_userData;
		return $userData;
	}

	public function getAccountDetails($username){

		$userDetails = $this->fetchAccountDetails($username);
		$accountData = array();
		$accountData['followers'] = $userDetails[0];
		$accountData['follow'] = $userDetails[1];
		$temp = preg_split("/ -/", $userDetails[2]);
		$accountData['posts'] = $temp[0];
		// $json_accountData = json_encode($accountData);

		// return $json_accountData;
		return $accountData;
	}


// New code added here

	public function getHashTageData($hashtag){
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, 'https://i.instagram.com/api/v1/tags/logged_out_web_info/?tag_name=' . $hashtag);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

		curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

		$headers = array();
		$headers[] = 'Authority: i.instagram.com';
		$headers[] = 'Accept: */*';
		$headers[] = 'Accept-Language: en-US,en;q=0.9';
		$headers[] = 'Cookie: csrftoken=AtXwOU4HakeAhVPX5ymMG5NerRCINGvg; mid=YuqMTwAEAAFwCGMwsQpx3HuH-L1n; ig_did=2A6AF10E-74DE-4398-A1E6-5AD079D49602; dpr=2; datr=Y4zqYg2zy9EU5ozONcNPvGYL';
		$headers[] = 'Origin: https://www.instagram.com';
		$headers[] = 'Referer: https://www.instagram.com/';
		$headers[] = 'Sec-Ch-Ua: \".Not/A)Brand\";v=\"99\", \"Google Chrome\";v=\"103\", \"Chromium\";v=\"103\"';
		$headers[] = 'Sec-Ch-Ua-Mobile: ?0';
		$headers[] = 'Sec-Ch-Ua-Platform: \"Linux\"';
		$headers[] = 'Sec-Fetch-Dest: empty';
		$headers[] = 'Sec-Fetch-Mode: cors';
		$headers[] = 'Sec-Fetch-Site: same-site';
		$headers[] = 'User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36';
		$headers[] = 'X-Asbd-Id: 198387';
		$headers[] = 'X-Csrftoken: AtXwOU4HakeAhVPX5ymMG5NerRCINGvg';
		$headers[] = 'X-Ig-App-Id: 936619743392459';
		$headers[] = 'X-Ig-Www-Claim: 0';
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$hashtagData = curl_exec($ch);
		if (curl_errno($ch)) {
			echo "Error: Hash tag value is not available for " . $hashtag;
			echo 'Error:' . curl_error($ch);
			exit;
		}
		curl_close($ch);

		return $hashtagData;
	}

	public function getTagLikes($hashtag){
		$instaHashtag = $this->getHashTageData($hashtag);
		$json_output = json_decode($instaHashtag,true);
		$likes = $json_output['graphql']['hashtag']['edge_hashtag_to_media']['count'];
		return $likes;
	}

	public function getTagData($hashtag){
		$instaHashtag = $this->getHashTageData($hashtag);
		echo $instaHashtag;
		$json_output = json_decode($instaHashtag,true);
		$json_output = $json_output['graphql']['hashtag']['edge_hashtag_to_media']['edges'];
		$count = count($json_output);
		$hashtag_data = Array();
		for($i=0;$i<$count;$i++){
			error_reporting(~E_NOTICE);
			$txt = $json_output[$i]['node']['edge_media_to_caption']['edges']['0']['node']['text'];
			$post_img = $json_output[$i]['node']['display_url'];
			$hashtag_time = $json_output[$i]['node']['taken_at_timestamp'];
			$date = new DateTime("@$hashtag_time");
			$hashtag_data[$i]['hashtag_img'] = $post_img;
			$hashtag_data[$i]['hashtag_txt'] = $txt;
			$hashtag_data[$i]['hashtag_time'] = $date->format('Y-m-d H:i:s');
		}
		return Array('data'=>$hashtag_data,'count'=>$count);
	}

}
