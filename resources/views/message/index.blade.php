<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link type="text/css" href="{{asset('css/dc.css')}}" rel="stylesheet"/>
      	<!-- <link type="text/css" href="{{asset('css/leaflet-legend.css')}}" rel="stylesheet"/> -->
      	<link type="text/css" href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet"/>
        <!-- <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">


        <!-- Styles -->
        <style>
        body{
      		/* background-image: url( "{{asset('images/background.jpg')}}"); */
      		background-color: white;
      		background-size: cover;
      		backface-visibility: hidden;
      	}

        </style>
    </head>
    <body>

      <div class="container">

        <div class="page-header text-primary pb-2 mt-4 mb-2">
          <h1>All Messages</h1>
          <hr/>
        </div>

        <table class='table table-striped table-bordered bg-secondary' id='dc-table-chart' >
          <thead>
            <tr>
              <th>Index</th>
              <th>Message Id</th>
              <th> From </th>
              <th> Type</th>
              <th> Date</th>
            </tr>
          </thead>
          <tbody>

          @foreach ($data as $message)

              <tr>
                <td>

                </td>
                <td>
                  {{ucfirst($message->tel_msg_id)}}
                </td>
                <td>
                <a href="">  {{$message->user['first_name']}}</a>
                </td>
                <td>
                  {{$message->messagable_type}}
                </td>
                <td>
                  {{date('d/m/Y',strtotime($message->sent_on))}}
                </td>
              </tr>

          @endforeach
        </tbody>
        </table>

      </div>






        <script type="text/javascript" src="{{asset('js/jquery.min.js')}}"></script>
        <script type="text/javascript" src='https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js'></script>
        <script type="text/javascript" src='https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js'></script>




        <script>



        var datatable =$('#dc-table-chart').DataTable({

          "columnDefs": [ {
            "searchable": false,
            "orderable": false,
            "targets": 0
        } ],
        "order": [[ 1, 'asc' ]],
        "lengthMenu": [[5,10, 15,20, -1], [5, 10, 15,20, "All"]]
        });

        datatable.on( 'order.dt search.dt', function () {
       datatable.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
           cell.innerHTML = i+1;
       } );
   } ).draw();


        </script>
    </body>
</html>
