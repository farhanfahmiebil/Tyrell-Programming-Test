


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

  <meta name="csrf-token" content="{{ csrf_token() }}">

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js" integrity="sha512-57oZ/vW8ANMjR/KQ6Be9v/+/h6bq9/l3f0Oc7vn6qMqyhvPd1cvKBRWWpzu0QoneImqr2SkmO4MSqU+RpHom3Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>

<div class="jumbotron text-center">
  <h1>Programming Test</h1>
  <p>Playing Cards</p>
</div>

<div class="container">
  <div class="card">
    <div class="card-header">
      Input Number
    </div>
    <div class="card-body">
      <form id="form_submit" method="GET">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group p-3">
              <label for="label_number_of_player">Enter number of people</label>
              <input type="number" name="numberofpeople" class="form-control" id="numberofpeople" aria-describedby="numberofpeople" min="1" placeholder="Enter Number of People" required>
            </div>
            <button type="button" id="btn_distribute" class="btn btn-primary">Submit</button>

          </div>
        </div>
      </form>

    </div>
  </div>


  <div class="card mt-4">
    <div class="card-header">
      Cards distribution
    </div>
    <div class="card-body">

      <table class="table table-bordered" id="table_cards">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Cards</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td colspan="2"><center>Please input number of people</center></td>
          </tr>
        </tbody>
      </table>

    </div>
  </div>

</div>

<script>
$(document).ready(function(){

  /**************************************************************************************
    Button Clicked
  **************************************************************************************/
  $("#btn_distribute").click(function(){
    //Set HTML
    var html_data = '';

    var html_loader  = '';

    //Get Data
    var input = $('#numberofpeople').val();

    if(input <1 || input>53){

      alert('Input value does not exist or value is invalid')

      //Set tbody Empty
      $("#table_cards > tbody").empty();

      //Start Table Row
      html_data +='<tr>';

      //No Data
      html_data +='<td class="text-center" colspan="6"> No data </td>';

      //End Table Row
      html_data +='</tr>';

      //Append HTML Data
      $('#table_cards > tbody:last-child').append(html_data);


    }else{

      getData({
        'numberofpeople':input
      });

    }

  });


  /**************************************************************************************
    Get Data
  **************************************************************************************/
  function getData(data){

    //Set Header
    $.ajaxSetup({
      'headers':{
        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
      }
    });

    //Set Request
    $.ajax({
      'type':'GET',
      'url':'{{ route("getdata") }}',
      'data':{
              'numberofpeople':data['numberofpeople'],
            },
      success:function(data){

        //Set HTML
        var html_data = '';

        if(data['error'] == false){

          //Set tbody
        $("#table_cards > tbody").empty();


          //Set Timeout
          setTimeout(function(){


              if($.isEmptyObject(data['output'])){

                //Start Table Row
                html_data +='<tr>';

                //No Data
                html_data +='<td class="text-center" colspan="6"> No data </td>';

                //End Table Row
                html_data +='</tr>';

                //Append HTML Data
                $('#table_cards > tbody:last-child').append(html_data);

              }

            else if(Object.keys(data['output']).length > 0){


              $.each(data['output'],function(key,value){

                //Start Table Row
                html_data +='<tr>';

                //Grade
                html_data +='<td>'+(key+1) +'</td>';

                //Employee ID
                html_data +='<td>'+(value) +'</td>';

                //End Table Row
                html_data +='</tr>';

              });

              //Append HTML Data
              $('#table_cards > tbody:last-child').append(html_data);

            }

          },1000);

        }else{

          alert(data['output'])
        }

      }
    });
  }


});
</script>


</body>
</html>
