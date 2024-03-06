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
                        if(data.perdin.start_date === data.perdin.end_date) {
                            return moment(data.perdin.start_date).format('DD/MM/YYYY')
                        } else {
                            return `${moment(data.perdin.start_date).format('DD/MM/YYYY')} - ${moment(data.perdin.end_date).format('DD/MM/YYYY')}`
                        }

                    }

                },
                {
                    data:'perdin.user.name',
                    name:'perdin.user.name',
                },
                {
                    data: 'perdin.project',
                    name: 'perdin.project',
                },
                {
                    data: 'perdin.agenda',
                    name: 'perdin.agenda',
                },
                {
                    data: null,
                    name: 'is_checked',
                    render: function(data, row) {
                        if(data.is_checked == 1) {
                            return `<span class="badge badge-soft-success">Verified</span>`;
                        } else {
                            return `<span class="badge badge-soft-danger">Unverified</span>`;
                        }

                    }
                },
                {
                    data: null,
                    name:'action',
                    render:function(data, row) {
                        return `<a class="btn btn-sm btn-info" href="{{url('/dashboard/detail')}}/${data.perdin.id}">View</a>`;
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
