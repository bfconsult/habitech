<?php
/**
* Wordpress apdater
* 
* @author: Lan Nguyen
*/

class WordpressApdater {

	/**
	* Insert new user wordpress 
	* 
	* @author vanlan228
	*/
	public static function addUser($data)
	{
		try {
			$connection=Yii::app()->db; 
			$user_id = $data['user_id'];
			$user_login = $data['user_login'];
			$user_pass  = $data['user_pass'];
			$user_nicename = $data['user_nicename'];
			$user_email = $data['user_email'];
			$user_url = '';
			$user_status = 0;
			$display_name = $data['user_nicename'];
			$sql = "INSERT INTO wp_users 
						(ID,user_login, user_pass, user_nicename, user_email, user_url, 
							user_status, display_name, user_registered)
		 	 				VALUES 
		 	 			('$user_id', '$user_login', '$user_pass', '$user_nicename', '$user_email', 
		 	 				'$user_url', '$user_status', '$display_name', NOW())";
			$capabilities = serialize(array('subscriber'));
			$addPermissionSql = "INSERT INTO wp_usermeta
	  						(user_id, meta_key, meta_value)
							VALUES
							  ('$user_id', 'wp_capabilities', '$capabilities');
							INSERT INTO
							  wp_usermeta
							  (user_id, meta_key, meta_value)
							VALUES
							  ('$user_id', 'wp_user_level', '0');";
			$command = $connection->createCommand($sql);
			$rowCount = $command->execute();
			if(!$rowCount) {
				throw new Exception('Can\'t  add new user');
			} else {
				$command = $connection->createCommand($addPermissionSql);
				$command->execute();
			}

		} catch(Exception $e) {
			throw new Exception($e->getMessage());
		}
	}

	public static function updateUserData($data)
	{
		try {
			if(isset($data['user_id']))
			{
				$connection=Yii::app()->db; 
				$user_id = $data['user_id'];
				if(isset($data['password'])) {
					$password = $data['password'];
					$updateSql = "UPDATE  `wp_users` SET  `user_pass` =  '$password' WHERE  `ID` = '$user_id';";	
					$command = $connection->createCommand($updateSql);
					$command->execute();
				}
				if(isset($data['user_nicename']))	
				{
					$nicename = $data['user_nicename'];
					$updateSql = "UPDATE  `wp_users` SET  `user_nicename` =  '$nicename', `display_name` = '$nicename' WHERE  `ID` = '$user_id';";	
					$command = $connection->createCommand($updateSql);
					$command->execute();
				}

				{


					$email = $data['user_email'];
					$updateSql = "UPDATE  `wp_users` SET  `user_login` =  '$email', `user_email` = '$email' WHERE  `ID` = '$user_id';";

					//echo $updateSql;
					//die;
					$command = $connection->createCommand($updateSql);
					$command->execute();

				}

			}
		} catch(Exception $e) {
			throw new Exception($e->getMessage());
		}
	}

	/**
	* Delete user wordpress
	*
	* @author vanlan228
	*/
	public function delete($id) {

	}

	private function _getLastIdOnUser()
	{

	}

	private function _getLastIdOnWordpress()
	{

	}
}