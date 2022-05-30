<form id='formcustomer'>

    <div class='form-group'>
        <label for='user'>Code<span class="text-danger">*</span> :</label>
        <input type='hidden' class='form-control' name="code_lama" id="code_lama" value="<?= (($form_type == 'edit') ? $row['custcode'] : '') ?>">
        <input type='text' class='form-control' name="custcode" id="custcode" value="<?= (($form_type == 'edit') ? $row['custcode'] : '') ?>">
        <div class="invalid-feedback errorName">
        </div>
    </div>

    <div class='form-group'>
        <label for='user'>Name<span class="text-danger">*</span> :</label>
        <input type='text' class='form-control' name="custname" id="custname" value="<?= (($form_type == 'edit') ? $row['custname'] : '') ?>">
    </div>

    <div class='form-group'>
        <label for='user'>Address<span class="text-danger">*</span> :</label>
        <input type='text' class='form-control' name="custaddress" id="custaddress" value="<?= (($form_type == 'edit') ? $row['custaddress'] : '') ?>">
    </div>

    <div class='form-group'>
        <label for='user'>Email<span class="text-danger">*</span> :</label>
        <input type='text' class='form-control' name="custemail" id="custemail" value="<?= (($form_type == 'edit') ? $row['custemail'] : '') ?>">
        <div class="invalid-feedback errorEmail">
        </div>
    </div>

    <div class='form-group'>
        <label for='user'>Phone<span class="text-danger">*</span> :</label>
        <input type='text' class='form-control' name="custphone" id="custphone" value="<?= (($form_type == 'edit') ? $row['custphone'] : '') ?>">
    </div>

    <div class="form-group">
        <label for="companyid">Branch<span class="text-danger">*</span> :</label>
        <select class="form-control" name="branchid" id="branchid" style="padding:6px;width: 100%;" required>
            <?php if ($form_type == "edit") { ?>
                <option value="<?= $row['branchid'] ?>"><?= $row['branchid'] ?></option>
            <?php } ?>
        </select>
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
            let form = $('#formcustomer')[0];
            let data = new FormData(form);
            var form_type = "<?= $form_type ?>";
            var link = "<?= base_url('customer/addData') ?>";
            var process = 'tambah';
            if (form_type == 'edit') {
                link = "<?= base_url('customer/editData') ?>";
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
                            $('#custcode').addClass('is-invalid');
                            $('.errorName').text(data.errorName);
                        } else {
                            $('#custcode').removeClass('is-invalid');
                            $('#custcode').addClass('is-valid');
                        }
                        if (data.errorEmail) {
                            $('#custemail').addClass('is-invalid');
                            $('.errorEmail').text(data.errorEmail);
                        } else {
                            $('#custemail').removeClass('is-invalid');
                            $('#custemail').addClass('is-valid');
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

        $("#branchid").select2({
            ajax: {
                url: '<?= base_url('branch/getBranch') ?>',
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

        $("#areacode").select2({
            ajax: {
                url: '<?= base_url('area/getArea') ?>',
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

        $("#kasacabid").select2({
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