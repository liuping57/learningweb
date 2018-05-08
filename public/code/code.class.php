<?php
function getrand( $length = 8 )  
{  
    // 密码字符集，可任意添加你需要的字符  
    $chars = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h',   
    'i', 'j', 'k', 'l','m', 'n', 'o', 'p', 'q', 'r', 's',   
    't', 'u', 'v', 'w', 'x', 'y','z', 'A', 'B', 'C', 'D',   
    'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L','M', 'N', 'O',   
    'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y','Z',   
    '0', '1', '2', '3', '4', '5', '6', '7', '8', '9');  
    // 在 $chars 中随机取 $length 个数组元素键名  
    $keys = array_rand($chars, $length);   
    $password = '';  
    for($i = 0; $i < $length; $i++)  
    {  
        // 将 $length 个数组元素连接成字符串  
        $password .= $chars[$keys[$i]];  
    }  
    return $password;  
}
if(isset($_POST['sub'])) {
	$codetype=$_POST['codetype'];
	$code=$_POST['code'];
	$programe=getrand(6);
	$path="/home/tmp/";
	if ($codetype==1) {
		//C代码逻辑
		$filename="c".$programe.".c";
		$myfile = fopen($path.$filename, "w") or die("Unable to open file!");
		fwrite($myfile, $code);
		fclose($myfile);
		exec('sudo docker run  -v '.$path.':/usr/src/myapp  -w /usr/src/myapp gcc gcc -o '.$programe.' '.$filename.' 2>&1', $output, $return_val);
		if($return_val==0)
		{
			unlink($path.$filename);
			exec('sudo docker run  -v '.$path.':/usr/src/myapp  -w /usr/src/myapp gcc ./'.$programe,$ss,$df);
			if ($df==0) 
			{
				echo json_encode($ss);
				unlink($path.$programe);
			}
			else
			{
				echo json_encode($ss);
				unlink($path.$programe);
			}
		}
		else
		{
			echo json_encode($output);
			unlink($path.$filename);
		}
		
		//unlink($path.$programe);
		
	}
	else if ($codetype==2) {	
		//C++代码逻辑
		$filename="c".$programe.".cpp";
		$myfile = fopen($path.$filename, "w") or die("Unable to open file!");
		fwrite($myfile, $code);
		fclose($myfile);
		exec('sudo docker run  -v '.$path.':/usr/src/myapp  -w /usr/src/myapp gcc g++ -o '.$programe.' '.$filename.' 2>&1', $output, $return_val);
		if($return_val==0)
		{
			unlink($path.$filename);
			exec('sudo docker run  -v '.$path.':/usr/src/myapp  -w /usr/src/myapp gcc ./'.$programe,$ss,$df);
			if ($df==0) 
			{
				echo json_encode($ss);
				unlink($path.$programe);
			}
			else
			{
				echo json_encode($ss);
				unlink($path.$programe);
			}
		}
		else
		{
			echo json_encode($output);
			unlink($path.$filename);
		}
		
	}
	else if ($codetype==3) {
		//JAVA代码逻辑
		preg_match('~public class\s+([\w\d$_]+)s*~',$code,$result);
		$javapath=$path.$programe."/";
		exec("sudo mkdir ".$javapath);
		exec("sudo chmod  777 ".$javapath);
		$myfile = fopen($javapath.$result[1].".java", "w") or die("Unable to open file!");
		fwrite($myfile, $code);
		fclose($myfile);
		exec('sudo docker run  -v '.$javapath.':/usr/src/myapp  -w /usr/src/myapp openjdk:latest javac ./'.$result[1].'.java 2>&1', $output, $return_val);
		if($return_val==0)
		{
			exec('sudo docker run  -v '.$javapath.':/usr/src/myapp  -w /usr/src/myapp openjdk:latest java '.$result[1],$ss,$df);
			if ($df==0) 
			{
				echo json_encode($ss);
			}
			else
			{
				echo json_encode($ss);
			}
		}
		else
		{
			echo json_encode($output);
		}

		exec("sudo mv ".$javapath." /home/tmp/trash");
	}
	else if ($codetype==4) {
		//python处理逻辑
		$filename="p".$programe.".py";
		$myfile = fopen($path.$filename, "w") or die("Unable to open file!");
		fwrite($myfile, $code);
		fclose($myfile);
		exec('sudo docker run  -v '.$path.':/usr/src/myapp  -w /usr/src/myapp python:3.5 python ./'.$filename.' 2>&1', $output, $return_val);
		if($return_val==0)
		{
			echo json_encode($output);
			unlink($path.$filename);
		}
		else
		{
			echo json_encode($output);
			unlink($path.$filename);
		}
	}
	else if ($codetype==5) {
		//GO处理逻辑
		$filename="g".$programe.".go";
		$myfile = fopen($path.$filename, "w") or die("Unable to open file!");
		fwrite($myfile, $code);
		fclose($myfile);
		exec('sudo docker run  -v '.$path.':/usr/src/myapp  -w /usr/src/myapp gcc go run '.$filename.' 2>&1', $output, $return_val);
		if($return_val==0)
		{
			echo json_encode($output);
			unlink($path.$filename);
		}
		else
		{
			echo json_encode($output);
			unlink($path.$filename);
		}
	}
}
?>