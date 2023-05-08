<section class="content">
    <div class="row">
      <div class="col-12">
                
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Hover Export Data Table</h3>
            <h6 class="box-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table id="example" class="table table-bordered table-hover display nowrap margin-top-10 table-responsive" cellspacing="0" width="100%">
              <thead>
                  <tr>
                      <th>LGA</th>
                      <th>Number of Citizens</th>
                      <th>Action</th>
                  </tr>
              </thead>
              <tfoot>
                  <tr>
                  <th>LGA</th>
                      <th>Number of Citizens</th>
                      <th>Action</th>
                  </tr>
              </tfoot>
              <?php echo getPopSize()?>
          </table>

            
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->          
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
  <script src="./assets/vendor_components/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="./assets/vendor_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
	
	<script src="./js/template.js"></script>
	
	<script src="./js/demo.js"></script>
	
	<!-- This is data table -->
    <script src="./assets/vendor_plugins/DataTables-1.10.15/media/js/jquery.dataTables.min.js"></script>
    
    <!-- start - This is for export functionality only -->
    <script src="./assets/vendor_plugins/DataTables-1.10.15/extensions/Buttons/js/dataTables.buttons.min.js"></script>
    <script src="./assets/vendor_plugins/DataTables-1.10.15/extensions/Buttons/js/buttons.flash.min.js"></script>
    <script src="./assets/vendor_plugins/DataTables-1.10.15/ex-js/jszip.min.js"></script>
    <script src="./assets/vendor_plugins/DataTables-1.10.15/ex-js/pdfmake.min.js"></script>
    <script src="./assets/vendor_plugins/DataTables-1.10.15/ex-js/vfs_fonts.js"></script>
    <script src="./assets/vendor_plugins/DataTables-1.10.15/extensions/Buttons/js/buttons.html5.min.js"></script>
    <script src="./assets/vendor_plugins/DataTables-1.10.15/extensions/Buttons/js/buttons.print.min.js"></script>
    <!-- end - This is for export functionality only -->
	
	<!-- mínimo admin for Data Table -->
	<script src="./js/pages/data-table.js"></script>
