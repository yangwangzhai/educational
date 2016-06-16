<?php $this->load->view('admin/header');?>
    <script>
        $(document).ready(function(){

            $("a").click(function(){
                parent.document.getElementById('rewardid').value = $(this).attr('title');
                parent.document.getElementById('rewardname').value = $(this).text();
                parent.rewarddialog.remove();
            });
        });
    </script>

    <ul class="citys">
        <li>
            <?php foreach($list as $value):?>
                <a href="javascript:;" title="<?=$value['id']?>"><?=$value['name']?></a>
            <?php endforeach;?>
        </li>
    </ul>

<?php $this->load->view('admin/footer');?>