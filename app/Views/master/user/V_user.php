<?= $this->include('inc_master/header') ?>
<?= $this->include('inc_master/sidebar') ?>

<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>User</h1>
        </div>

        <div class="section-body">
            <div class="card full-height">
                <div class="card-header">
                    <input type="hidden" id="txt_csrfname" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                    <div class="card-body float-right text-right text-fixed">
                        <button type="button" style="margin-left: 800px" class="btn btn-lg btn-primary" id="buttonTambah" onclick="modalGlobal('Add User', 'modal-lg', '<?= base_url('/user/FormViews/') ?>')">Add</button>
                    </div>
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
                                <th>Name</th>
                                <th>Fullname</th>
                                <th>Area</th>
                                <th>Phone</th>
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