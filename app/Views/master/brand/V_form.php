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
                    <h5><?= (($form_type == 'Edit') ? 'VMS | Edit Data Item Brand ' . '[' . $row['itemno'] . ']' : 'VMS | Add New Data Item Brand') ?></h5>
                </div>
                <div class="card-body">
                    <form id='fbrand'>
                        <div class='form-group'>
                            <label>No Item<span class="text-danger">*</span> :</label>
                            <input type="hidden" name="id" id="id" value="<?= $itemno ?>">
                            <input type='text' class='form-control' name="itemno" id="itemno" value="<?= (($form_type == 'Edit') ? $row['itemno'] : '') ?>">
                        </div>
                        <div class='form-group'>
                            <label>Deskripsi <span class="text-danger">*</span> :</label>
                            <input type='text' class='form-control' name="itemdesc" id="itemdesc" value="<?= (($form_type == 'Edit') ? $row['itemdesc'] : '') ?>">
                        </div>
                        <div class="form-group">
                            <label>Brand<span class="text-danger">*</span> :</label>
                            <input type="text" class="form-control" name="brand" id="brand" value="<?= (($form_type == 'Edit') ? $row['brand'] : '') ?>">
                        </div>

                        <div class="form-group">
                            <label>Bf Big<span class="text-danger">*</span> :</label>
                            <input type="text" class="form-control" name="bfbig" id="bfbig" value="<?= (($form_type == 'Edit') ? $row['bfbig'] : '') ?>">
                        </div>
                        <div class="form-group">
                            <label for="full">BF<span class="text-danger">*</span> :</label>
                            <input type="text" class="form-control" name="bf" id="bf" value="<?= (($form_type == 'Edit') ? $row['bf'] : '') ?>">
                        </div>
                        <div class="form-group">
                            <label>BF 2<span class="text-danger">*</span> :</label>
                            <input type="text" class="form-control" name="bf2" id="bf2" value="<?= (($form_type == 'Edit') ? $row['bf2'] : '') ?>">
                        </div>
                        <div class="form-group">
                            <label>BF 3<span class="text-danger">*</span> :</label>
                            <input type="text" class="form-control" name="bf3" id="bf3" value="<?= (($form_type == 'Edit') ? $row['bf3'] : '') ?>">
                        </div>

                        <div class="form-group">
                            <label>Cartype Name<span class="text-danger">*</span> :</label>
                            <input type="text" class="form-control" name="cartype" id="cartype" value="<?= (($form_type == 'Edit') ? $row['cartypename'] : '') ?>">
                        </div>
                        <div class="form-group">
                            <label>Cartype Name 2<span class="text-danger">*</span> :</label>
                            <input type="text" class="form-control" name="cartype2" id="cartype2" value="<?= (($form_type == 'Edit') ? $row['cartypename2'] : '') ?>">
                        </div>
                        <div class='form-group'>
                            <label for="">&nbsp;</label>
                            <div class='text-right' style="padding-right: 0px;">
                                <button type='button' class='btn btn-secondary' id="btn-cancel">Cancel</button>
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
<script type="text/javascript">
    $(document).ready(function() {
        var formtype = "<?= $form_type ?>";
        if (formtype == 'Add') {
            $('#btn-proses').text('Save');
        } else if (formtype == 'Edit') {
            $('#btn-proses').text('Update');
        }

        $('#btn-proses').on('click', function() {
            var form = $('#fbrand')[0];
            var data = new FormData(form);
            var link = "<?= base_url('brand/addBrand') ?>";
            var pros = 'added';
            if (formtype == 'Edit') {
                link = "<?= base_url('brand/editBrand') ?>"
                pros = 'updated'
            }

            $.ajax({
                type: 'post',
                url: link,
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                success: function(res) {
                    if (res == 1) {
                        $.notify('Data has been ' + pros, 'success')
                        setTimeout(() => {
                            table.ajax.reload();
                            window.location.href = "<?= base_url('brand') ?>"
                        }, 500);
                    } else {
                        $.notify('Data not ' + pros, 'error');
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError);
                }
            })
        });

        $('#btn-cancel').on('click', function() {
            window.location.href = "<?= base_url('brand') ?>"
        })
    });
</script>