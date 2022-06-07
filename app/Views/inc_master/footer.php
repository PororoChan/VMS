<footer class="main-footer">
    <div class="footer-left">
        Copyright &copy; 2018 <div class="bullet"></div>
    </div>
    <div class="footer-right">
        2.3.0
    </div>
</footer>
</div>

<div class="modal fade" id="modalcrud">
    <div class="modal-dialog modal-lg" role="document" id="modal-size">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_title"></h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body modal-crud" id="bodycrud">

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modaldelete">
    <div class="modal-dialog modal-lg" role="document" id="modal-size-delete">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title-delete"></h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="deleteModal">
            </div>
            <div id="delete-id">

            </div>
            <div class="modal-footer">
                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancel</button>
                <button type='button' id='button_delete' class='btn btn-primary'>Delete</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modaldelete-folder">
    <div class="modal-dialog modal-lg" role="document" id="modal-size-delete-folder">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title-delete-folder"></h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Apakah anda yakin untuk menghapus data ini ?
                <div id="delete-id-folder">

                </div>
            </div>
            <div class="modal-footer">
                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Batal</button>
                <button type='button' id='button_delete-folder' class='btn btn-primary'>Hapus</button>
            </div>
        </div>
    </div>
</div>
</div>
<!-- General JS Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>

<script>
    var csrfName = "<?= csrf_token() ?>";
    var csrfHash = $('#txt_csrfname').val();

    function deleteGlobal(title, desc, size, id, link, page, btntext) {
        // Add response in Modal body
        $("#modal-size-delete").removeClass('modal-lg', 'modal-sm', 'modal-xl');
        $("#modal-size-delete").addClass(size);
        // Display Modal
        $('#modaldelete').modal('show');
        $('#modal-title-delete').text(title);
        $('#deleteModal').text(desc);
        $('#button_delete').text(btntext);
        $('#delete-id').append("<input type='hidden' id='id-delete' value='" + id + "'>");
        $('#delete-id').append("<input type='hidden' id='id-link' value='" + link + "'>");
        $('#delete-id').append("<input type='hidden' id='id-page' value='" + page + "'>");
    }

    function deleteFolder(title, size, id, directory, masterid, link, page) {
        $("#modal-size-delete-folder").removeClass('modal-lg', 'modal-sm', 'modal-xl');
        $("#modal-size-delete-folder").addClass(size);
        // Display Modal
        $('#modaldelete-folder').modal('show');
        $('#modal-title-delete-folder').text(title);
        $('#delete-id-folder').append("<input type='hidden' id='id-delete-folder' value='" + id + "'>");
        $('#delete-id-folder').append("<input type='hidden' id='id-link-folder' value='" + link + "'>");
        $('#delete-id-folder').append("<input type='hidden' id='id-page-folder' value='" + page + "'>");
        $('#delete-id-folder').append("<input type='hidden' id='id-directory-folder' value='" + directory + "'>");
        $('#delete-id-folder').append("<input type='hidden' id='id-masterid-folder' value='" + masterid + "'>");
    }

    function modalGlobal(title, size, link, datas = '') {
        $.ajax({
            url: link,
            type: 'post',
            data: datas,
            dataType: 'json',
            success: function(response) {
                $("#modal-size").removeClass('modal-lg', 'modal-sm', 'modal-xl');
                $("#modal-size").addClass(size);
                $('#bodycrud').html(response.view); // Display Modal
                $('#txt_csrfname').val(response.token);
                $('#modalcrud').modal('show');
                $('#modal_title').text(title);
            }
        });
    }

    $(document).ready(function() {

        $("#modaldelete").on("hidden.bs.modal", function() {
            $("#delete-id").html("");
            $("#modal-size-delete").removeClass('modal-lg', 'modal-sm', 'modal-xl');

        });

        $("#barsbutton").on('click', function() {
            var status = $(this).data('status');
            if (status == 'aktif') {
                $(this).removeData('status');
                $(this).attr('data-status', 'nonaktif');
                $("#datatabel").css({
                    "width": "1060px"
                });
            } else {
                $(this).removeData('status');
                $(this).attr('data-status', 'aktif');
                $("#datatabel").css({
                    "width": "870px"
                });
            }
        });
        $("#modaldelete-folder").on("hidden.bs.modal", function() {
            $("#delete-id-folder").html("");
            $("#modal-size-delete-folder").removeClass('modal-lg', 'modal-sm', 'modal-xl');
        });
        $("#modalcrud").on("hidden.bs.modal", function() {
            $(".modal-crud").html("");
            $("#modal-size").removeClass('modal-lg', 'modal-sm', 'modal-xl');
        });
        $('#button_delete').on('click', function() {
            var id = $('#id-delete').val();
            var link = $('#id-link').val();
            var page = $('#id-page').val();
            var data = {
                id: id
            }
            $.ajax({
                type: 'POST',
                url: link,
                data: data,
                success: function(response) {
                    if (response == '1') {
                        $.notify('Data has deleted', 'success');
                        setTimeout(function() {
                            table.ajax.reload();
                        }, 1);
                    } else {
                        $.notify('Failed to delete', 'error');
                    }
                    $('#modaldelete').modal('toggle');
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert('gagal');
                }
            });
        });
        $('#button_delete-folder').on('click', function() {
            var id = $('#id-delete-folder').val();
            var link = $('#id-link-folder').val();
            var page = $('#id-page-folder').val();
            var directory = $('#id-directory-folder').val();
            var masterid = $('#id-masterid-folder').val();
            var data = {
                id: id
            }
            $.ajax({
                type: 'post',
                url: link,
                data: {
                    id: id
                },
                success: function(response) {
                    if (response == '1') {
                        $.notify('Data Berhasil Dihapus', 'success');
                        setTimeout(function() {}, 1);
                        $('#modaldelete-folder').modal('toggle');
                        if (masterid == 0) {
                            $('#tabpanel').load("<?= base_url('workspace/folder') ?>");
                        } else {
                            $('#tabpanel').load("<?= base_url('workspace/detailFolder') ?>" + "/" + masterid + "/" + masterid);
                        }
                    } else {
                        $.notify('Data Gagal Dihapus', 'error');
                        setTimeout(function() {
                            window.location.href = e.redirect;
                        }, 1);
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError);
                }
            });
        });
    });

    var table = $('#datatabel').DataTable({
        serverSide: true,
        destroy: true,
        ajax: {
            type: 'post',
            url: '<?= current_url(true) . '/datatabel' ?>',
            data: function(param) {
                param[csrfName] = csrfHash;
                return param;
            }
        },
    });
    // setInterval(function() {
    // table.ajax.reload();
    // }, 1000);
</script>
<!-- Page Specific JS File -->
</body>

</html>