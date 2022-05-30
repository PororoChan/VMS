<?= $this->include('inc_master/source_js') ?>
<form id="formupload">
    <div class="form-group">
        <input type="hidden" name="usergroupid" value="<?= $groupid ?>">
        <ul class="list-group list-group-flush">
            <?php foreach ($menu as $m) { ?>
                <li class="list-group-item" style="border-bottom: 0 none;"><i class="<?= $m['menuicon'] ?>"></i> <?= $m['menuname'] ?> <span class="text-dark float-right" style="margin-right: 250px">
                        <?php foreach ($component as $com) { ?>
                            <input type="checkbox" class="mr-2" name="access_input[]" value="<?= $m['menuid'] ?>, <?= $com['componentid'] ?>" <?= (($accessmenu->AccessCheck($m['menuid'], $groupid, $com['componentid'])->countAllResults() > 0) ? 'checked' : '') ?>><?= $com['componentname'] ?>
                        <?php } ?>
                    </span>
                </li>
                <?php if ($msmenu->checkMenu($m['menuid'])->countAllResults() > 0) {
                    foreach ($msmenu->checkMenu($m['menuid'])->get()->getResultArray() as $ms) { ?>
                        <li class="list-group-item float-left ml-4" style="border-bottom: 0 none;"><i class="fas fa-circle"></i> <?= $ms['menuname'] ?> <span class="text-dark float-right" style="margin-right: 250px">
                                <?php foreach ($component as $com) { ?>
                                    <input type="checkbox" class="mr-2" name="access_input[]" value="<?= $ms['menuid'] ?>, <?= $com['componentid'] ?>" <?= (($accessmenu->AccessCheck($ms['menuid'], $groupid, $com['componentid'])->countAllResults() > 0) ? 'checked' : '') ?>><?= $com['componentname'] ?>
                                <?php } ?>
                            </span>
                        </li>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
        </ul>
    </div>
</form>
<div class="modal-footer">
    <button type='button' class='btn btn-secondary' data-dismiss='modal'>Batal</button>
    <button type='button' id='button_process' class='btn btn-primary'>Simpan</button>
</div>
<script>
    $(document).ready(function() {
        $('#button_process').on('click', function() {
            let form = $('#formupload')[0];
            let data = new FormData(form);
            var link = "<?= base_url('usergroup/accessData') ?>";
            var process = "edit"
            // console.log(data);
            $.ajax({
                type: 'post',
                url: link,
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                success: function(response) {
                    console.log(response);
                    if (response == '1') {
                        $.notify('Data Berhasil Di' + process, 'success');
                        setTimeout(function() {}, 100);
                        $('#modalcrud').modal('toggle');
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