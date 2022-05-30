  <form>
      <div class="form-group">
          <div class="container">
              <div class="row">
                  <div class="col-md-6">
                      <label for="usergroupid">Usergroup :</label>
                      <select name="usergroupid" id="usergroupid" required>
                      </select>
                  </div>
                  <div class="col-md-6" style="margin-top: 30px;">
                      <div class="form-group">
                          <button type="button" class="btn btn-success" id="button_add">ADD</button>
                      </div>
                  </div>
              </div>
              <input type="hidden" name="userid" value="<?= $userid ?>" id="userid">
          </div>
      </div>

      <table class="table table-bordered table-hover table-striped table-head-fixed" id="accessgrouptable">
          <thead>
              <tr>
                  <th>#</th>
                  <th>Usergroup</th>
                  <th>Menu</th>
                  <th>Action</th>
              </tr>
          </thead>
          <tbody>

          </tbody>
      </table>
  </form>
  <div class="modal-footer">
      <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
  </div>
  <script>
      $(document).ready(function() {
          $("#usergroupid").select2({
              ajax: {
                  url: '<?= base_url('user/getGroup') ?>',
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
      $('#button_add').on('click', function() {
          var usergroupid = $('#usergroupid').val();
          var userid = $('#userid').val();
          var data = {
              usergroupid: usergroupid,
              userid: userid
          }
          var link = "<?= base_url('user/accessData') ?>";
          var process = "tambah"
          $.ajax({
              type: 'post',
              url: link,
              data: data,
              success: function(response) {
                  if (response == '1') {
                      $.notify('Data Berhasil Di' + process, 'success');
                      setTimeout(function() {}, 100);
                      accessgrouptable.ajax.reload();
                  } else {
                      $.notify(response);
                      setTimeout(function() {
                          window.location.href = e.redirect;
                      }, 100);
                  }
              },
              error: function(xhr, ajaxOptions, thrownError) {
                  alert(thrownError);
              }
          });
      });
      var accessgrouptable = $('#accessgrouptable').DataTable({
          serverSide: true,
          destroy: true,
          ajax: {
              type: 'post',
              url: '<?= base_url('user/grouptableaccess/' . $userid) ?>',
              data: function(param) {
                  param[csrfName] = csrfHash;
                  return param;
              }
          },
      });

      function activated(accessgroupid, isactive) {
          var active = '';
          if (isactive == 't') {
              active = 'f';
          } else {
              active = 't';
          }
          var data = {
              accessgroupid: accessgroupid,
              active: active
          }
          var link = "<?= base_url('user/editaccessData') ?>";
          var process = "Edit"
          $.ajax({
              type: 'post',
              url: link,
              data: data,
              success: function(response) {
                  console.log(response);
                  if (response == '1') {
                      $.notify('Data Berhasil Di' + process, 'success');
                      setTimeout(function() {}, 100);
                      accessgrouptable.ajax.reload();
                  } else {
                      $.notify(response);
                      setTimeout(function() {
                          window.location.href = e.redirect;
                      }, 100);
                  }
              },
              error: function(xhr, ajaxOptions, thrownError) {
                  alert(thrownError);
              }
          });
      }

      function deleteAccess(accessgroupid) {
          var data = {
              accessgroupid: accessgroupid
          }
          var link = "<?= base_url('user/deleteaccessData') ?>";
          var process = "Hapus"
          $.ajax({
              type: 'post',
              url: link,
              data: data,
              success: function(response) {
                  if (response == '1') {
                      $.notify('Data Berhasil Di' + process, 'success');
                      setTimeout(function() {}, 100);
                      accessgrouptable.ajax.reload();
                  } else {
                      $.notify(response);
                      setTimeout(function() {
                          window.location.href = e.redirect;
                      }, 100);
                  }
              },
              error: function(xhr, ajaxOptions, thrownError) {
                  alert(thrownError);
              }
          });
      }
  </script>