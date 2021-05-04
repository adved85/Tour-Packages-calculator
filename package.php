<?php
if (!isset($_GET['p']) || $_GET['p'] < 1 || $_GET['p'] > 6) {
  // header('Location: /tours');
  die('<h4> please, add package number as a get parameter like this ?p=1</h4>');
} else {
  $tour_number = $_GET['p'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tour Packages calculator for best-holiday.am</title>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" type="text/css">
  <link rel="stylesheet" href="/css/calculate_package.css" type="text/css">
  <script>
    const tourNumber = Number('<?= $tour_number; ?>')
  </script>
</head>

<body id="bg">

  <div class="bg-primary m-b100">
    <!-- <div class="block-17 pt-3 pb-4"> -->
    <div class="container p-t30 p-b20">

      <ul class="list-group list-group-flush list-of-discount">
        <li class="list-group-item">Get 15% discount when ordering 60 days in advance</li>
        <li class="list-group-item">Get 10% discount when ordering a package for more than two people</li>
        <li class="list-group-item">Children under 5 get 100% discount</li>
        <li class="list-group-item">Children between 5-18 get 50% discount</li>
      </ul>

      <form name="chechinForm" onsubmit="submitCheckin(event)" id="chechinForm">
        <div class="d-lg-flex mb-3 justify-content-around">
          <div class="one-third as-label">Check-in date:
            <input type="text" name="checkinDate" id="checkin_date" class="form-control" placeholder="d-m-y" value="<?= date('m/d/Y', strtotime('+6 days')) ?>">
          </div>
          <div class="one-third as-label">Travelers:
            <input type="number" value="1" min="1" pattern="\d+" name="travelers" id="travelers" onchange="changeTravelers()" class="form-control">
          </div>
          <div class="one-third as-label">Children:
            <input type="number" value="0" min="0" pattern="\d+" name="children" id="children" onchange="changeChildren()" class="form-control">
          </div>
        </div>

        <div id="ageWrap" class="d-lg-flex flex-wrap mb-3 mx-4 justify-content-around">
          <!-- Age Fields Container -->
        </div>
        <div class="border-top my-3 container"></div>

        <div class="d-lg-flex mb-3 justify-content-center">
          <!-- Place to stay: START -->
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="placeType" id="apartment" onchange="changePlaceBox(event)">
            <label class="form-check-label" for="apartment">
              Apartment 50 &euro;
            </label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="placeType" id="private" onchange="changePlaceBox(event)">
            <label class="form-check-label" for="private">
              Private house 100 &euro;
            </label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="placeType" id="hotel" onchange="changePlaceBox(event)">
            <label class="form-check-label" for="hotel">
              Hotel 150 &euro;
            </label>
          </div>
        </div>
        <div class="border-top my-3 container"></div> <!-- Place to stay: END -->

        <div class="d-lg-flex mb-3 justify-content-around">
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="packType" id="allInclusive" onchange="changePackBox(event)">
            <label class="form-check-label" for="allInclusive">
              All Inclusive 1000 &euro;
            </label><i data-toggle="modal" class="fa fa-info-circle textTypeOfficialMessages2" name="All_Inclusive_text" data-target="#anasunTextTypeOfficialMessages1"></i>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="packType" id="allUltra" onchange="changePackBox(event)">
            <label class="form-check-label" for="allUltra">
              Ultra all Inclusive 2000 &euro;
            </label><i data-toggle="modal" class="fa fa-info-circle textTypeOfficialMessages2" name="Ultra_All_Inclusive_text" data-target="#anasunTextTypeOfficialMessages2"></i>
          </div>
          <div class="form-check form-check-inline">
            <!-- <input class="form-check-input" type="checkbox" value="" id="defaultCheck1"> -->
            <input class="form-check-input" type="checkbox" name="packType" id="allCrazzy" onchange="changePackBox(event)">
            <label class="form-check-label" for="allCrazzy">
              Crazy All Inclusive 2000 &euro;
            </label><i data-toggle="modal" class="fa fa-info-circle textTypeOfficialMessages2" name="Crazzy_All_Inclusive_text" data-target="#anasunTextTypeOfficialMessages3"></i>
          </div>
        </div>

      </form>

      <div class="border-top my-3 container">
        <div class="col-md-6 mx-auto">
          <div class="text-white ">Days:
            <span id="day-nums"></span>
          </div>
          <div class="text-white ">Price:
            <span id="day-price"></span><span>&euro; per day</span>
          </div>
          <div class="text-white ">Discounts:
            <span id="discounts">0</span><span>%</span>
          </div>
          <div id="form-message" class="text-danger font-weight-bold bg-warning mx-auto text-center w-50"></div>
        </div>
      </div>

      <div class="d-flex mb-3 justify-content-center">
        <div class="input-group mb-3 col-md-7">
          <div class="input-group-prepend">
            <span id="span_summary" class="littleFontSize input-group-text">Summary:</span>
          </div>
          <input type="text" class="littleFontSize" aria-label="amount" value="" id="summary" readonly>
          <div class="input-group-append">
            <span id="float" class="littleFontSize input-group-text">
              .00
              <select id="curr_is" class="littleFontSize input-group-text" onchange="changeCurrency()">
                <option value="euro">&euro;</option>
                <option value="dollar">&dollar;</option>
              </select>
            </span>
          </div>
          <button id="button_book_now" type="submit" class="littleFontSize btn btn-submit" data-toggle="modal" data-target="#book_now">Book Now!</button>
        </div>
      </div>

      <!-- <div class="myjumbotron text-center">
        <div class="container">
          <h3 class="lead text-muted">For more discounts You can contact with us by:</h3>
        </div>
      </div> -->
      <div class="card mx-auto" style="max-width: 35rem;">
        <div class="card-body">
          <h5 class="card-title mb-3">For more discounts You can contact with us by:</h5>
          <h6 class="card-subtitle mb-2 text-muted">Phone Number: <a class="greenHover" href="tel:+37491221140">+374 91 22-11-40</a> Viber, Whatsapp</h6>
          <h6 class="card-subtitle mb-2 text-muted">E-mail address: <a class="greenHover" href="mailto:info.b.holiday@gmail.com">info.b.holiday@gmail.com</a></h6>
        </div>
      </div>


    </div>
  </div>

  <div id="footer"></div>

  <div class="modal fade" id="book_now" role="dialog">
    <div class="modal-dialog book_now_modal">
      <div class="modal-content book_now_modal_body">
        <div class="modal-header p-1 bg-success">
          <h2 style="color: white" class="m-auto">Book Now</h2>
          <button type="button" class="m-0 close" data-dismiss="modal">&times;</button>
        </div>
        <div style="z-index: 150000000;" class="modal-body">
          <div class="bootstrap-iso">
            <div class="container-fluid">
              <div class="row">
                <div class="col-md-10 col-sm-10 col-xs-12 mx-auto">
                  <form onsubmit="bookSubmit(event)">
                    <div class="form-group ">
                      <label class="control-label requiredField  text-black-100" for="name">
                        Full Name
                        <span class="asteriskField">
                          *
                        </span>
                      </label>
                      <input class="form-control" id="name" name="name" placeholder="Andy Brown" type="text" required />
                      <div class="book-error-msg"></div>
                    </div>
                    <div class="form-group ">
                      <label class="control-label requiredField text-black-100" for="email">
                        Email
                        <span class="asteriskField">
                          *
                        </span>
                      </label>
                      <input class="form-control" id="email" name="email" placeholder="andy@mail.com" type="text" required />
                      <div class="book-error-msg"></div>
                    </div>
                    <div class="form-group ">
                      <label class="control-label requiredField text-black-100" for="tel">
                        Phone Number
                        <span class="asteriskField">
                          *
                        </span>
                      </label>
                      <input class="form-control" id="tel" name="tel" placeholder="+374-11-22-33-44" type="text" required />
                      <div class="book-error-msg"></div>
                    </div>
                    <div class="form-group" id="div_messengerbox">
                      <label class="control-label text-black-100" for="messengerbox">
                        Specify the messenger that supports your phone
                      </label>
                      <div class="d-flex">
                        <div class="col-md-3">
                          <label class="checkbox-inline text-black-100">
                            <input style="margin-left: -16px !important; opacity: 1;" name="messengerbox" type="checkbox" value="Viber" />
                            Viber
                          </label>
                        </div>
                        <div class="col-md-4">
                          <label class="checkbox-inline text-black-100">
                            <input style="margin-left: -16px !important; opacity: 1;" name="messengerbox" type="checkbox" value="WhatsApp" />
                            WhatsApp
                          </label>
                        </div>
                        <div class="col-md-4">
                          <label class="checkbox-inline text-black-100">
                            <input style="margin-left: -16px !important; opacity: 1;" name="messengerbox" type="checkbox" value="Telegram" />
                            Telegram
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div>
                        <button class="btn btn-primary text-black-100 greenHoverBackground" name="submit" type="submit">
                          Submit
                        </button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- JAVASCRIPT FILES ========================================= -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script>

  <script src="/js/calculate_package.js?v=1120"></script>

</body>
</html>