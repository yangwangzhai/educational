<?php $this->load->view('admin/header');?>
    <style type="text/css">
        body,ul {
            margin:0;
            padding:0;
        }

        ul {
            width:660px;

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
    <div class="mainbox nomargin" style="float:left;width:670px;margin-left: 30px;">
        <ul>
            <li id="ico-1">
                <a href="index.php?d=admin&c=student&m=add" target="main">
                    <img src="static/admin_img/ico-1.png" alt="添加学生" />
                    <span>添加学生</span>
                </a>
            </li>
            <li>
                <a href="index.php?d=admin&c=student&m=index">
                    <img src="static/admin_img/ico-2.png" alt="学籍档案" />
                    <span>学籍档案</span>
                </a>
            </li>
            <li>
                <a href="index.php?d=admin&c=record&m=index">
                    <img src="static/admin_img/ico-3.png" alt="成长记录" />
                    <span>成长记录</span></a>
            </li>
            <li>
                <a href="index.php?d=admin&c=physical&m=index">
                    <img src="static/admin_img/ico-4.png" alt="体征数据" />
                    <span>体征数据</span>
                </a>
            </li>
            <li>
                <a href="index.php?d=admin&c=teacher&m=add">
                    <img src="static/admin_img/ico-5.png" alt="添加教师" />
                    <span>添加教师</span>
                </a>
            </li>
            <li>
                <a href="index.php?d=admin&c=teacher&m=index">
                    <img src="static/admin_img/ico-6.png" alt="人事档案" />
                    <span>人事档案</span>
                </a>
            </li>
            <li>
                <a href="index.php?d=admin&c=assessment&m=index">
                    <img src="static/admin_img/ico-7.png" alt="绩效考核" />
                    <span>绩效考核</span>
                </a>
            </li>
            <li>
                <a href="index.php?d=admin&c=train&m=index">
                    <img src="static/admin_img/ico-8.png" alt="培训管理" />
                    <span>培训管理</span>

                </a>
            </li>
            <li>
                <a href="index.php?d=admin&c=parents&m=index">
                    <img src="static/admin_img/ico-9.png" alt="家长管理" />
                    <span>家长管理</span>
                </a>
            </li>
            <li>
                <a href="index.php?d=admin&c=resource&catid=1">
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
    <div style="width: 400px; height: 291px; background-image: url(static/admin_img/gonggao.jpg);float:right;">
      <div id="gonggao" align="center" style="padding-top: 62px;">
        
    <marquee scrollamount="2" scrolldelay="120" direction="up" width="278" height="168" onmouseover="stop()" onmouseout="start()">
        
        <div align="center"><font color="#FF0000" size="2"><b>第 2 周（3月7日—3月11日）工 作 安 排</b></font></div>
        <div align="left"><font color="#FF0000" size="2"></font></div>
        <br>
        <br>
            <?php foreach($list as $key=>$value):?>
                <div align="center"><font color="#FF0000" size="2"><b><?=$value['date']?></b></font></div>
                <div align="left"><font color="#FF0000" size="2"><?=nl2br($value['content'])?></font></div>
                <br>
                <br>
            <?php endforeach;?>
    </marquee>
        
      </div>
    </div>
<?php $this->load->view('admin/footer');?>