<?php $this->load->view('admin/header');?>
    <script>
        $(document).ready(function(){
            $("a").click(function(){
                parent.document.getElementById('teacherid').value = $(this).attr('title');
                parent.document.getElementById('teachername').value = $(this).text();
                parent.layer.close(parent.layer.getFrameIndex(window.name));
            });
        });
    </script>
    <style>
        ul a{
            text-decoration:none;
            display:block ;
            width:80px;
            height:30px;
            padding:2px;
            float:left;
            border:solid 1px #F0F0F0 ;
            text-align:center;
            line-height:30px;
            margin-left:3px;
            color:#000;
        }

    </style>
    <ul class="citys">
        <li>
            <?php foreach($list as $value):?>
                <a href="javascript:;" title="<?=$value['id']?>" <?php if($value['mark']==1) echo "style='color: green'"?> ><?=$value['truename']?></a>
            <?php endforeach;?>
        </li>
    </ul>

<?php $this->load->view('admin/footer');?>