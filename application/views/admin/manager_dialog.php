<?php $this->load->view('admin/header');?>
    <script>
        $(document).ready(function(){

            $("a").click(function(){
                //parent.document.getElementById('teacherid').value = $(this).attr('title');
                parent.document.getElementById('manager').value = $(this).text();
                parent.layer.close(parent.layer.getFrameIndex(window.name));
            });
        });
    </script>

    <ul class="citys">
        <h3>组长：</h3>
        <li>
            <a href="javascript:;" ><?=$list['supervisor']?></a>
        </li>
        <li>
            <h3>组员：</h3>
            <?php foreach($list['group'] as $value):?>
                <a href="javascript:;" ><?=$value['truename']?></a>
            <?php endforeach;?>
        </li>
    </ul>

<?php $this->load->view('admin/footer');?>