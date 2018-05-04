<?php

/*
Developer - Atul Singh
Github - https://github.com/iamatulsingh
Telegram - https://t.me/developeratul

@license     Code and contributions have 'MIT License'
             More details: LICENSE

*/

if(isset($_POST['submit'])){
	require_once('insta_data_scrap.class.php');
	$username = $_POST['usr'];
	$insta = new InstaData();
	$userDetails = $insta->getUserDetails($username);
	$accountDetails = $insta->getAccountDetails($username);

	$userData = json_decode($userDetails,true);
	$accountData = json_decode($accountDetails,true);
	
	if($userData['id'] == ""){
		header("Location:index.php");
	}

  #print_r($userData);
  #print_r($accountData);

 /*echo $userData['img']."<br>";
 echo $userData['full_name']."<br>";
 echo $userData['username']."<br>";
 echo $userData['is_verified']."<br>";
 echo $userData['id']."<br>";
 echo $userData['instaUrl']."<br>";
 echo $accountData['followers']."<br>";
 echo $accountData['follow']."<br>";
 echo $accountData['posts']."<br>";*/
}
else{
	header("Location:index.php");
}

?>

<!DOCTYPE html>
<html lang="en" >

<head>
  <meta charset="UTF-8">
  <title>Profile Card</title>
  
  
  
      <link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/3.3.6/paper/bootstrap.min.css">
  
</head>

<body>

    <div class="card">
      <?php $image = $userData['img']; echo "<div class='card-header'
    style='background-image: url($image)'
      >";?>
            <div class="card-header-bar">
              <a href="javascript:void(0);" class="btn-message"><span class="sr-only">Message</span></a>
              <a href="javascript:void(0);" class="btn-menu"><span class="sr-only">Menu</span></a>
            </div>

            <div class="card-header-slanted-edge">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 200"><path class="polygon" d="M-20,200,1000,0V200Z" /></svg>
                <?php $link = $userData['instaUrl']; echo "<a href='$link' target='_blank' class='btn-follow'><span class='sr-only'>Follow</span></a>"; ?>
            </div>
      </div>

      <div class="card-body">
          <?php $name = $userData['full_name']; echo "<h2 class='name'>{$name}</h2>"; ?>
          <?php $uname = $userData['username']; echo "<h4 class='job-title'>Username: {$uname}</h4>"; ?>
          <?php $vaccount = $userData['is_verified']; echo"<div class='bio'>Verified Account: {$vaccount}</div>"; ?>
          <div class="social-accounts">
            <?php $urllink = $userData['instaUrl']; echo "<a href=''><img src='https://res.cloudinary.com/dj14cmwoz/image/upload/v1491077480/profile-card/images/instagram.svg' target='_blank' alt=''><span class='sr-only'>Instagram</span></a>"; ?>
          </div>
      </div>

      <div class="card-footer">
          <div class="stats">
              <div class="stat">
                <span class="label">Followers</span>
                <?php $followers = preg_split("/ /", $accountData['followers']); echo "<span class='value'>{$followers[0]}</span>";?>
              </div>
              <div class="stat">
                <span class="label">Following</span>
                <?php $follow = preg_split("/ /", $accountData['follow']); echo "<span class='value'>{$follow[0]}</span>";?>
              </div>
              <div class="stat">
                <span class="label">Posts</span>
                <?php $posts = preg_split("/ /", $accountData['posts']); echo "<span class='value'>{$posts[0]}</span>";?>
              </div>
          </div>
      </div>
  </div>
  <center>
	<a href="index.php" class="btn btn-primary">Get Back</a>
  </center>
  

</body>

</html>
-->
