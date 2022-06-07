<?= $this->include('inc_master/header') ?>
<?= $this->include('inc_master/sidebar') ?>
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>VMS</h1>
        </div>
        <div class="section-body">
            <div class="card full-height">
                <div class="card-header" id="header-card">
                    <h5><?= (($form_type == 'Edit') ? 'VMS | Edit Data Security User ' . '[' . $row['user'] . ']' : 'VMS | Add New Data Security User') ?></h5>
                </div>
                <div class="card-body">
                    <form id='formuser'>
                        <div class='form-group'>
                            <label for='user'>Username<span class="text-danger">*</span> :</label>
                            <input type="hidden" name="id" id="id" value="<?= $id ?>">
                            <input type='text' class='form-control' name="username" id="username" value="<?= (($form_type == 'Edit') ? $row['user'] : '') ?>">
                        </div>
                        <div class='form-group'>
                            <label for='user'>SSN <span class="text-danger">*</span> :</label>
                            <input type="hidden" name="ssn_lama" id="ssn_lama" value="<?= (($form_type == 'Edit') ? $row['ssn'] : '') ?>">
                            <input type='text' class='form-control' name="ssn" id="ssn" value="<?= (($form_type == 'Edit') ? $row['ssn'] : '') ?>">
                        </div>
                        <div class="form-group">
                            <label for="pass">Password<span class="text-danger">*</span> :</label>
                            <input type="hidden" name="password_lama" id="password_lama" value="<?= (($form_type == 'Edit') ? $row['pass'] : '') ?>">
                            <input type="password" class="form-control" name="password" id="password" <?= (($form_type == 'Edit') ? '' : 'required') ?>>
                        </div>
                        <div class="form-group">
                            <label for="full">Group<span class="text-danger">*</span> :</label>
                            <input type="text" class="form-control" name="groupnum" id="groupnum" value="<?= (($form_type == 'Edit') ? $row['group'] : '') ?>">
                        </div>

                        <div class="form-group">
                            <label for="full">Fullname<span class="text-danger">*</span> :</label>
                            <input type="hidden" name="fullname_lama" id="fullname_lama" value="<?= (($form_type == 'Edit') ? $row['fullname'] : '') ?>">
                            <input type="text" class="form-control" name="fullname" id="fullname" value="<?= (($form_type == 'Edit') ? $row['fulname'] : '') ?>">
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone<span class="text-danger">*</span> :</label>
                            <input type="text" class="form-control" name="phone" id="phone" value="<?= (($form_type == 'Edit') ? $row['phone'] : '') ?>">
                        </div>
                        <div class="form-group">
                            <label for="companyid">Area<span class="text-danger">*</span> :</label>
                            <select class="form-control" name="area" id="area" style="padding:6px;width: 100%;">
                                <?php if ($form_type == "Edit") { ?>
                                    <option value="<?= $row['area'] ?>"><?= $row['area'] ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="companyid">User<span class="text-danger">*</span> :</label>
                            <select class="form-control" name="userid" id="userid" style="padding:6px;width: 100%;" required>
                                <?php if ($form_type == "Edit") { ?>
                                    <option value="<?= $row['usercode'] ?>"><?= $row['fullname'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="companyid">Spv<span class="text-danger">*</span> :</label>
                            <select class="form-control" name="spvid" id="spvid" style="padding:6px;width: 100%;" required>
                                <?php if ($form_type == "Edit") { ?>
                                    <option value="<?= $row['usrcode'] ?>"><?= $row['fullnames'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="companyid">Kasacab<span class="text-danger">*</span> :</label>
                            <select class="form-control" name="kasacabid" id="kasacabid" style="padding:6px;width: 100%;" required>
                                <?php if ($form_type == "Edit") { ?>
                                    <option value="<?= $row['usrcod'] ?>"><?= $row['fullnamess'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="companyid">Branch<span class="text-danger">*</span> :</label>
                            <select class="form-control" name="branchid" id="branchid" style="padding: 6px; width: 100%" required>
                                <?php if ($form_type == "Edit") { ?>
                                    <option value="<?= $row['bc'] ?>"><?= $row['bn'] ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <?php if ($form_type == "Edit") { ?>
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

                            <?php if ($form_type == "Edit") { ?>
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

                                <?php if ($form_type == "Edit") { ?>
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
                                        <button type='button' class='btn btn-secondary' id="btn_cancel">Cancel</button>
                                        <button type='button' style='margin-left: 5px' id='btn-proses' class='btn btn-primary'>Save</button>
                                    </div>
                                </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
<?= $this->include('inc_master/footer') ?>
<script>
    $(document).ready(function() {
        var type = "<?= $form_type ?>"
        if (type == 'Add') {
            $('#btn-proses').text('Save');
        } else if (type == 'Edit') {
            $('#btn-proses').text('Update');
        }

        $('#btn-proses').on('click', function() {
            var form = $('#formuser')[0];
            var dt = new FormData(form);
            var link = "<?= base_url('user/addData') ?>";
            var process = 'added';
            if (type == 'Edit') {
                link = "<?= base_url('user/editData') ?>";
                process = 'updated'
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
                        $.notify('Data has been ' + process, 'success');
                        setTimeout(function() {
                            table.ajax.reload();
                            window.location.href = "<?= base_url('user') ?>"
                        }, 100);
                    } else {
                        $.notify('Data not ' + process, 'error');
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError);
                }
            });
        });

        $('#btn_cancel').on('click', function() {
            window.location.href = "<?= base_url('user') ?>"
        })

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
                url: '<?= base_url('user/getSpv') ?>',
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
                url: '<?= base_url('user/getKas') ?>',
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
        $("#branchid").select2({
            ajax: {
                url: '<?= base_url('branch/getBranch') ?>',
                type: 'post',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term // search term
                    }
                },
                processResults: function(res) {
                    return {
                        results: res
                    };
                },
                cache: true
            }
        })
    });
</script>