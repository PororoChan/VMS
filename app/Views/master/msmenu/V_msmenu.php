<?= $this->include('inc_master/header') ?>
<?= $this->include('inc_master/sidebar') ?>
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Master Menu</h1>
        </div>
        <div class="section-body">
            <div class="card full-height">
                <div class="card-header">
                    <button type="button" style="margin-left: 800px;" class="btn btn-lg btn-primary" id="buttonTambah" onclick="modalGlobal('Add Master Menu', 'modal-lg', '<?= base_url('menu/AddViews') ?>')">Add</button>
                </div>
                <style>
                    @media (min-width: 500px) {

                        .modal-lg,
                        .modal-xl {
                            max-width: 550px;
                        }
                    }

                    @media (min-width: 600px) {
                        .modal-xl {
                            max-width: 660px;
                        }
                    }
                </style>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover table-striped table-head-fixed" id="datatabel">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Master</th>
                                <th>Menuname</th>
                                <th>Link</th>
                                <th>Sequence</th>
                                <th>Icon</th>
                                <th>Created Date</th>
                                <th>Created By</th>
                                <th>Updated Date</th>
                                <th>Updated By</th>
                                <th>Is Active</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
<?= $this->include('inc_master/footer') ?>