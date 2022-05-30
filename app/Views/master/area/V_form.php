<form id='formarea'>

    <div class='form-group'>
        <label for='user'>Code<span class="text-danger">*</span> :</label>
        <input type="hidden" name="areaid" id="areaid" value="<?= (($form_type == 'edit') ? $row['areaid'] : '') ?>">
        <input type='text' class='form-control' name="areacode" id="areacode" value="<?= (($form_type == 'edit') ? $row['areacode'] : '') ?>">
    </div>
    <div class='form-group'>
        <label for='user'>Name<span class="text-danger">*</span> :</label>
        <input type='text' class='form-control' name="areaname" id="areaname" value="<?= (($form_type == 'edit') ? $row['areaname'] : '') ?>">
    </div>
    <?php if ($form_type == "edit") { ?>
        <div class='form-group'>
            <label for='isactive'>Is Active : </label><br>
            <?php
            if ($row['isactive'] == '1') {
                $check = 'checked';
            } else {
                $check = '';
            } ?>
            <input type="checkbox" name="isactive" value="1" id='isactive' <?= $check ?>>
        <?php } ?>
        </div>

        <div class='modal-footer' style="padding-right: 0px;">
            <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancel</button>
            <button type='button' id='button_process' class='btn btn-primary'>Save</button>
        </div>
</form>
<script>
    $(document).ready(function() {
        $('#button_process').on('click', function() {
            let form = $('#formarea')[0];
            let data = new FormData(form);
            var form_type = "<?= $form_type ?>";
            var link = "<?= base_url('area/addData') ?>";
            var process = 'tambah';
            if (form_type == 'edit') {
                link = "<?= base_url('area/editData') ?>";
                process = 'edit'
            }
            $.ajax({
                type: 'post',
                url: link,
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                dataType: 'json',
                success: function(response) {
                    if (response.error) {
                        let data = response.error;

                        if (data.errorName) {
                            $('#areacode').addClass('is-invalid');
                            $('.errorName').text(data.errorName);
                        } else {
                            $('#areacode').removeClass('is-invalid');
                            $('#areacode').addClass('is-valid');
                        }

                    } else {
                        $.notify('Data Berhasil Di' + process, 'success');
                        setTimeout(function() {}, 100);
                        $('#modalcrud').modal('toggle');
                        table.ajax.reload();
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    $.notify('Branch Code sudah ada !', 'error');
                }
            });
        });

    });
</script>