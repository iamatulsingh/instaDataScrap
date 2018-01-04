# Insta Data Scrap
Insta Data Scrap is an API to scrap some details of any Instagram users using thier username. Using this API you can scrap some details even if account is in private mode. It dosen't need Instagram API to fetch data by using Access Token.

## How to use it?
Example: 
```
  require_once('insta_data_scrap.class.php');
  $username = $_POST['username'];
  $insta = new InstaData();
  $userDetails = $insta->getUserDetails($username);
  $accountDetails = $insta->getAccountDetails($username);
  $userData = json_decode($userDetails,true);
  $accountData = json_decode($accountDetails,true);
```
  
## Use this to print details
  ```
  print_r($userData);
  print_r($accountData);
  ```
  
## You can also use to print in human redable format
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
  
> I recommend you to use Instagram API to fetch data as offered by Instagram
