var dataTable = $('#user_data').DataTable({
    "lengthMenu": [[10, 25, 50,100, -1], [10, 25, 50,100, "All"]],
    select: true,
    buttons: [
            {
                extend:'print',
                repeatingHead: {
                logo: 'https://www.google.co.in/logos/doodles/2018/world-cup-2018-day-22-5384495837478912-s.png',
                logoPosition: 'right',
                logoStyle: '',
                title: ''
            },
                messageTop: 'The information in this table is copyright to Sirius Cybernetics Corp.',
                exportOptions: {
                    stripHtml: false
                },
                title: ''
            }
        ],
    "processing":true,
    "serverSide":true,
    "order":[],
    "ajax":{
        url:"fetch_secretary_beneficairy.php",
        type:"POST"
    },
    "columnDefs":[
        {
            "targets":[0, 3, 3],
            "orderable":false,
        },
    ],

});