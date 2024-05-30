$(function() {
    $('.transaction-table').DataTable({
        ajax: {
            url: '/admin/api/transaction-history/' + profile_steamid,
            dataSrc: ''
        },
        columns: [
            {
                data: 'id',
                width: "29%"
            },
            {
                data: 'change',
                width: "30%"
            },
            {
                data: 'reason',
                width: "30%"
            },
            {
                data: 'transaction_date',
                width: "30%"
            }
        ],
        order: [[0, 'desc']],
        pagingType: 'simple'
    });
});