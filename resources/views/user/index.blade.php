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
        li{
          /* text-decoration: none; */
          /* list-style-type: none; */
          list-style: none;
        }

        </style>
    </head>
    <body>

      <div class="container">

        <div class="page-header text-primary pb-2 mt-4 mb-2">
          <h1>All Users</h1>
          <hr/>
        </div>

        <table class='table table-striped table-bordered bg-secondary' id='dc-table-chart' >
          <thead>
            <tr>
              <th>Index</th>
              <th>Telegram Id</th>
              <th> Name </th>
              <th> Messages</th>
              <th> Last Seen</th>
            </tr>
          </thead>
          <tbody>

          @foreach ($users as $user)

              <tr>
                <td>

                </td>
                <td>
                  {{ucfirst($user->telegram_id)}}
                </td>
                <td>
                 {{$user['first_name']}} &nbsp;{{$user['last_name']}}
                </td>
                <td>
                  {{$user->messages()->count()}}
                </td>
                <td>
                  {{date('d/m/Y',strtotime($user->messages()->latest()->first()->sent_on))}}
                </td>
                <td>
                  <ul>
                  <?php
                    $arr=$user->messages()->with('messagable')->get()->groupBy('messagable_type') ;
                    $count= $arr->map(function($item,$key){
                      return collect($item)->count();
                     });
                    foreach($count as $key=>$value){
                      $k = explode("\\",$key)[1];
                      echo "<li><strong>".$k.":&nbsp&nbsp</strong>".$value."</li>";
                    }

                   ?>
                 </ul>

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



        var prevNode = "";
        var prevRow = "";

        var datatable =$('#dc-table-chart').DataTable({

          "columnDefs": [ {
            "searchable": false,
            "orderable": false,
            "targets": 0
        } ,{
            "targets":5,
            "visible": false
        }],
        "order": [[ 4, 'desc' ]],
        "lengthMenu": [[5,10, 15,20, -1], [5, 10, 15,20, "All"]]
        });

        datatable.on( 'order.dt search.dt', function () {
       datatable.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
           cell.innerHTML = i+1;
       } );

   } ).draw();


          datatable.on('click', 'tr[role="row"]', function() {
              var tr = $(this);
              var row = datatable.row(tr);

              if (row.child.isShown()) {
                  // This row is already open - close it
                  row.child.hide();
                  tr.removeClass('shown');
              } else {
                  // Open this row
                  if (prevNode != "") {
                      prevNode.child.hide();
                      prevRow.removeClass('shown');
                  }
                  row.child(row.data()[5]).show();
                  tr.addClass('shown');
                  prevNode = row;
                  prevRow = tr;

              }
          });


        </script>
    </body>
</html>
