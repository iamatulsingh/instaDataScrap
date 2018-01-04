# Insta Data Scrap
Insta Data Scrap is an API to scrap some details of any Instagram users using thier username. This API is written in PHP.

# How to use it?
Example: 

  require_once('insta_data_scrap.class.php');
	$username = $_POST['username'];
	$insta = new InstaData();
	$userDetails = $insta->getUserDetails($username);
	$accountDetails = $insta->getAccountDetails($username);
	$userData = json_decode($userDetails,true);
	$accountData = json_decode($accountDetails,true);
  
  # use this to print details
  print_r($userData);
  print_r($accountData);
  
  # you can also use to print in human redable format
  echo $userData['img']."<br>";
  echo $userData['full_name']."<br>";
  echo $userData['username']."<br>";
  echo $userData['is_verified']."<br>";
  echo $userData['id']."<br>";
  echo $userData['instaUrl']."<br>";
  echo $accountData['followers']."<br>";
  echo $accountData['follow']."<br>";
  echo $accountData['posts']."<br>";
  
# I recommend you to use Instagram API to fetch data as offered by Instagram
