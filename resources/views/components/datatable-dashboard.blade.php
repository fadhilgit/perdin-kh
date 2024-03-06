@push('scripts')
<script src="{{ asset('') }}public/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{ asset('') }}public/assets/plugins/datatables/dataTables.bootstrap4.js"></script>
<script>
    $(document).ready(function() {
        $('#table-perdin').DataTable({
            serverSide:true,
            processing: true,
            scrollX: true,
            columns: [
                {
                    data: null,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: null,
                    name: 'start_date',
                    render: function(data, type) {
                        if(data.start_date === data.end_date) {
                            return moment(data.start_date).format('DD/MM/YYYY')
                        } else {
                            return `${moment(data.start_date).format('DD/MM/YYYY')} - ${moment(data.end_date).format('DD/MM/YYYY')}`
                        }

                    }

                },
                {
                    data: 'project',
                    name: 'project',
                },
                {
                    data: 'agenda',
                    name: 'agenda',
                },
                {
                    data: null,
                    name: 'status',
                    render: function(data, row) {
                        if(data.status === null) {
                            return "-"
                        } else if(data.status === 'diperiksa') {
                            return `<span class="badge badge-soft-danger">Proses Pemeriksaan</span>`
                        } else if(data.status === 'diketahui') {
                            return `<span class="badge badge-soft-warning">Diketahui Mjr. DKA & PMO</span>`
                        } else if(data.status === 'disposisi') {
                            return `<span class="badge badge-soft-success">Terkirim Pada Sekretariat</span>`
                        }
                    }

                },
                {
                    data: null,
                    name:'action',
                    render:function(data, row) {
                        return `<a class="btn btn-sm btn-info" href="{{url('/dashboard/detail')}}/${data.id}">View</a>`;
                    }
                },
            ],
            order: [
                [0,'asc']
            ]
        })
    })
</script>
@endpush
