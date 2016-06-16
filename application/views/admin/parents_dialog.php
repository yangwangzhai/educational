<?php $this->load->view('admin/header');?>
    <script>
        $(document).ready(function(){

            $("a").click(function(){
                parent.document.getElementById('uid').value = $(this).attr('title');
                parent.document.getElementById('username').value = $(this).text();
                parent.parentsdialog.remove();
            });
        });
    </script>

    <ul class="citys">
        <li>
            <?php foreach($list as $value):?>
                <a href="javascript:;" title="<?=$value['id']?>"><?=$value['username']?></a>
            <?php endforeach;?>
        </li>
    </ul>

<?php $this->load->view('admin/footer');?>