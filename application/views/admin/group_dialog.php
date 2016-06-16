<?php $this->load->view('admin/header');?>
    <script>
        $(document).ready(function(){

            $("a").click(function(){
                //parent.document.getElementById('teacherid').value = $(this).attr('title');
                parent.document.getElementById('group').value = $(this).text();

                parent.layer.close(parent.layer.getFrameIndex(window.name));
            });
        });
    </script>

    <ul class="citys">
        <li>
            <?php foreach($list as $value):?>
                <a href="javascript:;" ><?=$value?></a>
            <?php endforeach;?>
        </li>
    </ul>

<?php $this->load->view('admin/footer');?>