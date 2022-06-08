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
                    <h5><?= (($form_type == 'Edit') ? 'VMS | Edit Data Conversion ' . '[' . $row['productcode'] . ']' : 'VMS | Add New Data Conversion') ?></h5>
                </div>
                <div class="card-body">
                    <form id="formconvers">
                        <div class="form-group">
                            <label for="productcode">Product Code <span class="text-danger">*</span></label>
                            <input type="hidden" id="productid" name="productid" value="<?= (($form_type == 'Edit') ? $row['id'] : '') ?>">
                            <input type="text" class="form-control" id="productcode" name="productcode" value="<?= (($form_type == 'Edit') ? $row['productcode'] : '') ?>">
                        </div>
                        <div class="form-group">
                            <label for="productname">Product Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="productname" name="productname" value="<?= (($form_type == 'Edit') ? $row['productname'] : '') ?>">
                        </div>
                        <div class="form-group">
                            <label for="converter">Converter <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="converter" name="converter" value="<?= (($form_type == 'Edit') ? $row['converter'] : '') ?>">
                        </div>
                        <div class="form-group text-right">
                            <button type="button" class="btn btn-secondary" id="btn-cancel">Cancel</button>
                            <button type="button" class="btn btn-primary" id="btn-proses">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<?= $this->include('inc_master/footer') ?>
<script type="text/javascript">
    $(document).ready(function() {
        var ftype = "<?= $form_type ?>";
        if (ftype == 'Add') {
            $('#btn-proses').text('Save');
        } else if (ftype == 'Edit') {
            $('#btn-proses').text('Update');
        }

        $('#btn-proses').on('click', function() {
            var form = $('#formconvers')[0],
                dt = new FormData(form),
                link = "<?= base_url('convers/addData') ?>",
                pros = 'added';

            if (ftype == 'Edit') {
                link = "<?= base_url('convers/editData') ?>"
                pros = 'updated';
            }

            $.ajax({
                url: link,
                type: 'post',
                data: dt,
                dataType: 'json',
                processData: false,
                contentType: false,
                success: function(res) {
                    if (res.error) {
                        let er = res.error;

                        if (er.errorCode) {
                            $('#productcode').addClass('is-invalid');
                            $.notify(er.errorCode, 'error');
                        } else {
                            $('#productcode').removeClass('is-invalid');
                            $('#productcode').addClass('is-valid');
                        }
                    }

                    if (res.success == 1) {
                        $.notify('Data has been ' + pros, 'success');
                        setTimeout(() => {
                            table.ajax.reload();
                            window.location.href = "<?= base_url('convers') ?>"
                        }, 500);
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.log(thrownError);
                }
            });
        });

        $('#btn-cancel').on('click', function() {
            window.location.href = "<?= base_url('convers') ?>"
        });
    });
</script>