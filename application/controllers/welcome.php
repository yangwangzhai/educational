<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
	
/**
 * 首页控制器
 * 用于控制主页显示
 * @author ryo	2015/04/16
 * 
 */
class welcome extends CI_Controller {	

	
	// 首页
	public function index() {	
// 		echo 123;
		header("Location:".base_url()."index.php?c=index&m=show");
	}	
}
