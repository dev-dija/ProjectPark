<!-- Main Footer -->
  <footer class="main-footer">
    <!-- Default to the left -->
    <strong>Copyright &copy; <span id="curyear">2017</span> <a href="../index.php">ProjectPark</a>.</strong> All rights reserved.
  </footer>
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- jQuery DataTables -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<!-- DataTables BootStrap -->
<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="plugins/morris/morris.min.js"></script>

<script type="text/javascript">
// DataTable parametres
  $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
  });
// LINE CHART
var line = new Morris.Line({
  element: 'line-chart',
  resize: true,
  data: [
    {y: '2011 Q1', item1: 2666},
    {y: '2011 Q2', item1: 2778},
    {y: '2011 Q3', item1: 4912},
    {y: '2011 Q4', item1: 3767},
    {y: '2012 Q1', item1: 6810},
    {y: '2012 Q2', item1: 5670},
    {y: '2012 Q3', item1: 4820},
    {y: '2012 Q4', item1: 15073},
    {y: '2013 Q1', item1: 10687},
    {y: '2013 Q2', item1: 8432}
  ],
  xkey: 'y',
  ykeys: ['item1'],
  labels: ['Item 1'],
  lineColors: ['#3c8dbc'],
  hideHover: 'auto'
});
</script>
</body>
</html>
