<div class="table-responsive">
    <table id="{{ $__datatableId }}" class="table table-bordered dt-responsive data-table" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    </table>
</div>

@push('js_stack')
    @php
     if (isset($__export)) {
        $__excel    = isset($__export['excel']) ? $__export['excel'] : '1,2,3,4';
        $__pdf      = isset($__export['pdf']) ? $__export['pdf'] : '1,2,3,4';
        $__print    = isset($__export['print']) ? $__export['print'] : '1,2,3,4';
     }
     else{
        $__excel    = '0,1,2,3,4,5,6,7,8,9,10';
        $__pdf      = '0,1,2,3,4,5,6,7,8,9,10';
        $__print    = '0,1,2,3,4,5,6,7,8,9,10';
     }

     $__cusomParam = isset($__cusomParam) && is_array($__cusomParam) ? $__cusomParam = http_build_query($__cusomParam, '', '&amp;') : '';

    @endphp
    <script>


        $(document).ready(function() {
            axiosInstance
                .get('{{ route('admin.datatable.source', $__datatableName) }}?show_columns=ok')
                .then(result => {
                    // console.log(result)
                    initTable(result.data);
                })
                .catch(error => {
                    console.log(error);
                    basicAlert('error on request')
                });

            function initTable(_columns) {



                window.dTable = $("#{{ isset($__datatableId) ? $__datatableId: 'datatable' }}").DataTable({
                    // dom: '<"html5buttons"B>lTfgitp',
                    dom: 'lTfgitp',
                      "language": {
                          "url": "https://cdn.datatables.net/plug-ins/1.12.1/i18n/az-AZ.json"
                    },
                    lengthChange: true,
                    "lengthMenu": [ [10, 25, 50, 100, 300,'-1'], ['10 Ədəd', '25 Ədəd', '50 Ədəd', '100 Ədəd', '300 Ədəd', 'Hamısı'] ],
                    // buttons: [{
                    //         extend: 'pdf',
                    //         text: '<i class="fas fa-file-pdf fa-1x" aria-hidden="true"></i> PDF'
                    //     },
                    //     {
                    //         extend: 'csv',
                    //         text: '<i class="fas fa-file-csv fa-1x"></i> CSV'
                    //     },
                    //     {
                    //         extend: 'excel',
                    //         text: '<i class="fas fa-file-excel" aria-hidden="true"></i> EXCEL'
                    //     },
                    
                    // ],
                    "ajax": {
                        url: "{{ route('admin.datatable.source', $__datatableName).'?'.$__cusomParam }}",
                        type: "GET", //POST
                        data: get_query()
                    },
                    // ajax: '{{ route('admin.datatable.source', $__datatableName).'?'.request()->getQueryString() }}',
                    columns: _columns,
                    serverSide: true,
                    responsive: false,
                    lengthChange: true,
                    processing: true,
                    order: [[0, 'desc']],
                    "columnDefs": [
                      {"className": "dt-center", "targets": "_all"},
                      { orderable: false, targets: [0] },
                      { targets: 'no-sort', orderable: false }
                    ],
                    "fnPreDrawCallback":function(){
                      //alert("Pre Draw");
                      setTimeout(function(){
                          initUiElements();
                      }, 1);
                      $('#dataTables_processing').attr('style', 'font-size: 20px; font-weight: bold; padding-bottom: 60px; display: block; z-index: 10000 !important');
                    }
                });

                // dTable.on('draw', function () {
                //     initToggleSwitch();
                // });

                window.dTable.buttons().container().appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)");
            }
        });
    </script>
@endpush
