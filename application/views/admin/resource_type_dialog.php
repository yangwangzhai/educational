<!DOCTYPE html >
<html>
<head>
    <title>教学素材选择对话框</title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <script type="text/javascript" src="static/js/jquery-1.11.2.min.js"></script>
</head>
<body>
<link href="static/plugin/dtree/dtree.css" rel="stylesheet" type="text/css" />
<script src="static/plugin/dtree/dtree.js" type="text/javascript"></script>

<div class="r_pop" >
    <div class="title"><p class="left" style="font-size:16px">分类选择</p></div>
    <div class="p_div">
        <dl>
            <dt class="dt"><p class="left" style="padding-left:10px;font-size:16px">当前选择：<span class="red"><?=$typename?></span></p><a href="javascript: d.openAll();" class="zxss right">展开所有</a><a href="javascript: d.closeAll();" class="zxss right">收缩所有</a></dt>
        </dl>

        <div class="dd_heigth">

            <script type="text/javascript">

                d = new dTree('d');
                d.add(0, -1, '0', '0', '');
                <?php foreach($list as $item):?>
                d.add(<?php echo $item['id']?>, <?php echo $item['pid']?>, '0', '<?php echo $item['id']?>', '<?php echo $item['title']?>');
                <?php if(!empty($item['son'])):?>
                    <?php foreach($item['son'] as $item1):?>
                        d.add(<?php echo $item1['id']?>, <?php echo $item1['pid']?>, '0', '<?php echo $item1['id']?>', '<?php echo $item1['title']?>');

                        <?php if(!empty($item1['son'])):?>
                        <?php foreach($item1['son'] as $item2):?>
                        d.add(<?php echo $item2['id']?>, <?php echo $item2['pid']?>, '0', '<?php echo $item2['id']?>', '<?php echo $item2['title']?>');
                        <?php endforeach;?>
                        <?php endif;?>

                <?php endforeach;?>
                <?php endif;?>
                <?php endforeach;?>
                document.write(d); d.openAll();

                function closeTree(cid, cname,mtype) {
                    if (cid != 0) {
                        if (mtype == "0") {
                            parent.document.getElementById("type").value = cid;
                            parent.document.getElementById("typename").value = cname;
                        } else {
                            parent.document.getElementById("type").value = cid;
                            parent.document.getElementById("typename").value = cname;
                        }
                    }
                    parent.layer.close(parent.layer.getFrameIndex(window.name));
                }

            </script>

        </div>
    </div>
</div>


</body>
</html>
