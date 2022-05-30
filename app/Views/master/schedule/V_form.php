<form id='formschedule'>

    <div class='form-group'>
        <label for='user'>Code<span class="text-danger">*</span> :</label>
        <input type="hidden" name="id" id="id" value="<?= (($form_type == 'edit') ? $row['id'] : '') ?>">
        <input type='text' class='form-control' name="schecode" id="schecode" value="<?= (($form_type == 'edit') ? $row['schecode'] : '') ?>">
        <div class="invalid-feedback errorName">
        </div>
        <div class="form-group">
            <label for="custid">Salesman<span class="text-danger">*</span> :</label>
            <select class="form-control" name="salesmanid" id="salesmanid" style="padding:6px;width: 100%;" required>
                <?php if ($form_type == "edit") { ?>
                    <option value="<?= $row['salesmanid'] ?>"><?= $row['salesmanid'] ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label for="custid">Customer<span class="text-danger">*</span> :</label>
            <select class="form-control" name="custid" id="custid" style="padding:6px;width: 100%;" required>
                <?php if ($form_type == "edit") { ?>
                    <option value="<?= $row['custid'] ?>"><?= $row['custid'] ?></option>
                <?php } ?>
            </select>
        </div>
        <div class='form-group'>
            <label for='user'>Date<span class="text-danger">*</span> :</label>
            <input type='date' class='form-control' name="schedate" id="schedate" value="<?= (($form_type == 'edit') ? $row['schedate'] : '') ?>">
        </div>
        <div class='form-group'>
            <label for='user'>Description<span class="text-danger">*</span> :</label>
            <input type='text' class='form-control' name="description" id="description" value="<?= (($form_type == 'edit') ? $row['description'] : '') ?>">
        </div>
        <div class='form-group'>
            <label for='user'>Real Date<span class="text-danger">*</span> :</label>
            <input type='date' class='form-control' name="realdate" id="realdate" value="<?= (($form_type == 'edit') ? $row['realdate'] : '') ?>">
        </div>
        <?php if ($form_type == "edit") { ?>
            <div class='form-group'>
                <label for='isactive'>Is Active : </label><br>
                <?php if ($row['isactive'] == '1') {
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
            let form = $('#formschedule')[0];
            let data = new FormData(form);
            var form_type = "<?= $form_type ?>";
            var link = "<?= base_url('schedule/addData') ?>";
            var process = 'tambah';
            if (form_type == 'edit') {
                link = "<?= base_url('schedule/editData') ?>";
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
                            $('#schecode').addClass('is-invalid');
                            $('.errorName').text(data.errorName);
                        } else {
                            $('#schecode').removeClass('is-invalid');
                            $('#schecode').addClass('is-valid');
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
        $("#custid").select2({
            ajax: {
                url: '<?= base_url('customer/getCustomer') ?>',
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
        $("#salesmanid").select2({
            ajax: {
                url: '<?= base_url('user/getUser') ?>',
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