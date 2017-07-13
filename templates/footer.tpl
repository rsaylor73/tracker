        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; {$date} BLN</p>
                </div>
            </div>
        </footer>

    </div> <!-- end <div class="container"> -->
    <!-- /.container -->



    <script>
    $(function() {
        $( ".date" ).datepicker({ 
            dateFormat: "yy-mm-dd",
            changeMonth: true,
            changeYear: true,
            minDate: "-2Y", 
            maxDate: "+5Y"
        });
    });

    $(function() {
        $( ".date2" ).datepicker({ 
            dateFormat: "m/d/yy",
            changeMonth: true,
            changeYear: true,
            minDate: "-2Y", 
            maxDate: "+5Y"
        });
    });
    </script>

<!-- Modal -->
<div id="myModalWarning" class="modal fade" role="dialog">
    <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Warning: Your session will expire soon</h4>
        </div>
        <div class="modal-body">
            <p>Your session will expire in 5 minutes. To stay logged in click below. If you are working on something important click <b>CANCEL</b> and finish your task in less then 5 minutes.</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>&nbsp;
            <button type="button" onclick="repaint_screen()" class="btn btn-primary" data-dismiss="modal">Yes - Extend My Login</button>
        </div>

        <script>
        function repaint_screen() {
            extend_login();

            setTimeout(function() {
                window.location.reload();
            }
            ,2000);
        }

        function extend_login() {
            $.get('/ajax/extend_login.php',
            function(php_msg) {     
                $("#null").html(php_msg);
            });
        }
        </script>
    </div>
</div>

</body>

</html>