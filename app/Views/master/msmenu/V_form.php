<?= $this->include('inc_master/source_js') ?>
<form>
    <div class="form-group">
        <label for="checked_master" style="margin-right: 8px;">With Master ?</label>
        <?php if ($form_type == "edit") {
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
        <input type="hidden" name="menuid" id="menuid" value="<?= (($form_type == 'edit') ? $menuid : '') ?>">
        <select class="form-control select2" name="master" id="master" style="padding:6px;width: 100%;">
            <?php if ($form_type == "edit") {
                if ($row['masterid'] > 0) { ?>
                    <option value="<?= $row['masterid'] ?>"><?= $row['master'] ?></option>
                <?php } ?>
            <?php } ?>
        </select>
    </div>
    <div class=" form-group">
        <label for="nama">Name<span class="text-danger">*</span> :</label>
        <input type="text" class="form-control" id="nama" name="nama" value="<?= (($form_type == 'edit') ? trim($row['menuname']) : '') ?>">
    </div>
    <div class="form-group">
        <label for="link">Link :</label>
        <input type="text" class="form-control" id="link" name="link" value="<?= (($form_type == 'edit') ? trim($row['menulink']) : '') ?>">
    </div>
    <div class="form-group">
        <label for="sequence">Sequence<span class="text-danger">*</span> :</label>
        <input type="text" class="form-control" id="sequence" name="sequence" value="<?= (($form_type == 'edit') ? $row['seq'] : '') ?>">
    </div>
    <div class="form-group">
        <label for="icon">Icon :</label>
        <input type="text" id="icon" name="icon" class="form-control" value="<?= (($form_type == 'edit') ? trim($row['menuicon']) : '') ?>">
    </div>
    <?php if ($form_type == "edit") { ?>
        <div class="form-group">
            <label for="isactive">Is Active :</label>
            <?php
            if ($row['isactive'] == 't') {
                $check = 'checked';
            } else {
                $check = '';
            } ?>
            <input type="checkbox" name="isactive" value="t" id='isactive' <?= $check ?>>
        <?php } ?>
        </div>
        <div class="modal-footer" style="padding-left: 0px;">
            <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancel</button>
            <button type='button' id='button_process' class='btn btn-primary'>Save</button>
        </div>
</form>
<script>
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
        $('#button_process').on('click', function() {
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
            var form_type = "<?= $form_type ?>";
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
            var process = 'tambah';
            if (form_type == 'edit') {
                link = "<?= base_url('menu/editData') ?>";
                process = 'edit'
            }
            $.ajax({
                type: 'post',
                url: link,
                data: data,
                success: function(response) {
                    if (response == '1') {
                        $.notify('Data Berhasil Di' + process, 'success');
                        setTimeout(function() {}, 100);
                        $('#modalcrud').modal('toggle');
                        table.ajax.reload();
                    } else {
                        $.notify('Data Gagal Di' + process, 'error');
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

    });
</script>