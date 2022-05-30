<?= $this->include('inc_master/source_js') ?>
<form>
    <div class='form-group'>
        <label for='nama'>Name<span class="text-danger">*</span> :</label>
        <input type='text' class='form-control' name='groupname' id='groupname' value="<?= (($form_type == 'edit') ? $row['groupname'] : '') ?>" placeholder='Name' required>
    </div>
    <input type="hidden" name="groupid" id="groupid" value="<?= (($form_type == 'edit') ? $groupid : '') ?>">
    <div class='form-group'>
        <label for='isactive'>Is Active : </label><br>
        <?php if ($form_type == "edit") {
            if ($row['isactive'] == 't') {
                $check = 'checked';
            } else {
                $check = '';
            } ?>
            <input type="checkbox" name="isactive" value="t" id='isactive' <?= $check ?>>
        <?php } else { ?>
            <input type="checkbox" name="isactive" value="t" id='isactive'>
        <?php } ?>
    </div>
    <div class='modal-footer'>
        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Batal</button>
        <button type='button' id='button_process' class='btn btn-primary'>Simpan</button>
    </div>
</form>
<script>
    $(document).ready(function() {
        $('#button_process').on('click', function() {
            var groupname = $('#groupname').val();
            var isactive = 'f';
            var csrfName = "<?= csrf_token() ?>"; // CSRF Token name
            var csrfHash = "<?= csrf_hash() ?>"; // CSRF hash
            var form_type = "<?= $form_type ?>";
            if ($('#isactive').prop('checked') == true) {
                isactive = $('#isactive').val();
            }
            var link = "<?= base_url('usergroup/addData') ?>";
            var data = {
                groupname: groupname,
                isactive: isactive,
                groupid: $('#groupid').val()
            };
            var process = 'tambah';
            if (form_type == 'edit') {
                link = "<?= base_url('usergroup/editData') ?>";
                process = 'edit'
            }
            $.ajax({
                type: 'post',
                url: link,
                data: data,
                success: function(response) {
                    if (response == '1') {
                        $.notify('Data Berhasil Di' + process, 'success');
                        setTimeout(function() {}, 100);
                        $('#modalcrud').modal('toggle');
                        table.ajax.reload();
                    } else {
                        $.notify('Data Gagal Di' + process, 'error');
                        setTimeout(function() {
                            window.location.href = e.redirect;
                        }, 100);
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError);
                }
            });
        });
    });
</script>