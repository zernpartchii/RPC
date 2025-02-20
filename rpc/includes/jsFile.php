<script src="js/jquery-3.5.1.js"></script>
<!-- <script src="js/bootstrap.bundle.min.js"></script> -->
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap5.min.js"></script>

<script>
    //Research Data Table
    $(document).ready(function() {
        $('#example').DataTable({
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
            paging: false
        });
    });

    //Report Data Table
    $(document).ready(function() {
        $('#example1').DataTable({
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
            paging: false
        });
    });

    //Zone Data Table
    $(document).ready(function() {
        $('#example2').DataTable({
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
            paging: false
        });
    });

    //Program Data Table
    $(document).ready(function() {
        $('#example3').DataTable({
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
            paging: false
        });
    });

    //Delete Data
    $(document).ready(function() {

        $('.delete_btn').on('click', function() {

            $('#deleteResearchModal').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function() {
                return $(this).text();
            }).get();

            console.log(data);

            $('#delete_id').val(data[1]);
            $('#delete_id1').val(data[1]);

        });

    });

    //Settings Add Zone Modal Function
    $(document).ready(function() {

        $('.addZone_btn').on('click', function() {

            $('#AddZoneModal').modal('show');

        });

    });

    //Settings Update Zone Modal Function
    $(document).ready(function() {

        $('.updateZone_btn').on('click', function() {

            $('#UpdateZoneModal').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function() {
                return $(this).text();
            }).get();

            console.log(data);

            $('#update_Zone_id').val(data[0]);
            $('#UpdateDepartment').val(data[1]);

        });

    });

    //Settings Add Program Modal Function
    $(document).ready(function() {

        $('.addProgram_btn').on('click', function() {

            $('#AddProgramModal').modal('show');

        });

    });

    //Settings Update Program Modal Function
    $(document).ready(function() {

        $('.updateProgram_btn').on('click', function() {

            $('#UpdateProgramModal').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function() {
                return $(this).text();
            }).get();

            console.log(data);

            $('#update_Program_id').val(data[0]);
            $('#Zone_id').val(data[1]);
            $('#updateZone').val(data[1]);
            $('#UpdateProgram').val(data[3]);

        });

    });

    //Delete Zone
    $(document).ready(function() {

        $('.deleteZone_btn').on('click', function() {

            $('#deleteZoneModal').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function() {
                return $(this).text();
            }).get();

            console.log(data);

            $('#delete_Zone_id').val(data[0]);
            $('#delete_Zone').val(data[1]);
            $('#delete_Zone1').val(data[1]);

        });

    });

    //Delete Program
    $(document).ready(function() {

        $('.deleteProgram_btn').on('click', function() {

            $('#deleteProgramModal').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function() {
                return $(this).text();
            }).get();

            console.log(data);

            $('#delete_Program_id').val(data[0]);
            $('#delete_Program').val(data[3]);
            $('#delete_Program1').val(data[3]);

        });

    });
</script>