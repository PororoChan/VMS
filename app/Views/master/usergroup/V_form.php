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
                    <h5><?= (($form_type == 'Edit') ? 'VMS | Edit Data Usergroup ' . '[' . $row['groupname'] . ']' : 'VMS | Add New Data Usergroup') ?></h5>
                </div>
                <div class="card-body">
                    <form>
                        <div class='form-group'>
                            <label for='nama'>Name<span class="text-danger">*</span> :</label>
                            <input type='text' class='form-control' name='groupname' id='groupname' value="<?= (($form_type == 'Edit') ? $row['groupname'] : '') ?>" placeholder='Name' required>
                        </div>
                        <input type="hidden" name="groupid" id="groupid" value="<?= (($form_type == 'Edit') ? $groupid : '') ?>">
                        <div class='form-group'>
                            <label for='isactive'>Is Active : </label><br>
                            <?php if ($form_type == "Edit") {
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
                            <button type='button' class='btn btn-secondary' id="btn_cancel">Cancel</button>
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
        var type = "<?= $form_type ?>"
        if (type != 'Add') {
            $('#btn-proses').text('Update');
        }

        $('#button_process').on('click', function() {
            var groupname = $('#groupname').val();
            var isactive = 'f';
            var csrfName = "<?= csrf_token() ?>"; // CSRF Token name
            var csrfHash = "<?= csrf_hash() ?>"; // CSRF hash
            if ($('#isactive').prop('checked') == true) {
                isactive = $('#isactive').val();
            }
            var link = "<?= base_url('usergroup/addData') ?>";
            var data = {
                groupname: groupname,
                isactive: isactive,
                groupid: $('#groupid').val()
            };
            var process = 'added';
            if (type == 'Edit') {
                link = "<?= base_url('usergroup/editData') ?>";
                process = 'updated';
            }
            $.ajax({
                type: 'post',
                url: link,
                data: data,
                success: function(response) {
                    if (response == '1') {
                        $.notify('Data has been ' + process, 'success');
                        setTimeout(function() {}, 100);
                        $('#modalcrud').modal('toggle');
                        table.ajax.reload();
                    } else {
                        $.notify('Data not ' + process, 'error');
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

        $('#btn_cancel').on('click', function() {
            window.location.href = "<?= base_url('usergroup') ?>"
        })
    });
</script>