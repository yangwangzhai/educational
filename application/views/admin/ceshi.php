<?php $this->load->view('admin/header');?>

<form method="post" action="<?=$this->baseurl?>&m=action_ceshi">
    <td class="td2" >
        <input name="thumb" class="txt" type="text" id="thumb"/>
    </td>
    <td><input type="button" value="选择.." onclick="upfile('thumb')" class="btn" /></td>
    <input type="submit" name="submit" value=" 提 交 " class="btn" tabindex="3" />
</form>

<?php $this->load->view('admin/footer');?>