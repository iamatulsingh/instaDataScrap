# Insta Data Scrap
Insta Data Scrap is an API to scrap some details of any Instagram users using their username. Using this API you can scrap some details even if account is in private mode. It dosen't need Instagram API to fetch data by using Access Token.

>New code added to get data from calling API (this unofficial one).

## How to use it, using API call?
Example:

Just fetch API using ```http://domain.com/api.php?u=username```.
fetch hashtag data using API ```http://domain.com/api.php?hashtag=tag```.

combined API call  ```http://localhost/instaDataScrap/api.php?u=username&hashtag=cristiano```.

## How to use it, using Class import?
Example: 
```
  require_once('insta_data_scrap.class.php');
  $username = "username";
  $insta = new InstaData();
  $userDetails = $insta->getUserDetails($username);
  $accountDetails = $insta->getAccountDetails($username);
  $userData = json_decode($userDetails,true);
  $accountData = json_decode($accountDetails,true);
  $timeLine = $insta->getTimeLine($username);
```

## How to get hashtag data

```
  $hashtag_likes = $insta->getTagLikes('photooftheday'); // here 'photooftheday' is hashtag string
  $hashtag_details = $insta->getTagData('photooftheday');
  
  echo $hashtag_likes . "<br><br>";
  $count = $hashtag_details['count'];
  $hastagData = $hashtag_details['data'];

  for($i=0;$i<$count;$i++){
    echo $hastagData[$i]['hashtag_img'] . "<br>";
    echo $hastagData[$i]['hashtag_txt'] . "<br>";
    echo $hastagData[$i]['hashtag_time'] . "<br>";
  }
```
  
## Use this to print details
  ```
  
  $count = $timeLine['count'];
  $timeLineData = $timeLine['data'];

  for($i=0;$i<$count;$i++){
      echo $timeLineData[$i]['post_img'] . "<br>";
      echo $timeLineData[$i]['post_txt'] . "<br>";
      echo $timeLineData[$i]['post_time'] . "<br>";
      echo $timeLineData[$i]['post_likes'] . "<br>";
      echo $timeLineData[$i]['post_comments'] . "<br>";
  }
  
  print_r($userData);
  print_r($accountData);
  ```
  
## You can print UserData and AccountData in readable format using below code
  ```
  echo $userData['img'];
  echo $userData['full_name'];
  echo $userData['username'];
  echo $userData['is_verified'];
  echo $userData['id'];
  echo $userData['instaUrl'];
  echo $accountData['followers'];
  echo $accountData['follow'];
  echo $accountData['posts'];
  ```
