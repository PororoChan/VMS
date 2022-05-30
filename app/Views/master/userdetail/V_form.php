<form id='formuser'>
    <div class='form-group'>
        <label for='user'>Usercode<span class="text-danger">*</span> :</label>
        <input type="text" class='form-control' name="usercode" id="usercode" value="<?= (($form_type == 'edit') ? $row['usercode'] : '') ?>">
    </div>

    <div class='form-group'>
        <label for='user'>Fullname<span class="text-danger">*</span> :</label>
        <input type='text' class='form-control' name="fullname" id="fullname" value="<?= (($form_type == 'edit') ? $row['fullname'] : '') ?>">
    </div>

    <div class="form-group">
        <label for="pass">Usertype<span class="text-danger">*</span> :</label>
        <input type="text" class="form-control" name="usertype" id="usertype" value="<?= (($form_type == 'edit') ? $row['usertype'] : '') ?>">
    </div>

    <div class="form-group">
        <label for="full">Branchid<span class="text-danger">*</span> :</label>
        <input type="text" class="form-control" name="branchid" id="branchid" value="<?= (($form_type == 'edit') ? $row['branchid'] : '') ?>">
    </div>

    <div class="form-group">
        <label for="full">Active Date<span class="text-danger">*</span> :</label>
        <input type="text" class="form-control" name="activedate" id="activedate" value="<?= (($form_type == 'edit') ? $row['activedate'] : '') ?>">
    </div>

    <div class='form-group'>
        <label for='isactive'>Is Active : </label><br>
        <?php if ($form_type == "edit") {
            if ($row['isactive'] == '1') {
                $check = 'checked';
            } else {
                $check = '';
            } ?>
            <input type="checkbox" name="isactive" value="1" id='isactive' <?= $check ?>>
        <?php } else { ?>
            <input type="checkbox" name="isactive" value="1" id='isactive'>
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
            let form = $('#formuserdetail')[0];
            let data = new FormData(form);
            var form_type = "<?= $form_type ?>";
            var link = "<?= base_url('userdetail/addData') ?>";
            var process = 'tambah';
            if (form_type == 'edit') {
                link = "<?= base_url('userdetail/editData') ?>";
                process = 'edit'
            }
            $.ajax({
                type: 'post',
                url: link,
                data: data,
                processData: false,
                contentType: false,
                cache: false,
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

        $("#userid").select2({
            ajax: {
                url: '<?= base_url('userdetail/getUser') ?>',
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term // search term
                    };
                },
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });
    });
</script>