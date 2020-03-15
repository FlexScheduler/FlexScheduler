<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">

    <title>Student Scheduler</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/pricing/">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <link href="style/style.css" rel="stylesheet">

    <style>
      .btn-primary {
        background-color:#B6A267;
        outline: black;
        border-color: black;
      }
      .btn:hover {
      background-color: white; /* Green */
      color:black;
      border-color: #B6A267;
      }
    </style>
  </head>

  <body>
    <!-- This is the start of the headerbar -->
    <div style="color:black;emphasis:bold;size:26px;"class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-red border-bottom box-shadow" >
      <img style="width:7%;padding-right:5px;"src="../../img/lindenwood.png">
      <h5 class="my-0 mr-md-auto font-weight-normal">Student Scheduler</h5>
      <a style="margin:5px;"class="btn btn-primary" href="https://www.lindenwood.edu">Back to lindenwood</a>
      <a class="btn btn-primary" href="tempLogin.php">Admin Login</a>
    </div>
    <!-- This is the end of the header -->

    <div class="container-fluid" style="max-width:75%">
        <div class="card-deck mb-3 text-center">
          <div class="col-md-6">
          <div class="card mb-2 box-shadow">
            <div class="card-header">
              <h4 class="my-0 font-weight-normal">Schedule Filters</h4>
            </div>
            <div class="card-body">
              <ul class="list-unstyled mt-3 mb-4">
                <li>
                  <div class="form-group">
                   <label for="exampleFormControlSelect1">Select Semester</label>
                   <select class="form-control">
                     <option>Spring</option>
                     <option>Summer</option>
                     <option>Fall</option>
                   </select>
                 </div>
                </li>
                <li>
                  <div class="form-group">
                   <label for="exampleFormControlSelect1">Select Minimum Credit Hours</label>
                   <select class="form-control">
		     <option>1</option>
		     <option>2</option>
                     <option>3</option>
                     <option>4</option>
                     <option>5</option>
                     <option>6</option>
                     <option>7</option>
                     <option>8</option>
                     <option>9</option>
                     <option>10</option>
                     <option>11</option>
                     <option selected>12</option>
                     <option>13</option>
                     <option>14</option>
                     <option>15</option>
                     <option>16</option>
                     <option>17</option>
                     <option>18</option>
		     <option>19</option>
		     <option>20</option>
		     <option>21</option>
		     <option>22</option>
		     <option>23</option>
		     <option>24</option>
                   </select>
                 </div>
                </li>
                <li>
                  <div class="form-group">
                   <label for="exampleFormControlSelect1">Select Maximum Credit Hours</label>
                   <select class="form-control">
                     <option>1</option>
		     <option>2</option>
                     <option>3</option>
                     <option>4</option>
                     <option>5</option>
                     <option>6</option>
                     <option>7</option>
                     <option>8</option>
                     <option>9</option>
                     <option>10</option>
                     <option>11</option>
                     <option>12</option>
                     <option>13</option>
                     <option>14</option>
                     <option>15</option>
                     <option>16</option>
                     <option>17</option>
                     <option selected>18</option>
		     <option>19</option>
		     <option>20</option>
		     <option>21</option>
		     <option>22</option>
		     <option>23</option>
		     <option>24</option>
                   </select>
                 </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="card mb-2 box-shadow">
            <div class="card-header">
              <h4 class="my-0 font-weight-normal">Breaks</h4>
              <button class="btn btn-primary" data-toggle="modal" data-target="#breakModal">Add Break</button>
            </div>
            <div class="card-body">
              <div id="break-table" class="table-editable">
                        <span class="table-add float-right mb-3 mr-2"><a href="#!" class="text-success"><i
                              class="fas fa-plus fa-2x" aria-hidden="true"></i></a></span>
                        <table class="table table-bordered table-responsive-md table-striped text-center">
                          <thead>
                            <tr>
                              <th class="text-center">Name</th>
                              <th class="text-center">Days</th>
                              <th class="text-center">Start</th>
							  <th class="text-center">End</th>
                              <th class="text-center"></th>
                            </tr>
                          </thead>
                          <tbody id="break-table-body">
                            <tr>


                            </tr>

                          </tbody>
                        </table>
                      </div>
              </ul>
            </div>
          </div>
        </div>

        </div>



    </div>
    <div class="container-fluid" style="max-width:75%">
      <div class="card-deck mb-3 text-center">

        <div class="col-lg-12">
          <div class="card mb-6 box-shadow">
            <div class="card-header">
              <h4 class="my-0 font-weight-normal">Courses Shopping Cart</h4>
            </div>
            <div class="card-body">
              <ul class="list-unstyled mt-3 mb-4">
                <li>

                  <!-- Editable table -->

                      <div id="table" class="table-editable">
                        <span class="table-add float-right mb-3 mr-2"><a href="#!" class="text-success"><i
                              class="fas fa-plus fa-2x" aria-hidden="true"></i></a></span>
                        <table class="table table-bordered table-responsive-md table-striped text-center">
                          <thead>
                            <tr>
                              <th class="text-center">Course Number</th>
                              <th class="text-center">Course name</th>
                              <th class="text-center">Instructor</th>
                              <th class="text-center"></th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td class="pt-3-half" contenteditable="true">CSC14400</td>
                              <td class="pt-3-half" contenteditable="true">Computer Science 1</td>
                              <td class="pt-3-half" contenteditable="true">Blythe</td>
                              <td>
                                <span class="table-remove"><button type="button" onclick = "remClass(this);"
                                    class="btn btn-danger btn-rounded btn-sm my-0">Remove</button></span>
                              </td>
                            </tr>
                            <!-- This is our clonable table line -->


                          </tbody>
                        </table>
                      </div>

                  <!-- Editable table -->
                </li>

              </ul>
            </div>
          </div>
        </div>
      </div>
      </div>

      <!-- Modal -->
      <div class="modal fade" id="breakModal" tabindex="-1" role="dialog" aria-labelledby="breakModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="breakModalLabel">Add Break</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="container">
                <form>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-sm-3">
                          <label for="breakName">Break Name</label>
                        </div>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="breakName">
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-3">
                            <label for="breakName">Start Time</label>
                        </div>
                        <div class="col-sm-3">
                          <select class="form-control" id="startHour">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                            <option>6</option>
                            <option>7</option>
                            <option>8</option>
                            <option>9</option>
                            <option>10</option>
                            <option>11</option>
                            <option>12</option>
                          </select>
                        </div>
                        <div class="col-sm-3">
                          <select class="form-control" id="startMinute">
                            <option>00</option>
                            <option>15</option>
                            <option>30</option>
                            <option>45</option>
                          </select>
                        </div>
                        <div class="col-sm-3">
                          <select class="form-control" id="startPeriod">
                            <option>AM</option>
                            <option>PM</option>

                          </select>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-3">
                            <label for="breakName">End Time</label>
                        </div>
                        <div class="col-sm-3">
                          <select class="form-control" id="endHour">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                            <option>6</option>
                            <option>7</option>
                            <option>8</option>
                            <option>9</option>
                            <option>10</option>
                            <option>11</option>
                            <option>12</option>
                          </select>
                        </div>
                        <div class="col-sm-3">
                          <select class="form-control" id="endMinute">
                            <option>00</option>
                            <option>15</option>
                            <option>30</option>
                            <option>45</option>
                          </select>
                        </div>
                        <div class="col-sm-3">
                          <select class="form-control" id="endPeriod">
                            <option>AM</option>
                            <option>PM</option>

                          </select>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-3">
                          <label for="breakName">Day</label>
                        </div>
                        <div class="col-sm-9">
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="Monday" id="breakDay1">
							<label class="form-check-label" for="breakDay1">
							Monday
							</label>
						  </div>
						  <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="Tuesday" id="breakDay2">
							<label class="form-check-label" for="breakDay2">
							Tuesday
							</label>
						  </div>
						  <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="Wednesday" id="breakDay3">
							<label class="form-check-label" for="breakDay1">
							Wednesday
							</label>
						  </div>
						  <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="Thursday" id="breakDay4">
							<label class="form-check-label" for="breakDay4">
							Thursday
							</label>
						 </div>
						 <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="Friday" id="breakDay5">
							<label class="form-check-label" for="breakDay5">
							Friday
							</label>
                         </div>
                        </div>
                      </div>

                   </div>
                </form>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" onclick = "breakSubmit()">Submit</button>
            </div>
          </div>
        </div>
      </div>



    </div>
    <div class="container-fluid" style="max-width:75%">
      <button style="margin-bottom: 5%;" class="btn-block btn btn-primary">Generate</button>
    </div>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script>
      Holder.addTheme('thumb', {
        bg: '#55595c',
        fg: '#eceeef',
        text: 'Thumbnail'
      });
    </script>
    <script src="../lib/javascript/break_submit.js"></script>
  </body>
</html>