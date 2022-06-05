<?= $this->include('inc_master/header') ?>
<?= $this->include('inc_master/sidebar') ?>

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Halaman Brand</h1>
        </div>
        <div class="section-body">
            <div class="card full-height">
                <div class="card-header d-flex justify-content-end">
                    <a class="btn btn-primary" id="buttonTambah" href="<?= base_url('brand/AddViews') ?>">Add</a>
                </div>
                <div class="card-body">
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
                                    <th>Item</th>
                                    <th>Deskripsi</th>
                                    <th>Brand</th>
                                    <th>Bf big</th>
                                    <th>BF</th>
                                    <th>BF 2</th>
                                    <th>BF 3</th>
                                    <th>CartypeName</th>
                                    <th>CartypeName 2</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?= $this->include('inc_master/footer') ?>