    </div>
    <script src="./assets/vendors/jquery/dist/jquery.min.js" type="text/javascript"></script>
    <script src="./assets/vendors/popper.js/dist/umd/popper.min.js" type="text/javascript"></script>
    <script src="./assets/vendors/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="./assets/vendors/metisMenu/dist/metisMenu.min.js" type="text/javascript"></script>
    <script src="./assets/vendors/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- PAGE LEVEL PLUGINS-->
    <script src="./assets/vendors/select2/dist/js/select2.full.min.js" type="text/javascript"></script>
    <script src="./assets/vendors/chart.js/dist/Chart.min.js" type="text/javascript"></script>
    <script src="./assets/vendors/jvectormap/jquery-jvectormap-2.0.3.min.js" type="text/javascript"></script>
    <script src="./assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
    <script src="./assets/vendors/jvectormap/jquery-jvectormap-us-aea-en.js" type="text/javascript"></script>
    <script src="./assets/vendors/DataTables/datatables.min.js" type="text/javascript"></script>
    <script src="./assets/vendors/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
    <script src="./assets/vendors/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
    <!-- CORE SCRIPTS-->
    <script src="assets/js/app.min.js" type="text/javascript"></script>
    <!-- PAGE LEVEL SCRIPTS-->
    <script src="./assets/js/scripts/jquery.table2excel.js" type="text/javascript"></script>
    <script src="./assets/js/scripts/dashboard_1_demo.js" type="text/javascript"></script>
    <script src="./assets/js/scripts/form-plugins.js" type="text/javascript"></script>
    <script>
        $(document).ready(function() {
            $(this).scrollTop(0);
        });
        var user_type = "<?php echo $_SESSION['user_type'] ?>";

        if (user_type == "member") {
            // take body to change the content
            const body = document.getElementsByTagName('body');
            // stop keyboard shortcuts
            window.addEventListener("keydown", (event) => {
                if (event.ctrlKey && (event.key === "S" || event.key === "s")) {
                    event.preventDefault();
                }

                if (event.ctrlKey && (event.key === "C")) {
                    event.preventDefault();
                }
                if (event.ctrlKey && (event.key === "E" || event.key === "e")) {
                    event.preventDefault();
                }
                if (event.ctrlKey && (event.key === "I" || event.key === "i")) {
                    event.preventDefault();
                }
                if (event.ctrlKey && (event.key === "K" || event.key === "k")) {
                    event.preventDefault();
                }
                if (event.ctrlKey && (event.key === "U" || event.key === "u")) {
                    event.preventDefault();
                }
            });
            // stop right click
            document.addEventListener('contextmenu', function(e) {
                e.preventDefault();
            });
            
            $(document).keydown(function (event) {
                if (event.keyCode == 123) {
                    return false;
                }
                else if ((event.ctrlKey && event.shiftKey && event.keyCode == 73) || (event.ctrlKey && event.shiftKey && event.keyCode == 74)) {
                    return false;
                }
            });
        }
    </script>
    </body>

    </html>