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
                            <input type="text" class="form-control" id="pcode" name="pcode" value="<?= (($form_type == 'Edit') ? $row['productcode'] : '') ?>">
                        </div>
                        <div class="form-group">
                            <label for="productname">Product Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="pname" name="pname" value="<?= (($form_type == 'Edit') ? $row['productname'] : '') ?>">
                        </div>
                        <div class="form-group">
                            <label for="converter">Converter <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="converter" name="converter" value="<?= (($form_type == 'Edit') ? $row['converter'] : '') ?>">
                        </div>
                        <div class="form-group text-right">
                            <button class="btn btn-secondary" id="btn-cancel">Cancel</button>
                            <button class="btn btn-primary" id="btn-proses">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<?= $this->include('inc_master/footer') ?>