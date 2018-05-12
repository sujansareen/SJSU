@extends('layouts.app')
@section('content')
    <br />
    <div class="container">
        <div class="alert alert-primary" id="founduser" style="display: none;" role="alert"></div>
        <div class="alert alert-primary" id="saveduser" style="display: none;" role="alert">
            Saved User
        </div>
        <div class="alert alert-danger" id="erroruser" style="display: none;" role="alert">
            Error
        </div>


        <div class="card card-body" >
            <form class="form-inline" id="searchform"  onsubmit="return false">
                <div class="form-group mx-sm-3 mb-4">
                    <label for="inputPassword2" class="sr-only">search</label>
                    <input type="text" name="search" class="form-control required" id="inputPassword2" placeholder="search">
                </div>
                <div class="form-group mx-sm-3 mb-4">
                    <label for="inputState" class="sr-only">Field</label>

                    <select id="inputState" name="field" class="form-control">
                        <option value="first_name" selected>first_name</option> 
                        <option value="last_name">last_name</option> 
                        <option value="email">email</option>
                        <option value="cell_phone">cell_phone</option> 
                        <option value="home_phone">home_phone</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary mb-4">Search</button>
            </form>
            <div class="table-responsive">
                <table id="user-table" class="table" style="display: none;">
                    <thead>
                    <tr>
                        <th scope="col">First</th>
                        <th scope="col">Last</th>
                        <th scope="col">email</th>
                    </tr>
                    </thead>
                    <tbody id="user-table-body">
                    </tbody>
                </table>
            </div>
            {{--   user row template --}}
            <table class="table" style="display: none;" >
                <tr id="userRowTemplate" >
                    <td class="first-name" >Mark</td>
                    <td class="last-name" >Otto</td>
                    <td class="email" >@mdomdomdomdomdomdo</td>
                </tr>
            </table>
        </div>

        <br />
        <br />
        <br />
        <div class="card card-body">
            <h4>Update account</h4>
            <form id="userform" onsubmit="return false">
                <div class="form-group">
                    <label for="firstName">First Name</label>
                    <input type="text" name="first_name" class="form-control required" id="firstName" placeholder="First Name" value="{{$user['first_name']}}">
                </div>
                <div class="form-group">
                    <label for="lastName">Last Name</label>
                    <input type="text" name="last_name"  class="form-control required" id="lastName" placeholder="Last Name"value="{{$user['last_name']}}">
                </div>
                <div class="form-group">
                    <label for="homeAddress">Home address</label>
                    <input type="text" name="home_address"  class="form-control required" id="exampleInputPassword1" placeholder="Home address" value="{{$user['home_address']}}">
                </div>
                <div class="form-group">
                    <label for="homePhone">Home Phone</label>
                    <input type="tel" name="home_phone"  class="form-control" id="homePhone" placeholder="Home Phone" value="{{$user['home_phone']}}">
                </div>
                <div class="form-group">
                    <label for="cellPhone">Cell phone</label>
                    <input type="tel" name="cell_phone"  class="form-control" id="cellPhone" placeholder="Cell Phone"value="{{$user['cell_phone']}}">
                </div>
                <br />

                <br />

<!--                 <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" name="email"  class="form-control required" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                </div>
                <div class="form-group">
                    <label for="inputPassword4">Password</label>
                    <input type="password" name="password"  id="inputPassword4" class="form-control required" aria-describedby="passwordHelpInline">
                    <small id="passwordHelpInline" class="text-muted">
                        Must be 8-20 characters long.
                    </small>
                </div> -->
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
        <script>
            var $form =  $("#userform");
            var $signinForm =  $("#signinForm");
            var $searchForm =  $("#searchform");

            var $alertSaved =  $("#saveduser");
            var $alertFound =  $("#founduser");
            var $alertError =  $("#erroruser");
            var $userTable  =  $('#user-table');

            var user = getCookie("user") || {};
            if(!user.value){
                $signinForm.parent().show();
            } else {
                $searchForm.parent().show();
            }
            

            //========== 


            $form.submit(function(e) {
                var data = $form.serializeArray().reduce(function(acc,curr){acc[curr.name] = curr.value; return acc;},{});
                axios.put('/api/users/'+ '{{$user_id}}' , data)
                        .then(function (response) {
                            console.log(response);
                            window.scrollTo(0,0);
                            $('#sign-in-li').hide();
                            $alertSaved.show();
                            setTimeout(function(){
                                $alertSaved.hide();
                            },4000)
                        })
                        .catch(function (error) {
                            console.log(error);
                            $alertError.show();
                            window.scrollTo(0,0);

                            setTimeout(function(){
                                $alertError.hide();
                            },4000)
                        });

                e.preventDefault(); // avoid to execute the actual submit of the form.
            });

            //=====Search
            function renderUserRow(data){
                if(data && data.first_name){
                    var $row = $('#userRowTemplate').clone();
                    $row.attr('id', '');
                    $row.attr('data-id', data.id||'');
                    $row.find('.first-name').text(data.first_name||'');
                    $row.find('.last-name').text(data.last_name||'');
                    $row.find('.email').text(data.email||'');
                    $row.show();
                }
                return $row;
            }
            $searchForm.submit(function(e) {
                var data = $searchForm.serializeArray().reduce(function(acc,curr){acc[curr.name] = curr.value; return acc;},{});
                console.log("Search: ",data);
                $('#user-table-body').html('');
                axios.get('/api/users', { params: data })
                        .then(function (response) {
                            console.log(response);
                            window.scrollTo(0,0);
                            var users = response.data;
                            if(users.length){
                                var $rows = users.map(renderUserRow);
                                $('#user-table-body').html($rows);
                                $userTable.show();
                                $alertFound.show();
                                $alertFound.text("Found: " + users.length + " users" );
                                $searchForm[0].reset();
                            } else {
                                $userTable.hide();
                                $alertFound.text('No One Found');

                            }
                            setTimeout(function(){
                                $alertFound.hide();
                                $alertFound.text('');
                            },4000)
                        })
                        .catch(function (error) {
                            console.log(error);
                            $alertError.show();
                            window.scrollTo(0,0);

                            setTimeout(function(){
                                $alertError.hide();
                            },4000)
                        });

                e.preventDefault(); // avoid to execute the actual submit of the form.
            });
        </script>
    </div>
@endsection
@section('header')
    @component('components.header')
    @endcomponent
@endsection



