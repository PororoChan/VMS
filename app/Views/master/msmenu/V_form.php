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
                    <h5><?= (($form_type == 'Edit') ? 'VMS | Edit Data Menu ' . '[' . $row['menuname'] . ']' : 'VMS | Add New Data Menu') ?></h5>
                </div>
                <div class="card-body">
                    <form>
                        <div class="form-group">
                            <label for="checked_master" style="margin-right: 8px;">With Master ?</label>
                            <?php if ($form_type == "Edit") {
                                if ($row['masterid'] > 0) {
                                    $check = 'checked';
                                } else {
                                    $check = '';
                                } ?>
                                <input type="checkbox" id="check_master" class="check_master" value="yes" <?= $check ?>>
                            <?php } else { ?>
                                <input type="checkbox" id="check_master" class="check_master" value="yes">
                            <?php } ?>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="menuid" id="menuid" value="<?= (($form_type == 'Edit') ? $menuid : '') ?>">
                            <select class="form-control select2" name="master" id="master" style="padding:6px;width: 100%;">
                                <?php if ($form_type == "Edit") {
                                    if ($row['masterid'] > 0) { ?>
                                        <option value="<?= $row['masterid'] ?>"><?= $row['master'] ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                        <div class=" form-group">
                            <label for="nama">Name<span class="text-danger">*</span> :</label>
                            <input type="text" class="form-control" id="nama" name="nama" value="<?= (($form_type == 'Edit') ? trim($row['menuname']) : '') ?>">
                        </div>
                        <div class="form-group">
                            <label for="link">Link :</label>
                            <input type="text" class="form-control" id="link" name="link" value="<?= (($form_type == 'Edit') ? trim($row['menulink']) : '') ?>">
                        </div>
                        <div class="form-group">
                            <label for="sequence">Sequence<span class="text-danger">*</span> :</label>
                            <input type="text" class="form-control" id="sequence" name="sequence" value="<?= (($form_type == 'Edit') ? $row['seq'] : '') ?>">
                        </div>
                        <div class="form-group">
                            <label for="icon">Icon :</label>
                            <input type="text" id="icon" name="icon" class="form-control" value="<?= (($form_type == 'Edit') ? trim($row['menuicon']) : '') ?>">
                        </div>
                        <?php if ($form_type == "Edit") { ?>
                            <div class="form-group">
                                <label for="isactive">Is Active :</label>
                                <?php
                                if ($row['isactive'] == 't') {
                                    $act = 'checked';
                                } else {
                                    $act = '';
                                } ?>
                                <input type="checkbox" name="isactive" value="t" id='isactive' <?= $act ?>>
                            <?php } ?>
                            </div>
                            <div class="modal-footer" style="padding-left: 0px;">
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
    var type = "<?= $form_type ?>"
    if (type == 'Add') {
        $('#btn-proses').text('Save');
    } else if (type == 'Edit') {
        $('#btn-proses').text('Update');
    }

    var update_master = function() {
        if ($("#check_master").is(":checked")) {
            $('#master').prop('disabled', false);
        } else {
            $("option:selected").prop("selected", false)
            $('#master').prop('disabled', 'disabled');
        }
    };
    $(update_master);
    $("#check_master").change(update_master);

    $(document).ready(function() {
        $("#master").select2({
            ajax: {
                url: '<?= base_url('menu/getMaster') ?>',
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
        $('#btn-proses').on('click', function() {
            var masterid = 0;
            var csrfName = "<?= csrf_token() ?>"; // CSRF Token name
            var csrfHash = $('#txt_csrfname').val(); // CSRF hash
            if ($('#check_master').prop('checked') == true) {
                masterid = $('#master').val();
            }
            var menuname = $('#nama').val();
            var menulink = $('#link').val();
            var seq = $('#sequence').val();
            var menuicon = $('#icon').val();
            var isactive = 'f';
            if ($('#isactive').prop('checked') == true) {
                isactive = $('#isactive').val();
            }
            var link = "<?= base_url('menu/addData') ?>";
            var data = {
                menuid: $('#menuid').val(),
                masterid: masterid,
                menuname: menuname,
                menulink: menulink,
                seq: seq,
                menuicon: menuicon,
                isactive: isactive
            };
            var process = 'added';
            if (type == 'Edit') {
                link = "<?= base_url('menu/editData') ?>";
                process = 'updated'
            }
            $.ajax({
                type: 'post',
                url: link,
                data: data,
                success: function(response) {
                    if (response == '1') {
                        $.notify('Data has been ' + process, 'success');
                        setTimeout(function() {
                            table.ajax.reload();
                            window.location.href = "<?= base_url('menu') ?>"
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

        $('#btn-cancel').on('click', function() {
            window.location.href = "<?= base_url('menu') ?>"
        })
    });
</script>