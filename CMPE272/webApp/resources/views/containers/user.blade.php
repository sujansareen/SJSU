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
        <div class="card card-body">
            <form class="form-inline" id="signinForm"  onsubmit="return false">
            <div class="form-group mx-sm-3 mb-4">
                <label for="inputPassword2" class="sr-only">sign in</label>
                <input type="text" name="email" class="form-control required" id="inputPassword2" placeholder="email">
            </div>
            <div class="form-group mx-sm-3 mb-4">
                <label for="inputPassword2" class="sr-only">password</label>
                <input type="password" name="password" class="form-control required" id="inputPassword2" placeholder="password">
            </div>
            <button type="submit" class="btn btn-primary mb-4">Sign In</button>
            </form>
        </div>

        <br />
        <br />
        <div class="card card-body" style="display:none">
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

        </div>

        <br />
        <br />
        <br />
        <div class="card card-body">
            <h4>Create an account</h4>
            <form id="userform" onsubmit="return false">
                <div class="form-group">
                    <label for="firstName">First Name</label>
                    <input type="text" name="first_name" class="form-control required" id="firstName" placeholder="First Name">
                </div>
                <div class="form-group">
                    <label for="lastName">Last Name</label>
                    <input type="text" name="last_name"  class="form-control required" id="lastName" placeholder="Last Name">
                </div>
                <div class="form-group">
                    <label for="homeAddress">Home address</label>
                    <input type="text" name="home_address"  class="form-control required" id="exampleInputPassword1" placeholder="Home address">
                </div>
                <div class="form-group">
                    <label for="homePhone">Home Phone</label>
                    <input type="tel" name="home_phone"  class="form-control" id="homePhone" placeholder="Home Phone">
                </div>
                <div class="form-group">
                    <label for="cellPhone">Cell phone</label>
                    <input type="tel" name="cell_phone"  class="form-control" id="cellPhone" placeholder="Cell Phone">
                </div>
                <br />

                <br />

                <div class="form-group">
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
                </div>
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
            //==========    Sign in
            $signinForm.submit(function(e) {
                var data = $signinForm.serializeArray().reduce(function(acc,curr){acc[curr.name] = curr.value; return acc;},{});
                console.log("sdfsdf: ",data)
                axios.post('/api/user/signin', data)
                        .then(function (response) {
                            console.log(response);
                            window.scrollTo(0,0);
                            $alertFound.show();
                            $alertFound.text('Signed In');
                            setTimeout(function(){
                                $alertFound.hide();
                            },4000)
                            $form[0].reset();
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
            

            //========== 


            $form.submit(function(e) {
                var data = $form.serializeArray().reduce(function(acc,curr){acc[curr.name] = curr.value; return acc;},{});
                console.log("sdfsdf: ",data)
                axios.post('/api/user', data)
                        .then(function (response) {
                            console.log(response);
                            window.scrollTo(0,0);
                            $alertSaved.show();
                            setTimeout(function(){
                                $alertSaved.hide();
                            },4000)
                            $form[0].reset();
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

            $searchForm.submit(function(e) {
                var data = $searchForm.serializeArray().reduce(function(acc,curr){acc[curr.name] = curr.value; return acc;},{});
                console.log("Search: ",data)
                axios.get('/api/user', { params: data })
                        .then(function (response) {
                            console.log(response);
                            window.scrollTo(0,0);
                            var user = response.data[0];
                            if(user){
                                $alertFound.show();
                                $alertFound.text(user.first_name);
                                $searchForm[0].reset();
                            } else {
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



