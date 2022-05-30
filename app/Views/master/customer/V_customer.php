<?= $this->include('inc_master/header') ?>
<?= $this->include('inc_master/sidebar') ?>
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Customer</h1>
        </div>
        <div class="section-body">
            <div class="card full-height">
                <div class="card-header">
                    <div class="card-body float-right text-right text-fixed">
                        <button type="button" style="margin-left: 800px;" class="btn btn-lg btn-primary" id="buttonTambah" onclick="modalGlobal('Add Customer', 'modal-lg', '<?= base_url('customer/AddViews') ?>')">Add</button>
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
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group" style="margin-left: 10px;">
                                <label for="companyid">Branch:</label>
                                <select class="form-control" name="branchFilter" id="branchFilter" style="padding:2px; width: 10%;" required>
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover table-striped table-head-fixed" id="datatabel">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Address</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Branch</th>
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

<script>
    $(document).ready(function() {
        $("#branchFilter").on('change', function(e) {
            e.preventDefault();
            var csrfName = "<?= csrf_token() ?>"; // CSRF Token name
            var branchid = $(this).val();

            table = $('#datatabel').DataTable({
                serverSide: true,
                destroy: true,
                ajax: {
                    type: 'post',
                    url: '<?= current_url(true) . '/datatabel' ?>' + '/' + branchid,
                    data: function(param) {
                        param[csrfName] = csrfHash;
                        return param;
                    }
                },
            });
        });
        $("#branchFilter").select2({
            ajax: {
                url: '<?= base_url('branch/getBranch') ?>',
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
    });
</script>