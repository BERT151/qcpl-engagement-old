<!-- jquery cdn -->
<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
<!-- jquery datatable js cdn -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="assets/js/index.js"></script>


<script type="text/javascript">
    let table = new DataTable('#datatable');
    $(document).ready( function () {
        $('#datatable').DataTable({
            "responsive": false, 
            "lengthChange": true, 
            "autoWidth": false,
            "searching": true,
            "paging": true,
            "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
            "iDisplayLength": 10,
            "ordering": true,
        });
    } );

    document.addEventListener("DOMContentLoaded", function() {
        const activePage = window.location.pathname;
        const sidebarLinks = document.querySelectorAll('aside .sidebar a');

        sidebarLinks.forEach(link => {
            // Use includes() to match partial URLs
            if (activePage.includes(link.getAttribute("href"))) {
            link.classList.add('active');
            }
        });
    });
</script>
