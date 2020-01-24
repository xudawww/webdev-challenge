<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
            table {
                border-collapse: collapse;
                width: 100%;
            }

            th, td {
            text-align: left;
            padding: 8px;
            }

            tr:nth-child(even) {background-color: #f2f2f2;}
            h1{position:absolute;top:200px;}
        </style>

       
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    </head>
    <body>
        <div class=" position-ref ">
            <div class="content">
                <form  id="upload_form"  enctype="multipart/form-data">
                    <div class="input-group">
                        <div class="custom-file" >  
                            <input type="file" name="csvfile" class="custom-file-input" id="inputGroupFile01" required >
                            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                        </div>
                        <div class="input-group-append">
                            <input type='submit' id='submitCsv' class="btn btn-outline-secondary">
                        </div>
                    </div>
                </form>
            </div>
        </div>
       
        
          @if (!empty ( $monthExpense ) )
             <h2 style='margin-top:50px'>Monthly Expense</h2>
            @endif
         <table style='margin-top:50px' border = "1">
            <tr>
            @if (!empty ( $monthExpense ) )
            <td>Month</td>
            <td>Expense</td>
        
            </tr>
            @endif
            @foreach ($monthExpense as $lot)
            <tr>
            <!-- use model  -->
            <td>{{ $lot->getMonthAndYear() }}</td>
            <td>{{ $lot-> getExpense()  }}</td>
           
           
            </tr>
            @endforeach
           
        </table>

        @if (!empty ( $categoryExpense ) )
             <h2 style='margin-top:50px'>Category Expense</h2>
            @endif
         <table style='margin-top:50px' border = "1">
            <tr>
            @if (!empty (  $categoryExpense ) )
            <td>Category</td>
            <td>Expense</td>
        
            </tr>
            @endif
            @foreach ($categoryExpense  as $lot)
            <tr>
            <!-- use model  -->
            <td>{{ $lot->getCateogry()}}</td>
            <td>{{ $lot-> getExpense()  }}</td>
           
           
            </tr>
            @endforeach
           
        </table>
        @if (!empty ( $lots ) )
           <h2 style='margin-top:50px'>All record</h2>
        @endif
         <table style='margin-top:50px' border = "1">
            <tr>
            @if (!empty ( $lots ) )
            <td>Date</td>
            <td>Category</td>
            <td>Lot Title</td>
            <td>Lot Location</td>
            <td>Lot Condition</td>
            <td>Pretax Amount</td>
            <td>Tax Name</td>
            <td>Tax Amount</td>
            </tr>
            @endif
            @foreach ($lots as $lot)
            <tr>
            
            <td>{{ $lot->getDate() }}</td>
            <td>{{ $lot->getCategory()}}</td>
            <td>{{ $lot->getLotTitle()}}</td>
            <td>{{ $lot->getlotLocation()}}</td>
            <td>{{ $lot->getCondition()}}</td>
            <td>{{ $lot->getPre_taxAmount()}}</td>
            <td>{{ $lot->getTax_Name()}}</td>
            <td>{{ $lot->getTaxAmount() }}</td>
           
            </tr>
            @endforeach
            @if (empty ( $lot ) )
              <h1>No data in table yet!</h1>
            @endif
        </table>
          
    </body>
</html>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
    $('#upload_form').submit( function(event){
        event.preventDefault();
            $.ajax({
                type:'POST',
                url:'importCSV',
                dataType:'JSON',
                data: new FormData(this),
                processData: false,
                contentType: false,
                success:function(data){
                    alert(data.success);
                    location.reload();},
                error: function (xhr, status, error) {
                    console.log(xhr.responseText);
            }});
    })




    // $("#submitCsv").click(function(e){
    //     e.preventDefault();
    //     var form_data = new FormData();
    //     form_data.append('csvfile', $('#inputGroupFile01').prop('files')[0]);
    //     sendAjax(form_data);
    // })
</script>
