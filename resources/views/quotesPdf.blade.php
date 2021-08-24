<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="{{config('app.url')}}/css/pdfstyle.css"> -->
    <style>
      html {
        -webkit-print-color-adjust: exact;
      }
      
      body{
          background: url('{{config("app.url")}}/images/sharon-mccutcheon.jpg');
          font-family: regularized;
          color: white;
      }

      .bg-dark-50{
          background-color: rgba(0, 0, 0, .5);
      }

      @font-face {
          font-family: italicized;
          src: url('{{config("app.url")}}/fonts/Khatija Calligraphy_0.ttf');
      }

      @font-face {
          font-family: regularized;
          src: url('{{config("app.url")}}/fonts/AvenirLTStd-Book_1.otf');
      }


      .italicized{
          font-family: italicized;
      }

      .regularized{
          font-family: regularized;
      }
    </style>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Fifth Angle Studios</title>
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col-md-8">
        <img class="img-fluid my-5" title="Wedding Photography" alt="Wedding Photography" src="{{config('app.url')}}/images/img1.png">
        <!-- <img class="" title="Wedding Photography" alt="Wedding Photography" src="{{config('app.url')}}/images/img2.png"> -->
        <!-- <img class="" title="Wedding Photography" alt="Wedding Photography" src="{{config('app.url')}}/images/img3.png"> -->
      </div>
      <div class="col-md-4">
        <img class="px-5" title="Wedding Photography specialists" alt="Wedding Photography specialists" src="{{config('app.url')}}/images/Logo.png">
      </div>
    </div>
    
    <div class="row">
      <h3 class="col-md-12 my-5 pt-5 italicized bold display-4 text-white">About Us</h3>
      <div class="col-md-12">
        <p>
          Established in the year 2015 by Manoj Nagarajan, Fifth Angle Studios continues to be striving, for one thing, i.e., making sure that every single moment of a wedding is captured beautifully and delivered to you with the very soul of it.
        </p>
        <p>We shoot and treat a lot of weddings a year, but for us, every single wedding is as significant as it is to you. Just because of that, we have been able to come where we are now and have a great record of client satisfaction. We cater to not just weddings but any event that asks for aesthetically captured memories.</p>
      </div>
    </div>
    <!-- <div class="d-flex justify-content-center my-5">
      <a href="http://fifthanglestudios.com" title="Fifth Angle Studios" class="text-center text-white lead" target="_blank">
        <img class="mk-desktop-logo light-logo" title="Wedding Photography specialists" alt="Wedding Photography specialists" src="http://fifthanglestudios.com/wp-content/uploads/2017/08/5thanglestudios.png">
        Fifth Angle Studios
      </a>
    </div> -->
    <h3 class=" my-5 py-5 italicized bold display-4 text-white">Quotation</h3>
  
    @foreach(json_decode($details->lead) as $value)
      <div class="row bg-dark-50 my-2">
      

        <table  class="table">
          <thead>
            <tr role="row" class="bg-dark-50">
              <th class="border-0 text-center bg-dark-50">Event - {{@$value->event_name->name}}</th>
              <th class="border-0 text-center bg-dark-50">Date - {{$value->event_date}}</th>
              <th class="border-0 text-center bg-dark-50">Location - {{$value->location}}</th>
            </tr>
          </thead>
        </table>
          
      
        @if( count($value->services) > 0 )
          @foreach($value->services as $serviceList)
            <!-- services table -->
            <table id="datatables-dashboard-projects" class="table text-dark mx-3">
              <thead>
                <tr role="row">
                  <th class="border-top-0">Service</th>
                  <th class="border-top-0">Qty</th>
                  <th class="border-top-0">Price</th>
                </tr>
              </thead>
              <tbody>
                <tr role="row" class="odd">
                  <td>{{$serviceList->service->name}}</td>
                  <td>{{$serviceList->unit}}</td>
                  <td>{{$serviceList->price}}</td>
                </tr>
                </tbody>
            </table>
          
          @endforeach
        @else
          <p class="text-center">No Services</p>
        @endif
      
      </div>
    @endforeach

    <div class="offset-md-6 col-md-6 my-5  bg-dark-50">
      <h3 class="font-weight-bold italicized border-bottom pt-4">Summary </h3>
      <div class="">
        <ul class="list-unstyled mb-4">
          <li class="d-flex justify-content-between py-1"><strong class="">Order Subtotal </strong><strong>{{$details->subTotal}}</strong></li>
          <li class="d-flex justify-content-between py-1"><strong class="">Adjustment</strong><strong>{{$details->quote->adjustment}}</strong></li>
          <li class="d-flex justify-content-between py-1"><strong class="">Discount</strong><strong>{{$details->quote->discount}}</strong></li>
          <li class="d-flex justify-content-between py-1"><strong class="">Tax</strong><strong>{{$details->quote->tax}}%</strong></li>
          <li class="d-flex justify-content-between py-1"><strong class="">Total</strong>
            <h5 class="font-weight-bold">{{$details->total_price}}</h5>
          </li>
        </ul>
      </div>
    </div>
  </div>
</body>

</html>