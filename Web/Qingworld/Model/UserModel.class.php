<?php
namespace Qingworld\Model;
use Think\Model;
class UserModel extends Model{
	protected $dbName = 'user';
	protected $trueTableName = 'u_userinfo'; 
	
	//ำรปงตวยผ
	function login($name,$passwd){
		$map['u_username'] = $name;
		$map['u_password'] = md5($passwd);
		$rs = $this->field('u_id,u_username,u_password,u_state,u_type')->where($map)->select();        
        return $rs;
    }
}



?>