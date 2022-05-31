<form id='formuser'>
    <div class='form-group'>
        <label for='user'>Username<span class="text-danger">*</span> :</label>
        <input type="hidden" name="id" id="id" value="<?= $id ?>">
        <input type='text' class='form-control' name="username" id="username" value="<?= (($form_type == 'edit') ? $row['user'] : '') ?>">
    </div>

    <div class='form-group'>
        <label for='user'>SSN <span class="text-danger">*</span> :</label>
        <input type="hidden" name="ssn_lama" id="ssn_lama" value="<?= (($form_type == 'edit') ? $row['ssn'] : '') ?>">
        <input type='text' class='form-control' name="ssn" id="ssn" value="<?= (($form_type == 'edit') ? $row['ssn'] : '') ?>">
    </div>

    <div class="form-group">
        <label for="pass">Password<span class="text-danger">*</span> :</label>
        <input type="hidden" name="password_lama" id="password_lama" value="<?= (($form_type == 'edit') ? $row['pass'] : '') ?>">
        <input type="password" class="form-control" name="password" id="password" <?= (($form_type == 'edit') ? '' : 'required') ?>>
    </div>

    <div class="form-group">
        <label for="full">Group<span class="text-danger">*</span> :</label>
        <input type="text" class="form-control" name="groupnum" id="groupnum" value="<?= (($form_type == 'edit') ? $row['group'] : '') ?>">
    </div>

    <div class="form-group">
        <label for="full">Fullname<span class="text-danger">*</span> :</label>
        <input type="hidden" name="fullname_lama" id="fullname_lama" value="<?= (($form_type == 'edit') ? $row['fullname'] : '') ?>">
        <input type="text" class="form-control" name="fullname" id="fullname" value="<?= (($form_type == 'edit') ? $row['fulname'] : '') ?>">
    </div>

    <div class="form-group">
        <label for="companyid">Area<span class="text-danger">*</span> :</label>
        <select class="form-control" name="area" id="area" style="padding:6px;width: 100%;">
            <?php if ($form_type == "edit") { ?>
                <option value="<?= $row['area'] ?>"><?= $row['area'] ?></option>
            <?php } ?>
        </select>
    </div>

    <div class="form-group">
        <label for="companyid">User<span class="text-danger">*</span> :</label>
        <select class="form-control" name="userid" id="userid" style="padding:6px;width: 100%;" required>
            <?php if ($form_type == "edit") { ?>
                <option value="<?= $row['usercode'] ?>"><?= $row['fullname'] ?></option>
            <?php } ?>
        </select>
    </div>

    <div class="form-group">
        <label for="phone">Phone<span class="text-danger">*</span> :</label>
        <input type="text" class="form-control" name="phone" id="phone" value="<?= (($form_type == 'edit') ? $row['phone'] : '') ?>">
    </div>

    <div class="form-group">
        <label for="companyid">Spv<span class="text-danger">*</span> :</label>
        <select class="form-control" name="spvid" id="spvid" style="padding:6px;width: 100%;" required>
            <?php if ($form_type == "edit") { ?>
                <option value="<?= $row['usrcode'] ?>"><?= $row['fullnames'] ?></option>
            <?php } ?>
        </select>
    </div>

    <div class="form-group">
        <label for="companyid">Kasacab<span class="text-danger">*</span> :</label>
        <select class="form-control" name="kasacabid" id="kasacabid" style="padding:6px;width: 100%;" required>
            <?php if ($form_type == "edit") { ?>
                <option value="<?= $row['usrcod'] ?>"><?= $row['fullnamess'] ?></option>
            <?php } ?>
        </select>
    </div>

    <?php if ($form_type == "edit") { ?>
        <div class='form-group'>
            <label for='is_active'>Is Active : </label><br>
            <?php if ($row['is_active'] == '1') {
                $check = 'checked';
            } else {
                $check = '';
            } ?>
            <input type="checkbox" name="is_active" value="1" id='is_active' <?= $check ?>>
        <?php } ?>
        </div>

        <?php if ($form_type == "edit") { ?>
            <div class='form-group'>
                <label for='is_loginable'>Is Loginable : </label><br>
                <?php if ($row['is_loginable'] == '1') {
                    $check = 'checked';
                } else {
                    $check = '';
                } ?>
                <input type="checkbox" name="is_loginable" value="1" id='is_loginable' <?= $check ?>>
            <?php } ?>
            </div>

            <?php if ($form_type == "edit") { ?>
                <div class="form-group">
                    <label for='is_spv'>Is Spv : </label><br>
                    <?php if ($row['is_spv'] == '1') {
                        $check = 'checked';
                    } else {
                        $check = '';
                    } ?>
                    <input type="checkbox" name="is_spv" value="1" id='is_spv' <?= $check ?>>
                </div>
            <?php } ?>
            <div class='form-group'>
                <div class='modal-body text-right' style="padding-right: 0px;">
                    <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancel</button>
                    <button type='button' style='margin-left: 5px' id='button_process' class='btn btn-primary'>Save</button>
                </div>
            </div>
</form>
<script>
    $(document).ready(function() {
        $('#button_process').on('click', function() {
            var form = $('#formuser')[0];
            var dt = new FormData(form);
            var form_type = "<?= $form_type ?>";
            var link = "<?= base_url('user/addData') ?>";
            var process = 'tambah';
            if (form_type == 'edit') {
                link = "<?= base_url('user/editData') ?>";
                process = 'edit'
            }
            $.ajax({
                type: 'post',
                url: link,
                data: dt,
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
                            console.log(response)
                            // window.location.href = e.redirect;
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
        $("#area").select2({
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
        $("#spvid").select2({
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
        $("#kasacabid").select2({
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