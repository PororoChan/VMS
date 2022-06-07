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
                    <h5><?= (($form_type == 'Edit') ? 'VMS | Edit Data User ' . '[' . $row['fullname'] . ']' : 'VMS | Add New Data User') ?></h5>
                </div>
                <div class="card-body">
                    <form id='formuserdetail'>
                        <div class='form-group'>
                            <label for='user'>Usercode<span class='text-danger'>*</span> :</label>
                            <input type="hidden" name="usercode-old" id="usercode-old" value="<?= $usercode ?>">
                            <input type="text" class='form-control' name="usercode" id="usercode" value="<?= (($form_type == 'Edit') ? $row['usercode'] : '') ?>">
                        </div>

                        <div class='form-group'>
                            <label for='user'>Fullname<span class="text-danger">*</span> :</label>
                            <input type='text' class='form-control' name="fullname" id="fullname" value="<?= (($form_type == 'Edit') ? $row['fullname'] : '') ?>">
                        </div>

                        <div class="form-group">
                            <label for="pass">Usertype<span class="text-danger">*</span> :</label>
                            <input type="text" class="form-control" name="usertype" id="usertype" value="<?= (($form_type == 'Edit') ? $row['usertype'] : '') ?>">
                        </div>

                        <div class="form-group">
                            <label for="full">Branch<span class="text-danger">*</span> :</label>
                            <select class="form-control" name="branch" id="branch" style="padding: 6px; width: 100%;">
                                <?php if ($form_type == 'Edit') { ?>
                                    <option value="<?= $row['bid'] ?>"><?= $row['bname'] ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="full">Active Date<span class="text-danger">*</span> :</label>
                            <input type="date" class="form-control" name="activedate" id="activedate" value="<?= (($form_type == 'Edit') ? $row['activedate'] : '') ?>">
                        </div>

                        <div class='form-group'>
                            <label for='isactive'>Is Active : </label><br>
                            <?php if ($form_type == "Edit") {
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
                            <button type='button' class='btn btn-secondary' id="btn-cancel">Cancel</button>
                            <button type='button' id='btn-proses' class='btn btn-primary'>Save</button>
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
        var form_type = "<?= $form_type ?>";
        if (form_type == 'Add') {
            $('#btn-proses').text('Save')
        } else if (form_type == 'Edit') {
            $('#btn-proses').text('Update')
        }

        $('#btn-proses').on('click', function() {
            let form = $('#formuserdetail')[0];
            let data = new FormData(form);
            var link = "<?= base_url('userdetail/addData') ?>";
            var process = 'added';
            if (form_type == 'Edit') {
                link = "<?= base_url('userdetail/editData') ?>";
                process = 'updated'
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
                        $.notify('Data has been ' + process, 'success');
                        setTimeout(function() {
                            table.ajax.reload();
                            window.location.href = "<?= base_url('msuser') ?>"
                        }, 500);
                    } else {
                        $.notify('Data not ' + process, 'error');
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError);
                }
            });
        });

        $('#btn-cancel').on('click', function() {
            window.location.href = "<?= base_url('msuser') ?>"
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

        $('#branch').select2({
            ajax: {
                url: '<?= base_url('branch/getBranch') ?>',
                type: 'post',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term // search term
                    };
                },
                processResults: function(res) {
                    return {
                        results: res
                    };
                },
                cache: true,
            }
        })
    });
</script>