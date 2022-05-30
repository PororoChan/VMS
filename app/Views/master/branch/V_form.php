<form id='formbranch'>

    <div class='form-group'>
        <label for='user'>Code<span class="text-danger">*</span> :</label>
        <input type='hidden' class='form-control' name="code_lama" id="code_lama" value="<?= (($form_type == 'edit') ? $row['branchcode'] : '') ?>">
        <input type="hidden" name="branchid" id="branchid" value="<?= (($form_type == 'edit') ? $branchid : '') ?>">
        <input type='text' class='form-control' name="branchcode" id="branchcode" value="<?= (($form_type == 'edit') ? $row['branchcode'] : '') ?>">
        <div class="invalid-feedback errorName">
        </div>
        <div class='form-group'>
            <label for='user'>Name<span class="text-danger">*</span> :</label>
            <input type='text' class='form-control' name="branchname" id="branchname" value="<?= (($form_type == 'edit') ? $row['branchname'] : '') ?>">
        </div>

        <div class="form-group">
            <label for="companyid">Area<span class="text-danger">*</span> :</label>
            <select class="form-control" name="areacode" id="areacode" style="padding:6px;width: 100%;" required>
                <?php if ($form_type == "edit") { ?>
                    <option value="<?= $row['areacode'] ?>"><?= $row['areacode'] ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="form-group">
            <label for="companyid">Alias<span class="text-danger">*</span> :</label>
            <select class="form-control" name="aliascode" id="aliascode" style="padding:6px;width: 100%;" required>
                <?php if ($form_type == "edit") { ?>
                    <option value="<?= $row['aliascode'] ?>"><?= $row['aliascode'] ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="form-group">
            <label for="companyid">Kasacab<span class="text-danger">*</span> :</label>
            <select class="form-control" name="kasacabid" id="kasacabid" style="padding:6px;width: 100%;" required>
                <?php if ($form_type == "edit") { ?>
                    <option value="<?= $row['usercode'] ?>"><?= $row['usercode'] ?></option>
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
            let form = $('#formbranch')[0];
            let data = new FormData(form);
            var form_type = "<?= $form_type ?>";
            var link = "<?= base_url('branch/addData') ?>";
            var process = 'tambah';
            if (form_type == 'edit') {
                link = "<?= base_url('branch/editData') ?>";
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
                            $('#branchcode').addClass('is-invalid');
                            $('.errorName').text(data.errorName);
                        } else {
                            $('#branchcode').removeClass('is-invalid');
                            $('#branchcode').addClass('is-valid');
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

        $("#aliascode").select2({
            ajax: {
                url: '<?= base_url('alias/getAlias') ?>',
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