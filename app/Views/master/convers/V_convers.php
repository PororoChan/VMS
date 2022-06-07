<?= $this->include('inc_master/header') ?>
<?= $this->include('inc_master/sidebar') ?>

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>List Data Conversions</h1>
        </div>
        <div class="section-body">
            <div class="card full-height">
                <div class="card-header d-flex justify-content-end">
                    <a href="<?= base_url('convers/FormViews') ?>" class="btn btn-primary">Add</a>
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
                                    <th>Product Code</th>
                                    <th>Product Name</th>
                                    <th>Converter</th>
                                    <th>Actions</th>
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