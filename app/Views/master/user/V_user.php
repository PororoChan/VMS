<?= $this->include('inc_master/header') ?>
<?= $this->include('inc_master/sidebar') ?>

<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Halaman User</h1>
        </div>
        <div class="section-body">
            <div class="card full-height">
                <div class="card-header d-flex justify-content-end">
                    <input type="hidden" id="txt_csrfname" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                    <a class="btn btn-primary" id="buttonTambah" href="<?= base_url('user/FormViews') ?>">Add</a>
                </div>
                <div class="card-body table-responsive">
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
                                    <th>Branch</th>
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
        </div>
    </section>
</div>
<?= $this->include('inc_master/footer') ?>