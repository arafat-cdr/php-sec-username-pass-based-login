<?php
 include 'Net/SSH2.php';


 function pr($data){
 	echo '<pre>';
 	print_r($data);
 	echo '</pre>';
 }

 $host = 'x.x.x.x';
 $port = 22;
 $username = 'arafat';
 $password = 'password';

 $ftp_username = 'rat_cat8';
 $ftp_password = '123456';
 $ftp_directory = "/home/vftp/$ftp_username";

$ssh = new Net_SSH2($host);
if (!$ssh->login($username, $password)) {
   exit('Login Failed');
}


# command 1

$ftp_command  = "echo '{$ftp_username}' | sudo tee -a /etc/vsftpd/vusers.txt; echo '{$ftp_password}' | sudo tee -a /etc/vsftpd/vusers.txt; sudo db_load -T -t hash -f /etc/vsftpd/vusers.txt /etc/vsftpd/vsftpd-virtual-user.db; sudo chmod 600 /etc/vsftpd/vsftpd-virtual-user.db; sudo mkdir -p {$ftp_directory}; sudo chown -R ftp:ftp /home/vftp; sudo rm /etc/vsftpd/vusers.txt";

$ftp_command = "echo '" . $password . "' | sudo -S ".$ftp_command;

// echo $ftp_command;

// I do not know for some reason it is only working 
// after 10-15 page reload
// This is the solution

for($i = 0; $i < 20; $i ++){

	$ssh->exec($ftp_command);
	// echo '<br/><br/><br/>';
}

// pr($ssh);

echo json_encode( 
	array(
		'ftp_user' 		=> 	$ftp_username,
		'ftp_pas'  		=> 	$ftp_password,
		'ftp_directory' =>  $ftp_directory
	)
);