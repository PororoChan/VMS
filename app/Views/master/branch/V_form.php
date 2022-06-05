<?= $this->include('inc_master/header') ?>
<?= $this->include('inc_master/sidebar') ?>

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>VMS</h1>
        </div>
        <div class="section-body">
            <div class="card full-height">
                <div class="card-header">
                    <h5><?= $form_type ?> Branch</h5>
                </div>
                <div class="card-body">
                    <form id='formbranch'>
                        <div class="form-group">
                            <label for='user'>Code<span class="text-danger">*</span> :</label>
                            <input type='hidden' class='form-control' name="code_lama" id="code_lama" value="<?= (($form_type == 'Edit') ? $row['branchcode'] : '') ?>">
                            <input type="hidden" name="branchid" id="branchid" value="<?= (($form_type == 'Edit') ? $branchid : '') ?>">
                            <input type='text' class='form-control' name="branchcode" id="branchcode" value="<?= (($form_type == 'Edit') ? $row['branchcode'] : '') ?>">
                        </div>
                        <div class="invalid-feedback errorName">
                        </div>
                        <div class='form-group'>
                            <label for='user'>Name<span class="text-danger">*</span> :</label>
                            <input type='text' class='form-control' name="branchname" id="branchname" value="<?= (($form_type == 'Edit') ? $row['branchname'] : '') ?>">
                        </div>

                        <div class="form-group">
                            <label for="companyid">Area<span class="text-danger">*</span> :</label>
                            <select class="form-control" name="areacode" id="areacode" style="padding:6px;width: 100%;" required>
                                <?php if ($form_type == "Edit") { ?>
                                    <option value="<?= $row['areacode'] ?>"><?= $row['areacode'] ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="companyid">Alias<span class="text-danger">*</span> :</label>
                            <select class="form-control" name="aliascode" id="aliascode" style="padding:6px;width: 100%;" required>
                                <?php if ($form_type == "Edit") { ?>
                                    <option value="<?= $row['aliascode'] ?>"><?= $row['aliascode'] ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="companyid">Kasacab<span class="text-danger">*</span> :</label>
                            <select class="form-control" name="kasacabid" id="kasacabid" style="padding:6px;width: 100%;" required>
                                <?php if ($form_type == "Edit") { ?>
                                    <option value="<?= $row['usercode'] ?>"><?= $row['usercode'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <?php if ($form_type == "Edit") { ?>
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
                            <div class="form-group">
                                <div class='modal-body text-right'>
                                    <button type='button' class='btn btn-secondary' id="btn-cancel">Cancel</button>
                                    <button type='button' style="margin-left: 5px;" id='btn-proses' class='btn btn-primary'>Save</button>
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
        var ftype = "<?= $form_type ?>"
        if (ftype == 'Add') {
            $('#btn-proses').text('Save')
        } else if (ftype == 'Edit') {
            $('#btn-proses').text('Update')
        }

        $('#btn-proses').on('click', function() {
            let form = $('#formbranch')[0];
            let data = new FormData(form);
            var link = "<?= base_url('branch/addData') ?>";
            var process = 'tambah';
            if (ftype == 'Edit') {
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