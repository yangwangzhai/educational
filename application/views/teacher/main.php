<?php $this->load->view('teacher/header');?>
    <style type="text/css">
        body,ul {
            margin:0;
            padding:0;
        }

        ul {
            width:660px;
            margin:0 50px;
            padding:10px 0 6px 15px;
            /* width:660px;
             margin:0 100px;
             padding:10px 0 6px 15px;
           /*border:0px solid #E4E1D3;
             border-width:0 3px 3px 3px;*/
        }
        ul li {
            float:left;
            margin:5px 15px 3px 0;
            list-style-type:none;
            display:inline;
        }
        ul li a {
            display:block;
            width:150px;
            height:175px;
            text-decoration:none;
        }
        ul li a img {
            width:102px;
            height:102px;
            border:0;
        }
        ul li a span {
            display:block;
            width:102px;
            height:23px;
            line-height:20px;
            font-size:16px;
            text-align:center;
            color:#333;
            cursor:hand;
            white-space:nowrap;
            overflow:hidden;
        }
        ul li a:hover span {
            color:#c00;
        }
    </style>
    <!--<h3 class="marginbot">欢迎登录系统管理后台！</h3>

<ul class="memlist">
	<li><em>系统版本：</em>V1.0</li>
	<li><em>Apache版本：</em><?=apache_get_version()?></li>
	<li><em>PHP版本：</em><?=PHP_VERSION?></li>
	<li><em>MYSQL版本：</em><?=$this->db->platform().' '.$this->db->version();?></li>
	<li><em>版权所有：</em><?=PRODUCT_NAME?></li>
</ul>-->
    <div class="mainbox nomargin">
        <ul>
            <li id="ico-1">
                <a href="index.php?d=teacher&c=student&m=add" target="main">
                    <img src="static/admin_img/ico-1.png" alt="添加幼儿" />
                    <span>添加幼儿</span>
                </a>
            </li>
            <li>
                <a href="index.php?d=teacher&c=student&m=index">
                    <img src="static/admin_img/ico-2.png" alt="学籍档案" />
                    <span>学籍档案</span>
                </a>
            </li>
            <li>
                <a href="index.php?d=teacher&c=record&m=index">
                    <img src="static/admin_img/ico-3.png" alt="成长记录" />
                    <span>成长记录</span></a>
            </li>
            <li>
                <a href="index.php?d=teacher&c=physical&m=index">
                    <img src="static/admin_img/ico-4.png" alt="体征数据" />
                    <span>体征数据</span>
                </a>
            </li>
            <li>
                <a href="javascript:void (0)">
                    <img src="static/admin_img/ico-5.png" alt="添加教师" />
                    <span>添加教师</span>
                </a>
            </li>
            <li>
                <a href="javascript:void (0)">
                    <img src="static/admin_img/ico-6.png" alt="人事档案" />
                    <span>人事档案</span>
                </a>
            </li>
            <li>
                <a href="index.php?d=teacher&c=assessment&m=index">
                    <img src="static/admin_img/ico-7.png" alt="绩效考核" />
                    <span>绩效考核</span>
                </a>
            </li>
            <li>
                <a href="index.php?d=teacher&c=train&m=index">
                    <img src="static/admin_img/ico-8.png" alt="培训" />
                    <span>培训</span>

                </a>
            </li>
            <li>
                <a href="index.php?d=teacher&c=parents&m=index">
                    <img src="static/admin_img/ico-9.png" alt="家长管理" />
                    <span>家长管理</span>
                </a>
            </li>
            <li>
                <a href="javascript:void (0)">
                    <img src="static/admin_img/ico-10.png" alt="招生管理" />
                    <span>招生管理</span>
                </a>
            </li>
            <li>
                <a href="javascript:void (0)">
                    <img src="static/admin_img/ico-11.png" alt="教学资源" />
                    <span>教学资源</span>
                </a>
            </li>
            <li>
                <a href="javascript:void (0)">
                    <img src="static/admin_img/ico-12.png" alt="财务收支" />
                    <span>财务收支</span>
                </a>
            </li>
            <div style="clear:both;"></div>
        </ul>
    </div>
<?php $this->load->view('teacher/footer');?>